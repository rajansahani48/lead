<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lead;
use App\Models\Campaign;
use App\Models\TransactionHistory;
use App\Http\Requests\StoreTelecallerRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\updateTelecallerRequest;
use Exception;

class TeleCallerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $obj = User::where('role', 'telecaller')->paginate(10);
        return view('telecaller.telecaller')->with('obj', $obj);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('telecaller.addtelecaller');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $emailList = User::pluck('email');
        if (collect($emailList)->contains($request->email))
            return response()->json(['userAlreadyExists' => 'User exist!!']);
        else {
            User::create(['name' => $request->name, 'email' => $request->email, 'password' => \Hash::make($request->password), 'phone' => $request->phone, 'country_code' => $request->country_code, 'address' => $request->address]);
            return response()->json(['telecallerCreated' => 'Telecaller Created Successfully!!']);
        }
        // return redirect('/telecaller')->with('message','Telecaller Created successfuly');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $obj = User::find($id);
        return view('telecaller.showtelecaller')->with('obj', $obj);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $obj = User::find($id);
        return response()->json(['obj' => $obj]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $emailList = User::whereNotIn('id', [$request->id])->pluck('email');
        if (collect($emailList)->contains($request->email)) {
            $obj = User::find($request->id);
            return response()->json(['userAlreadyExists' => 'User Already Exists !!', 'obj' => $obj]);
        } else {
            if($request->password)
            User::where('id', $request->id)->update(['name' => $request['name'], 'email' => $request['email'], 'password' => \Hash::make($request['password']), 'phone' => $request['phone'], 'country_code' => $request['countrycode'], 'address' => $request['address']]);
            else
            User::where('id', $request->id)->update(['name' => $request['name'], 'email' => $request['email'], 'phone' => $request['phone'], 'country_code' => $request['countrycode'], 'address' => $request['address']]);
            return response()->json(['telecallerUpdated' => 'Telecaller Updated Successfully!!']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //if current telecaller have pending leads then you can't delete this telecaller so if will execute
        $getLeads = Lead::where('telecaller_id', $id)->whereNotIn('status', ['converted'])->get()->toArray();
        if (count($getLeads) > 0)
            return response()->json(['deleteTelecallerError' => 'You can"t Delete this Telecaller due to incomplete task!!']);

        //if telecaller don't have pending leads then it will simply delete this telecaller and bridge table usercampaign
        else {
            $telecallerId = User::findOrFail($id);
            $telecallerId->userHasCampaign()->detach();
            $telecallerId->delete();
            return response()->json(['deleteTelecaller' => ' Telecaller Deleted Successfully!!']);
        }
    }
    //wallet details and transaction history
    public function wallet()
    {
        $transaction = TransactionHistory::where('telecaller_id', auth()->user()->id)->latest()->paginate(10);
        $walletAmount = TransactionHistory::where('telecaller_id', auth()->user()->id)->pluck('amount');
        $totalAmoutOfWallet = 0;
        foreach ($walletAmount as $key => $value) {
            $totalAmoutOfWallet = $totalAmoutOfWallet + $value;
        }
        $campaignId = TransactionHistory::where('telecaller_id', auth()->user()->id)->latest()->pluck('campaign_id');
        $count = 0;
        $storCampaignName = [];
        foreach ($campaignId as $key => $value) {
            $campName = Campaign::withTrashed()->where('id', $value)->pluck('campaign_name');
            $storCampaignName[$count] = $campName[0];
            $count++;
        }
        $data = [
            'transaction' => $transaction,
            'storCampaignName' => $storCampaignName,
            'totalAmoutOfWallet' => $totalAmoutOfWallet,
        ];
        return view('telecallermodule.wallet')->with($data);
    }

    //after changing the status of leads
    public function selectstatus(Request $request)
    {
        // dd($request->toArray());
        if ($request->status === 'converted') {
            Lead::where('id', $request->lead_id)->update(['status' => 'converted']);
            $conversionCost = Campaign::where('id', $request->campaignId)->pluck('conversion_cost')->toArray();
            TransactionHistory::create(['telecaller_id' => auth()->user()->id, 'campaign_id' => $request->campaignId, 'lead_id' => $request->lead_id, 'amount' => $conversionCost[0]]);
        } else if ($request->status === 'in progress')
            Lead::where('id', $request->lead_id)->update(['status' => 'in progress']);
        else
            Lead::where('id', $request->lead_id)->update(['status' => 'on hold']);
        return response()->json(['leadId' => $request->lead_id]);
    }

    //it will render into edit profile page with particular user details
    public function editProfile(Request $request)
    {
        $obj = User::find(auth()->user()->id);
        return view('telecallermodule.editprofileform')->with('obj', $obj);
    }

    //updating the profile for user
    public function updateProfile(Request $request, $id)
    {
        try {
            User::where('id', $id)->update(['name' => $request['name'], 'email' => $request['email'], 'phone' => $request['phone'], 'country_code' => $request['countrycode'], 'address' => $request['address']]);
            return redirect()->route('dashboard')->with('ProfileUpdateMessage', 'Profile Updated Successfully');
        } catch (Exception $e) {
            $obj = User::find(auth()->user()->id);
            return redirect()->route('editProfile')->with('validValueValidation', 'Please Enter Valid Value!');
        }
    }

    //render on the change password page
    public function changepassword()
    {
        return view('telecaller.changepassword');
    }

    //for changing the password for the user
    public function updatechangepassword(ChangePasswordRequest $request, $id)
    {
        $request->validated();
        $userPassword = User::where('id', $request->user_id)->first();
        if ((\Hash::check($request->oldPassword, $userPassword->password)) && ($request->newPassword === $request->newConfirmPassword)) {
            User::where('id', $request->user_id)->update(['password' => \Hash::make($request->newPassword)]);
            return redirect()->route('dashboard')->with('passwordChange', 'Password Changes Successfully!');
        } else
            return redirect()->back()->with('passwordWarning', 'Please Enter Valid Old Password!');
    }
}
