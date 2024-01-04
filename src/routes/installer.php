<?php

use App\Http\Controllers\InstallerController;
use Illuminate\Support\Facades\Route;




    #Install er route
    Route::controller(InstallerController::class)->prefix("/install")->name('install.')->group(function(){

        Route::get('/','init')->name('init');
        Route::get('/requirement-verification','requirementVerification')->name('requirement.verification');
        Route::get('/envato-verification','envatoVerification')->name('envato.verification');
        Route::post('/purchase-code/verification','codeVerification')->name('purchase.code.verification');
        Route::get('/db-setup','dbSetup')->name('db.setup');
        Route::post('/db-store','dbStore')->name('db.store');
        Route::get('account/config','accountConfig')->name('account.config');
        Route::post('account-setup','accountSetup')->name('account.setup');
        Route::get('setup-finished','setupFinished')->name('setup.finished');

   });



