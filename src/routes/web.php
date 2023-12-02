<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\CommunicationsController;
use App\Http\Controllers\CoreController;
use App\Http\Controllers\FrontendController;

use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\NewPasswordController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\Auth\SocialAuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\User\TicketController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

    $hitLimit = 500;
        try {
            $hitLimit = site_settings('web_route_rate_limit');
        } catch (\Throwable $th) {
            //throw $th;
        }
    Route::middleware(['sanitizer','user.verified',"throttle:$hitLimit,1"])->group(function (){

        #guest user route
        Route::middleware(['guest:web'])->group(function () {

            #Login route
            Route::controller(LoginController::class)->group(function () {
                Route::get('/login', 'showLoginForm')->name('login');
                Route::get('/login/verification', 'verify')->name('login.verify');
                Route::post('/login/verify', 'verifyOtp')->name('login.verify.otp');
                Route::get('/login/verification/code/resend', 'resend')->name('login.otp.resend');
                Route::post('/authenticate', 'authenticate')->name('authenticate');
            });

            #Register route
            Route::controller(RegisterController::class)->group(function () {
                Route::get('/register', 'create')->name('register');
                Route::post('/register/store', 'store')->name('register.store');
                Route::get('/registration/verification', 'verifyCode')->name('register.verification');
                Route::get('/registration/verification/code/resend', 'resend')->name('verification.code.resend');
                Route::post('/register/verify', 'verify')->name('register.verify');
            });

            #password route
            Route::controller(NewPasswordController::class)->name('password.')->group(function () {
                Route::get('forgot-password', 'create')->name('request');
                Route::post('password/email','store')->name('email');
                Route::get('password/verify','verify')->name('verify');
                Route::post('password/verify/code','verifyCode')->name('verify.code');
                Route::get('password/reset', 'resetPassword')->name('reset');
                Route::post('password/update', 'updatePassword')->name('update');
            });


            #SOCIAL LOGIN CONTROLLER
            Route::controller(SocialAuthController::class)->name('social.')->group(function () {
                Route::get('login/{medium}', 'redirectToOauth')->name('login');
                Route::get('login/{medium}/callback', 'handleOauthCallback')->name('login.callback');
            });
        });

        #user route
        Route::middleware(['auth:web','user.verified'])->prefix('user')->name('user.')->group(function()  {

            #Login route
            Route::controller(LoginController::class)->group(function () {
                Route::get('/logout', 'logout')->name('logout');
            });

          #home & profile route
            Route::controller(HomeController::class)->group(function(){
                Route::any('dashboard','home')->name('home');
                Route::prefix('profile')->name('profile.')->group(function () {
                    Route::get('/','profile')->name('index');
                    Route::post('/update', 'profileUpdate')->name('update');
                    Route::get('payment','payment')->name('payment');
                });
                Route::prefix('passwords')->name('password.')->group(function () {
                    Route::post('/update', 'passwordUpdate')->name('update');
                });

                Route::get('/notifications','notification')->name('notifications');
                Route::post('/read-notification','readNotification')->name('read.notification');
            });

            #payment route
            Route::controller(PaymentController::class)->prefix('/payment')->name('payment.')->group(function(){
                Route::any('/process','process')->name('process');
                Route::any('/confirm','confirm')->name('confirm');
                Route::any('/manual/confirm','manualPay')->name('manual');
            });

            #basic user route
            Route::controller(UserController::class)->group(function(){
                
                Route::any('/free/package/{id}','purchase')->name('free.package');
                Route::any('/pricing-plan','plan')->name('plan');
                Route::any('/subscription','subscription')->name('subscription');
                Route::any('/transaction','transaction')->name('transaction');
                Route::any('/payment-log','paymentLog')->name('payment.log');
                Route::get('/payment-log/{id}','paymentShow')->name('payment.log.show');

            });
        
             # support route
            Route::controller(TicketController::class)->name('ticket.')->prefix('ticket/')->group(function () {
                
                Route::any('/list','list')->name('list');
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/reply/{ticket_number}','show')->name('show');
                Route::post('/reply/store','reply')->name('reply');
                Route::post('/file/download','download')->name('file.download');
            });


            Route::controller(ReportController::class)->group(function(){

                Route::prefix("/template/reports")->name('template.report.')->group(function(){
                    Route::get('/','templateReport')->name('list');
                });

                Route::prefix("/withdraw/reports")->name('withdraw.report.')->group(function(){
                    Route::get('/','withdrawReport')->name('list');
                });

                Route::prefix("/deposit/reports")->name('deposit.report.')->group(function(){
                    Route::get('/','paymentReport')->name('list');
                });

                Route::prefix("/subscription/reports")->name('subscription.report.')->group(function(){
                    Route::get('/','subscriptionReport')->name('list');
                });

                Route::prefix("/affiliate/reports")->name('affiliate.report.')->group(function(){
                    Route::get('/','affiliateReport')->name('list');
                });

                Route::prefix("/kyc/reports")->name('kyc.report.')->group(function(){
                    Route::get('/','kycReport')->name('list');
                });
                Route::prefix("/credit/reports")->name('credit.report.')->group(function(){
                    Route::get('/','creditReport')->name('list');
                });
    
            });
    


        });


        Route::controller(FrontendController::class)->group(function (){

            /** base url  */
         

        });

        #Coummunication route
        Route::controller(CommunicationsController::class)->group(function (){
          
        });



        #CORE CONTROLER
        Route::controller(CoreController::class)->group(function () {
            
            Route::get('/cron/run','cron')->name('cron.run');
            Route::get('/webhook','webhook')->name('webhook');
            Route::get('/language/change/{code?}','languageChange')->name('language.change');
            Route::get('/currency/change/{code?}','currencyChange')->name('currency.change');
            Route::get('/default/image/{size}','defaultImageCreate')->name('default.image');
            Route::get('/default-captcha/{randCode}', 'defaultCaptcha')->name('captcha.genarate');
            Route::get('/optimize-clear',"clear")->name('optimize.clear');
            
            Route::get('/security-captcha',"security")->name('dos.security');
            Route::post('/security-captcha/verify',"securityVerify")->name('dos.security.verify');
        });

       


        
     

    });

    Route::get('/error/{message?}', function (?string $message = null) {
        abort(403,$message ?? unauthorized_message());
    })->name('error')->middleware(['sanitizer']);

    Route::get('queue-work', function () {
        return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
    })->name('queue.work')->middleware(['sanitizer']);







