<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeleCallerController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\UserCampaignController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\LeadController;

Route::get('/', function () {  return redirect()->route('login');});
Route::get('/dashboard', function () {return view('dashboard');
})->name('dashboard');

Auth::routes();
Route::resource('telecaller', TeleCallerController::class);
Route::resource('campaign', CampaignController::class);

Route::delete('/deletetelecaller/{id}',[UserCampaignController::class,'destroy'])->name('deletetelecaller');
Route::post('/storeleads/{id}',[LeadController::class,'store'])->name('storeleads');

// for csv mappingg
Route::POST('/upload',[Csvcontroller::class,'upload']);
Route::post('/import',[Csvcontroller::class,'import']);

Route::get('/get-campaign-user/{id}',[CampaignController::class,'getCampaignUser'])->name('get-campaign-user');
Route::POST('/upload-lead',[LeadController::class,'uploadLead'])->name('upload-lead');

//for searching  leads in telecaller module
Route::get('/showlead',[LeadController::class,'index'])->name('showlead');
Route::POST('/showleadsDetails',[LeadController::class,'showLeadDetails'])->name('showFilterleads');

Route::get('/search-leads',[LeadController::class,'index'])->name('search-leads');

//for both
Route::get('/showprofile/{id}',[LeadController::class,'showprofile'])->name('showprofile');
Route::get('/editProfile',[TeleCallerController::class,'editProfile'])->name('editProfile');
Route::put('/updateProfile/{id}',[TeleCallerController::class,'updateProfile'])->name('updateProfile');
Route::get('/changepassword',[TeleCallerController::class,'changepassword'])->name('changepassword');
Route::put('/updatechangepassword/{id}',[TeleCallerController::class,'updatechangepassword'])->name('updatechangepassword');

//telecaller side
Route::get('/wallet',[TeleCallerController::class,'wallet'])->name('wallet');
//for telecaller on updating lead status
Route::get('/select-status',[TeleCallerController::class,'selectstatus'])->name('selectstatus');

//for showing chart via admin
Route::get('/dashboard-chart',[CampaignController::class,'dashboardchart'])->name('dashboardchart');
