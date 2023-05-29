<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeleCallerController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\UserCampaignController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\LeadController;

// use App\Http\Middleware\auth;

Auth::routes();
Route::get('/', function () {
    return redirect()->route('login'); });

Route::middleware(['auth'])->group(function () {
    //for both Route
    Route::get('/dashboard', function () {
        return view('dashboard'); })->name('dashboard');
    Route::get('/showprofile/{id}', [LeadController::class, 'showprofile'])->name('showprofile');
    Route::get('/editProfile', [TeleCallerController::class, 'editProfile'])->name('editProfile');
    Route::put('/updateProfile/{id}', [TeleCallerController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/changepassword', [TeleCallerController::class, 'changepassword'])->name('changepassword');
    Route::put('/updatechangepassword/{id}', [TeleCallerController::class, 'updatechangepassword'])->name('updatechangepassword');

    //All Admin Routes
    Route::middleware(['CheckAdminMiddleware'])->group(function () {

        Route::resource('telecaller', TeleCallerController::class);
        Route::resource('campaign', CampaignController::class);

        Route::delete('/deletetelecaller/{campaign_id}/{telecaller_id}', [UserCampaignController::class, 'destroy'])->name('deletetelecaller');
        Route::post('/storeleads/{id}', [LeadController::class, 'store'])->name('storeleads');

        // for csv mappingg
        Route::POST('/upload', [Csvcontroller::class, 'upload']);
        Route::post('/import', [Csvcontroller::class, 'import']);

        Route::get('/get-campaign-user/{id}', [CampaignController::class, 'getCampaignUser'])->name('get-campaign-user');
        Route::POST('/upload-lead', [LeadController::class, 'uploadLead'])->name('upload-lead');

        //for showing chart via admin
        Route::get('/dashboard-chart', [CampaignController::class, 'dashboardchart'])->name('dashboardchart');
    });


    //All Telecaller Routes
    Route::middleware(['CheckTelecallerMiddleware'])->group(function () {
        //for searching  leads in telecaller module
        Route::get('/showlead', [LeadController::class, 'index'])->name('showlead');
        Route::get('/search-leads', [LeadController::class, 'index'])->name('search-leads');
        //telecaller side
        Route::get('/wallet', [TeleCallerController::class, 'wallet'])->name('wallet');
        //for telecaller on updating lead status
        Route::get('/select-status', [TeleCallerController::class, 'selectstatus'])->name('selectstatus');
    });

    Route::get('/checkUserExist', [TeleCallerController::class, 'checkUserExist']);
});
