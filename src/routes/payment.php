<?php

use App\Http\Controllers\User\PaymentController;
use Illuminate\Support\Facades\Route;


 #payment status route
 Route::controller(PaymentController::class)->group(function(){
    Route::any('/success', 'success')->name('success');
    Route::any('/failed', 'failed')->name('failed');
    Route::any('/ipn/{code?}/{trx?}/{type?}','callbackIpn')->name('ipn');
});