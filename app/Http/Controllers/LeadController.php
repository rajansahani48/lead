<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Lead;
use App\Models\User;
use App\Models\UserCampaign;
use App\Models\TransactionHistory;
use App\Http\Requests\StoreTelecallerRequest;

class LeadController extends Controller
{
    //filtering req  leads for telecaller
    public function index(Request $request)
    {
        $campaigndetail=UserCampaign::where('telecaller_id',auth()->user()->id)->pluck('campaign_id')->toArray();
        $campaigndetail = \DB::table('campaigns')->whereIn('id', $campaigndetail)->get()->toArray();
        $count=0;
        $storCampaignId=[];
        $storCampaignName=[];
        foreach ($campaigndetail as $key => $value) {
            $storCampaignId[$count]=$value->id;
            $storCampaignName[$count]=$value->campaign_name;
            $count++;
        }
        $finalArray = [];
        foreach ($storCampaignId as $key => $value) {
            $finalArray[$value] = $storCampaignName[$key];
        }
        return view('telecallermodule.showassignleads')->with('finalArray',$finalArray);
    }

    //showing filter leads by selected by telecaller
    public function showLeadDetails(Request $request)
    {
        $campaigndetail=UserCampaign::where('telecaller_id',auth()->user()->id)->pluck('campaign_id')->toArray();
        $campaigndetail = \DB::table('campaigns')->whereIn('id', $campaigndetail)->get()->toArray();
        $count=0;
        $storCampaignId=[];
        $storCampaignName=[];
        foreach ($campaigndetail as $key => $value) {
            $storCampaignId[$count]=$value->id;
            $storCampaignName[$count]=$value->campaign_name;
            $count++;
        }
        $finalArray = [];
        foreach ($storCampaignId as $key => $value) {
            $finalArray[$value] = $storCampaignName[$key];
        }
        $leadsDetails = Lead::where('campaign_id', '=',$request->campaign_id)->where('telecaller_id', '=', auth()->user()->id)->where('status', '=',$request->status)->get();
        $campaignId=$request->campaign_id;
        return view('telecallermodule.showassignleads')->with('leadsDetails',$leadsDetails)->with('finalArray',$finalArray)->with('campaignId',$campaignId);
    }

    //for viewing the profile
    public function showprofile($id)
    {
        $telecallerdetails=User::where('id',$id)->get()->toArray();
        return view('telecallermodule.showprofile')->with('telecallerdetails',$telecallerdetails);
    }

    public function store(Request $request,$id)
    {
        $campid=UserCampaign::where('campaign_id',$id);
        Lead::create(['campaign_id'=>$id,'name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone]);
        return redirect('/campaign')->with('message','Inserted successfuly');
    }

    //uploading a single lead
    public function uploadLead(Request $request)
    {
        $getStorePhones=Lead::where('campaign_id',$request->campaign_id)->pluck('phone')->toArray();
        if(collect($getStorePhones)->contains($request->phone)===true)
            return response()->json(['leadAlert' =>'Lead Already Exists!']);
        else
        {
            Lead::create(['campaign_id' => $request->campaign_id, 'telecaller_id' => $request->leadusermodal,'name' => $request->name, 'email' => $request->email,'phone'=>$request->phone]);
            return response()->json(['LeadMessage' =>'Lead Inserted Succesfully']);
        }

    }
}

