<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\CommunicationsController;
use App\Http\Controllers\CoreController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\User\Auth\AuthorizationController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\NewPasswordController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\Auth\SocialAuthController;
use App\Http\Controllers\User\DepositController;
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


    Route::middleware(['sanitizer',"throttle:refresh" ,"https" ,"dos.security"])->group(function (){

        #guest user route
        Route::middleware(['guest:web'])->name('auth.')->group(function () {

            #Login route
            Route::controller(LoginController::class)->group(function () {

                Route::get('/login', 'login')->name('login');
                Route::post('/authenticate', 'authenticate')->name('authenticate');
            });

        
            #Register route
            Route::controller(RegisterController::class)->group(function () {

                Route::get('/register/{referral_code?}', 'create')->name('register');
                Route::post('/register/store', 'store')->name('register.store');
    
            });

            #otp autorization route
            Route::controller(AuthorizationController::class)->group(function () { 

                Route::get('/otp-verification', 'otpVerification')->name('otp.verification');
                Route::get('/email-verification', 'otpVerification')->name('email.verification')->withoutMiddleware(['guest:web']);
                Route::post('/otp-verify', 'otpVerify')->name('otp.verify')->withoutMiddleware('guest:web');
                Route::get('/otp-resend', 'otpResend')->name('otp.resend')->withoutMiddleware('guest:web');
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
                Route::get('profile','profile')->name('profile');
                Route::get('profile/update','profileUpdate')->name('profile.update');
                Route::post('/update', 'passwordUpdate')->name('password.update');
                Route::get('/notifications','notification')->name('notifications');
                Route::post('/read-notification','readNotification')->name('read.notification');
            });

            #payment route
            Route::controller(DepositController::class)->prefix('/deposit')->name('deposit.')->group(function(){
                
                Route::any('/process','process')->name('process');
                Route::any('/confirm','confirm')->name('confirm');
                Route::any('/manual/confirm','manualPay')->name('manual');
                
            });

            #basic user route
            Route::controller(UserController::class)->group(function(){

                /** NEW ROUTE START */
                  Route::get('purchase/{slug}','planPurchase')->name('plan.purchase');
                  
                  
                /** END */



            });
        
             # support route
            Route::controller(TicketController::class)->name('ticket.')->prefix('ticket/')->group(function () {
                
                Route::any('/list','list')->name('list');
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/reply/{ticket_number}','show')->name('show');
                Route::post('/reply/store','reply')->name('reply');
                Route::post('/file/download','download')->name('file.download');
                Route::get('/destroy/{id}','destroy')->name('destroy');

            });


            #report route
            Route::controller(ReportController::class)->group(function(){

                Route::prefix("/template/reports")->name('template.report.')->group(function(){
                    Route::get('/','templateReport')->name('list');
                });
                Route::prefix("/withdraw/reports")->name('withdraw.report.')->group(function(){
                    Route::get('/','withdrawReport')->name('list');
                    Route::get('/details/{id}','withdrawDetails')->name('details');
                });
                Route::prefix("/deposit/reports")->name('deposit.report.')->group(function(){
                    Route::get('/','depositReport')->name('list');
                    Route::get('/details/{id}','depositDetails')->name('details');
                });
                Route::prefix("/subscription/reports")->name('subscription.report.')->group(function(){
                    Route::get('/','subscriptionReport')->name('list');
                });
                Route::prefix("/affiliate/reports")->name('affiliate.report.')->group(function(){
                    Route::get('/','affiliateReport')->name('list');
                });
                Route::prefix("/kyc/reports")->name('kyc.report.')->group(function(){
                    Route::get('/','kycReport')->name('list');
                    Route::get('/details/{id}','kycDetails')->name('details');
                });
                Route::prefix("/credit/reports")->name('credit.report.')->group(function(){
                    Route::get('/','creditReport')->name('list');
                });
                Route::prefix("/transaction/reports")->name('transaction.report.')->group(function(){
                    Route::get('/','transactionReport')->name('list');
                });
    
            });
    


        });


        Route::controller(FrontendController::class)->group(function (){

                Route::get('/', 'home')->name('home');
                Route::get('/plans', 'plan')->name('plan');
                Route::get('/blogs', 'blog')->name('blog');
                Route::get('/blogs/{slug}', 'blogDetails')->name('blog.details');
                Route::get('/pages/{slug}', 'page')->name('page');

        });

        #Coummunication route
        Route::controller(CommunicationsController::class)->group(function (){

            Route::any('/subscribe', 'subscribe')->name('subscribe');
            Route::get('/contact', 'contact')->name('contact');
            Route::post('/contact/store', 'store')->name('contact.store');
            Route::get('/feedback', 'feedback')->name('feedback');
            Route::post('/feedback/store', 'feedbackStore')->name('feedback.store');

        });



        #CORE CONTROLER
        Route::controller(CoreController::class)->group(function () {
            
            Route::get('/cron/run','cron')->name('cron.run');
            Route::get('/webhook','webhook')->name('webhook');
            Route::get('/language/change/{code?}','languageChange')->name('language.change');
            Route::get('/currency/change/{code?}','currencyChange')->name('currency.change');
            Route::get('/optimize-clear',"clear")->name('optimize.clear');

            /** cookie settings */
            Route::get('/set-cookie',  'setCookie');
            Route::get('/accept-cookie',  'acceptCookie')->name("accept.cookie");
            Route::get('/reject-cookie',  'rejectCookie')->name("reject.cookie");;
            Route::get('/download-cookie-data',  'downloadCookieData');

        });

       
    });

    Route::get('/error/{message?}', function (?string $message = null) {
        abort(403,$message ?? unauthorized_message());
    })->name('error')->middleware(['sanitizer','https']);

    Route::get('queue-work', function () {
        return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
    })->name('queue.work')->middleware(['sanitizer','https']);


    /** security and captcha */
    Route::controller(CoreController::class)->middleware(["sanitizer",'https'])->group(function () {

        Route::get('/security-captcha',"security")->name('dos.security');
        Route::post('/security-captcha/verify',"securityVerify")->name('dos.security.verify');
        Route::get('/default/image/{size}','defaultImageCreate')->name('default.image');
        Route::get('/default-captcha/{randCode}', 'defaultCaptcha')->name('captcha.genarate');

    });







