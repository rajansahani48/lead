<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;
use App\Models\UserCampaign;
use App\services\CsvUpload;

class CsvController extends Controller
{
    protected $csvupload;
    //uploadign csv file
    public function upload(Request $request)
    {
        //for getting number of telecaller working in this campaign
        $countOfTelecaller=UserCampaign::where('campaign_id',$request->campaign_id)->count();

        //if there is  telecaller available into this campaign then u can insert leads
        if($countOfTelecaller>0)
        {
            if ($_FILES['file']['name'] != '') {
                $file_array = explode(".", $_FILES['file']['name']);

                //storing the extension
                $extension = end($file_array);

                //if file type is csv then only it will go in if
                if ($extension === 'csv') {
                    $file_data = fopen($_FILES['file']['tmp_name'], 'r');
                    $file_header = fgetcsv($file_data);

                    //if your csv file is empty then it will throw response
                    if(($file_header[0])===null)
                        return response()->json(['blankCsv' => 'Csv File is Empty']);

                }//when u choose non-csv file then it will throw error
                else {
                    $error = 'Only <b>.csv</b> file allowed';
                    return response()->json(['wrongfile' => 'PLease choose Only CSV File']);
                }
            }
            //csv header will store first row(columns) of csv file
            return response()->json(['csvheader' => $file_header]);
        }
        //if there is no more telecaller available into this campaign then u can not insert leads
        else
            return response()->json(['telecallerEmpty' => 'There is no more Telecaller in this campaign']);
    }
    public function __construct(CsvUpload $csvupload)
    {
        $this->csvupload=$csvupload;
    }
    //importing csv file
    public function import(Request $request,CsvUpload $csvupload)
    {

        $leadColumnArray = explode(",", $request->storLeadColumnName);
        $csvColumnArray = explode(",", $request->storCsvColumnName);

        //if phone is not selected
        if($leadColumnArray[0]!="phone" &&$leadColumnArray[1]!="phone" && $leadColumnArray[2]!="phone")
            return response()->json(['choosePhone' => 'Phone Field is necessary']);

        //creating pair of key value for csv mapping
        $finalArray = [];
        foreach ($leadColumnArray as $key => $value) {
            $finalArray[$value] = $csvColumnArray[$key];
        }
        //storing  file and reading file
        $leads=$csvupload->save($request->file);

        $count = count($leads);
        $storeArray = [];
        $countFaildArray=0;

        //for round robin lead allocation according to  name in asceding order
        $telecallerList=UserCampaign::where('campaign_id',$request->campaign_id)->pluck('telecaller_id')->toArray();
        $telecallerList=User::whereIn('id',$telecallerList)->orderBy('name')->pluck('id')->toArray();
        $telecallerIndex = 0;
        $flage=true;

        //if your csv file don't have column name then flage will false
        if($request->csvfirstRow=="true")
        {
            $startIndex=0;
            $flage=false;
        }
        else
            $startIndex=1;

        //csv mapping
        for ($i = $startIndex; $i < $count; $i++) {
            foreach ($leads[$i] as $leadIndex => $leadVal) {
                foreach ($finalArray as $key => $value) {
                    if ($value == $leadIndex)
                        $storeArray[$key] = $leadVal;
                }
            }
            $storeArray['campaign_id'] = $request->campaign_id;
            $storeArray['telecaller_id'] = $telecallerList[$telecallerIndex];

            $getStorePhones=Lead::where('campaign_id',$request->campaign_id)->pluck('phone')->toArray();
            $collection = collect($getStorePhones);
            if($collection->contains($storeArray['phone'])==true)
                $countFaildArray++;
            else {
                    Lead::create($storeArray);
                    $telecallerIndex++;
                    $telecallerIndex = isset($telecallerList[$telecallerIndex]) ? $telecallerIndex : 0;
            }

            // deleting the stored file
            $this->csvupload->deleteFile($request->file->getClientOriginalName());
        }

        if(!$flage){
            $rec=$count-$countFaildArray;
            return response()->json(['messgae' => 'imported successfully','rec'=>$rec,'count'=>$count]);
        }
        else{
            $rec=($count-1)-$countFaildArray;
            return response()->json(['messgae' => 'imported successfully','rec'=>$rec,'count'=>$count-1]);
        }
    }
}
