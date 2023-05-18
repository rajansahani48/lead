<?php
namespace App\Http\Controllers;
use App\Models\UserCampaign;
use App\Models\Lead;

class UserCampaignController extends Controller
{
    //for deleting telecaller in specific campaign
    public function destroy($campaign_id,$telecaller_id)
    {
        $checkLeadsPending = Lead::where('campaign_id', $campaign_id)->where('status', 'pending')->get()->toArray();
        $getCountOfTelecaller = UserCampaign::where('campaign_id', $campaign_id)->pluck('telecaller_id')->toArray();
        $getCountOfTelecaller = count(collect($getCountOfTelecaller)->unique()->toArray());

        if ($getCountOfTelecaller > 1) {
            //storing which leads assigned to this telecaller
            $getLeads = Lead::where('campaign_id', $campaign_id)->where('telecaller_id', $telecaller_id)->whereNotIn('status', ['converted'])->get()->toArray();
            //geting the telecaller who is assigned into this except current
            $getAssignedTelecaller = UserCampaign::where('campaign_id', $campaign_id)->where('telecaller_id', '!=',$telecaller_id)->pluck('telecaller_id')->toArray();
            $getAssignedTelecaller = collect($getAssignedTelecaller)->unique()->toArray();
            $telecallerIndex = 0;
            $assignedLeads=[];
            foreach ($getLeads as $keys => $values) {
                Lead::create(['campaign_id' => $campaign_id, 'telecaller_id' => $getAssignedTelecaller[$telecallerIndex], 'name' => $values['name'], 'email' => $values['email'], 'phone' => $values['phone'], 'status' => $values['status']]);
                $assignedLeads[$keys]=$values['id'];
                $telecallerIndex++;
                $telecallerIndex = isset($getAssignedTelecaller[$telecallerIndex]) ? $telecallerIndex : 0;
            }
            Lead::whereIn('id',$assignedLeads)->delete();

            UserCampaign::where('campaign_id', $campaign_id)->where('telecaller_id', $telecaller_id)->delete();

            return response()->json(['deleteTelecaller' => ' Telecaller Deleted Successfully!!']);
        } else if ($getCountOfTelecaller == 1 && count($checkLeadsPending) > 0)
            return response()->json(['deleteTelecallerError' => 'You can"t Delete this Telecaller due to incomplete task!!']);
        else if ($getCountOfTelecaller == 1 && count($checkLeadsPending) == 0) {
            UserCampaign::where('campaign_id', $campaign_id)->where('telecaller_id', $telecaller_id)->delete();
            return response()->json(['deleteTelecaller' => ' Telecaller Deleted Successfully!!']);
        }
    }
}
