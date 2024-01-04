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

        Route::get('/step3/{message?}','step3')->name('step3');
        Route::get('/step4','step4')->name('step4');
        Route::get('/step5','step5')->name('step5');

        Route::post('/database_installation','database_installation')->name('database');
        Route::post('purchase_code', 'purchase_code')->name('purchase.code');
        Route::post('system_settings', 'system_settings')->name('system_settings');
   });



