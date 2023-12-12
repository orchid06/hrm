<?php

use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\User\PaymentController;
use Illuminate\Support\Facades\Route;


 #payment status route
 Route::controller(DepositController::class)->group(function(){
    Route::any('/ipn/{trx_code?}/{type?}','callbackIpn')->name('ipn');
    Route::any('/success', 'success')->name('success');
    Route::any('/failed', 'failed')->name('failed');
});