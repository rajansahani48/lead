<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\User;
use App\Models\UserCampaign;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Models\Lead;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //this will execute with many relationship as mentioned
    public function index()
    {
        $columns = ['name', 'email', 'phone'];
        $camp = Campaign::with('hasManyLeads', 'PendingLeads', 'ProccedLeads', 'CampaignHasUser')->paginate(5);
        $campaingUser = User::where('role', 'telecaller')->orderBy('name')->get();
        $data = [
            'camp' => $camp,
            'columns' => $columns,
            'campaingUser' => $campaingUser
        ];
        return view('campaigns.campaigns')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //while campaign creation telecaller name will show in asc order
        $camp = User::where('role', 'telecaller')->orderBy('name')->get();
        return view('campaigns.addcampaigns')->with('camp', $camp);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //whenver campaign created then it will affect in campaign as well as bridge table between user and campaign named ->usercampaign
    public function store(StoreCampaignRequest $request)
    {
        $request->validated();
        $camp = Campaign::create($request->all());
        foreach ($request->telecaller_id as $key => $value) {
            $camp->CampaignHasUser()->attach($value);
        }
        return redirect('/campaign')->with('message', 'Campaign created successfuly!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //for showing who is working in particular campaign
    public function show($id)
    {
        $campaignName = Campaign::where('id', $id)->pluck('campaign_name')->toArray();
        $campid = UserCampaign::where('campaign_id', $id)->paginate(5);

        $data = [
            'campid' => $campid,
            'campaignName' => $campaignName,
        ];
        return view('campaigns.showcampaigns')->with($data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //for editing the campaign you can add telecaller as well while editing
    public function edit($id)
    {
        $camp = Campaign::with('CampaignHasUser')->find($id); {
            $storeId = [];
            $count = 0;
            foreach ($camp->CampaignHasUser as $key => $value) {
                $storeId[$count] = $value->id;
                $count++;
            }
            $campid = User::where('role', 'telecaller')->whereNotIn('id', $storeId)->orderBy('name')->get();
            $data = [
                'camp' => $camp,
                'campid' => $campid,
            ];
            return response()->json(['camp' => $camp, 'campid' => $campid]);
        }
        // return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //updating the campaign
    public function update(UpdateCampaignRequest $request, $id)
    {
        //if user add any telecaller then if part will execute while edit campaign
        if ($request->telecaller_id) {
            $request->validated();
            Campaign::where('id', $request->campaign_id)->update(['campaign_name' => $request['campaign_name'], 'campaign_desc' => $request['campaign_desc'], 'cost_per_lead' => $request['cost_per_lead'], 'conversion_cost' => $request['conversion_cost']]);
            foreach ($request->telecaller_id as $key => $value) {
                UserCampaign::create(['campaign_id' => $request->campaign_id, 'telecaller_id' => $value]);
            }
            return response()->json(['campaignUpdated' => 'Campaign Updated Successfully!!']);
        }
        //if user didn't add any telecaller then else part will execute while edit campaign
        else {
            Campaign::where('id', $request->campaign_id)->update(['campaign_name' => $request['campaign_name'], 'campaign_desc' => $request['campaign_desc'], 'cost_per_lead' => $request['cost_per_lead'], 'conversion_cost' => $request['conversion_cost']]);
            return response()->json(['campaignUpdated' => 'Campaign Updated Successfully!!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //deleting campaign
    public function destroy($id)
    {
        //if current campaign have pending leads then you can't delete this campaign so if will execute
        $countLeads = Lead::where('campaign_id', $id)->whereNotIn('status', ['converted'])->get()->toArray();
        if (count($countLeads) > 0)
            return response()->json(['deleteCampaignError' => 'You can"t Delete this Campaign due to incomplete task!!']);

        //if campagin don't have pendign leads then it will simply delete from campaign and bridge table usercampaign
        else {
            $campId = Campaign::findOrFail($id);
            $campId->CampaignHasUser()->detach();
            $campId->delete();
            return response()->json(['deleteCampaign' => 'Campaign Deleted Successfully!!']);
        }
    }

    //inserting single lead via modal for specific telecaller
    public function getCampaignUser($campaignId)
    {
        $campaigndetails = UserCampaign::where('campaign_id', $campaignId)->get();
        //userarray will store name of list who is working into this campaign
        $usersArray = [];
        foreach ($campaigndetails as $key => $value) {
            $usersArray[] = [
                'id' => $value->telecaller_id,
                'name' => $value->user->name
            ];
        }
        return response()->json(['usersArray' => $usersArray]);
    }

    //for showing bar-chart of campaign status
    public function dashboardchart()
    {
        $camp = Campaign::with('PendingLeads', 'inProgressLeads', 'onHoldLeads', 'ProccedLeads')->paginate(4);
        //leadsData will store all kind of leads as a 2D Array
        $leadsData = [];
        $counter = 0;
        foreach ($camp as $key => $val) {
            $count = 0;
            $leadsData[$counter][$count] = count($val->PendingLeads);
            $count++;
            $leadsData[$counter][$count] = count($val->inProgressLeads);
            $count++;
            $leadsData[$counter][$count] = count($val->onHoldLeads);
            $count++;
            $leadsData[$counter][$count] = count($val->ProccedLeads);
            $counter++;
        }
        $data = [
            'camp' => $camp,
            'leadsData' => $leadsData,
        ];
        return view('campaigns.dashboardchart')->with($data);
    }
}
