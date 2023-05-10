<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\UserCampaign;
use App\Models\Lead;
class UserCampaignController extends Controller
{
    //for deleting telecaller in specific campaign
    public function destroy($id)
    {
        $getTelecallerId=UserCampaign::where('id',$id)->pluck('telecaller_id')->toArray();
        $getCampaignId=UserCampaign::where('id',$id)->pluck('campaign_id')->toArray();
        $checkLeadsPending=Lead::where('campaign_id',$getCampaignId)->where('status','pending')->get()->toArray();
        $getCountOfTelecaller=UserCampaign::where('campaign_id',$getCampaignId)->pluck('telecaller_id')->toArray();
        $getCountOfTelecaller=count(collect($getCountOfTelecaller)->unique()->toArray());
        if( $getCountOfTelecaller>1)
        {
            //storing which leads assigned to this telecaller
            $getLeads=Lead::where('campaign_id',$getCampaignId)->where('telecaller_id',$getTelecallerId)->whereNotIn('status',['converted'])->get()->toArray();
            //geting who is assigned into this except current
            $getAssignedTelecaller=Lead::where('campaign_id',$getCampaignId)->whereNotIn('telecaller_id',$getTelecallerId)->pluck('telecaller_id')->toArray();
            $getAssignedTelecaller  = collect($getAssignedTelecaller)->unique()->toArray();
            $telecallerIndex = 0;
            foreach ($getLeads as $keys => $values) {
                Lead::create(['campaign_id' =>$getCampaignId[0],'telecaller_id' =>$getAssignedTelecaller[$telecallerIndex],'name'=>$values['name'],'email'=>$values['email'],'phone'=>$values['phone'],'status'=>$values['status']]);
                $telecallerIndex++;
                $telecallerIndex = isset($getAssignedTelecaller[$telecallerIndex]) ? $telecallerIndex : 0;
            }
            foreach ($getLeads as $key => $value) {
                $deleteLeads=Lead::findOrFail($value['id'])->delete();
            }
            $usercomp=UserCampaign::findOrFail($id)->delete();
            return response()->json(['deleteTelecaller' => ' Telecaller Deleted Successfully!!']);
        }
        else if($getCountOfTelecaller==1 &&  count($checkLeadsPending)>0)
            return response()->json(['deleteTelecallerError' => 'You can"t Delete this Telecaller due to incomplete task!!']);
        else if($getCountOfTelecaller==1 &&  count($checkLeadsPending)==0)
        {
            $usercomp=UserCampaign::findOrFail($id)->delete();
            return response()->json(['deleteTelecaller' => ' Telecaller Deleted Successfully!!']);
        }
    }
}

