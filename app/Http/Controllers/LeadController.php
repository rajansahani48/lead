<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Lead;
use App\Models\User;
use App\Models\UserCampaign;

class LeadController extends Controller
{
    //filtering req  leads for telecaller
    public function index(Request $request)
    {
        $campaigndetail = UserCampaign::where('telecaller_id', auth()->user()->id)->pluck('campaign_id')->toArray();
        $campaigndetail = Campaign::whereIn('id', $campaigndetail)->get()->toArray();
        $count = 0;
        $storCampaignId = [];
        $storCampaignName = [];
        foreach ($campaigndetail as $key => $value) {
            $storCampaignId[$count] = $value['id'];
            $storCampaignName[$count] = $value['campaign_name'];
            $count++;
        }
        $finalArray = [];
        foreach ($storCampaignId as $key => $value) {
            $finalArray[$value] = $storCampaignName[$key];
        }
        if (count($request->toArray()) > 0) {
            if ($request->campaign_id && $request->status)
                $leadsDetails = Lead::where('campaign_id', '=', $request->campaign_id)->where('telecaller_id', '=', auth()->user()->id)->where('status', '=', $request->status)->paginate(10);
            else if ($request->status)
                $leadsDetails = Lead::where('telecaller_id', '=', auth()->user()->id)->where('status', '=', $request->status)->paginate(10);
            else
                return view('telecallermodule.showassignleads')->with('finalArray', $finalArray);
            $campaigName = Campaign::where('id', $request->campaign_id)->pluck('campaign_name');
            $data = [
                'leadsDetails' => $leadsDetails,
                'campaignId' => $request->campaign_id,
                'finalArray' => $finalArray,
                'campaigName' => $campaigName,
                'status' => $request->status,
            ];
            return view('telecallermodule.showassignleads')->with($data);
        } else
            return view('telecallermodule.showassignleads')->with('finalArray', $finalArray);
    }


    //for viewing the profile
    public function showprofile($id)
    {
        $telecallerdetails = User::where('id', $id)->get()->toArray();
        return view('telecallermodule.showprofile')->with('telecallerdetails', $telecallerdetails);
    }

    public function store(Request $request, $id)
    {
        $campid = UserCampaign::where('campaign_id', $id);
        Lead::create(['campaign_id' => $id, 'name' => $request->name, 'email' => $request->email, 'phone' => $request->phone]);
        return redirect('/campaign')->with('message', 'Inserted successfuly');
    }

    //uploading a single lead
    public function uploadLead(Request $request)
    {
        $getStorePhones = Lead::where('campaign_id', $request->campaign_id)->pluck('phone')->toArray();
        if (collect($getStorePhones)->contains($request->phone))
            return response()->json(['leadAlert' => 'Lead Already Exists!']);
        else {
            Lead::create(['campaign_id' => $request->campaign_id, 'telecaller_id' => $request->leadusermodal, 'name' => $request->name, 'email' => $request->email, 'phone' => $request->phone]);
            return response()->json(['LeadMessage' => 'Lead Inserted Succesfully']);
        }

    }
}
