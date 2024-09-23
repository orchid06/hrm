<?php

use App\Http\Controllers\User\LeaveController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\CoreController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\User\AttendanceController;
use App\Http\Controllers\User\Auth\AuthorizationController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\NewPasswordController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\Auth\SocialAuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\user\PayslipController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\User\TicketController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


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

$globalMiddleware = ['sanitizer', 'https', "dos.security", 'maintenance.mode'];
try {
    DB::connection()->getPdo();
    if (DB::connection()->getDatabaseName()) array_push($globalMiddleware, "throttle:refresh");
} catch (\Throwable $th) {
    //throw $th;
}

Route::middleware($globalMiddleware)->group(function () {

    #Frontend Controller


    #guest user route
    Route::middleware(['guest:web'])->name('auth.')->group(function () {

        #Login route
        Route::controller(LoginController::class)->group(function () {

            Route::get('/', 'login')->name('login');
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
            Route::post('password/email', 'store')->name('email');
            Route::get('password/verify', 'verify')->name('verify');
            Route::post('password/verify/code', 'verifyCode')->name('verify.code');
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
    Route::middleware(['auth:web', 'user.verified', 'kyc'])->prefix('user')->name('user.')->group(function () {

        #logout route
        Route::controller(LoginController::class)->group(function () {
            Route::get('/logout', 'logout')->name('logout')->withoutMiddleware(['kyc', 'user.verified']);
        });

        #home & profile route
        Route::controller(HomeController::class)->group(function () {

            Route::any('dashboard', 'home')->name('home');
            Route::get('profile', 'profile')->name('profile');
            Route::get('profile/edit', 'profileEdit')->name('profile.edit');
            Route::post('profile/update', 'profileUpdate')->name('profile.update');
            Route::post('/update', 'passwordUpdate')->name('password.update');
            Route::post('/affiliate/update', 'affiliateUpdate')->name('affiliate.update');
            Route::post('/webhook/update', 'webhookUpdate')->name('webhook.update');
            Route::get('/notifications', 'notification')->name('notifications');
            Route::post('/read-notification', 'readNotification')->name('read.notification');
        });



        #basic user route
        Route::controller(UserController::class)->group(function () {

            #kyc route
            Route::prefix("/kyc")->name('kyc.')->withoutMiddleware(['kyc'])->group(function () {
                Route::get('form', 'kycForm')->name('form');
                Route::post('apply', 'kycApplication')->name('apply');
            });
        });

        Route::controller(ReportController::class)->group(function(){

            Route::prefix("/template/reports")->name('template.report.')->group(function(){
                Route::get('/','templateReport')->name('list');
            });

            Route::prefix("/kyc/reports")->name('kyc.report.')->withoutMiddleware(['kyc'])->group(function(){
                Route::get('/','kycReport')->name('list');
                Route::get('/details/{id}','kycDetails')->name('details');
            });

        });

        # support route
        Route::controller(TicketController::class)->name('ticket.')->prefix('ticket/')->group(function () {
            Route::any('/list', 'list')->name('list');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/reply/{ticket_number}', 'show')->name('show');
            Route::post('/reply/store', 'reply')->name('reply');
            Route::post('/file/download', 'download')->name('file.download');
            Route::get('/destroy/{id}', 'destroy')->name('destroy');
        });


        #attendance route
        Route::controller(AttendanceController::class)->name('attendance.')->group(function () {

            Route::get('/clock_in/reuquest', 'clockInRequest')->name('clock_in.request');
            Route::get('/clocl_out/request', 'clockOutRequest')->name('clock_out.request');
            Route::get('attendance/sheet', 'index')->name('index');
        });

        #Leave route
        Route::controller(LeaveController::class)->prefix('leave/')->name('leave.')->group(function () {

            Route::get('index', 'index')->name('index');
            Route::post('request', 'store')->name('request');

        });

        #Payslip route
        Route::controller(PayslipController::class)->prefix('payslip/')->name('payslip.')->group(function () {

            Route::get('index', 'index')->name('index');
            Route::get('print/{userId}/{month}', 'printPayslip')->name('print');
            Route::get('downlload/{userId}/{month}', 'downloadPayslip')->name('download');

        });
    });

    #CORE CONTROLER
    Route::controller(CoreController::class)
        ->withoutMiddleware(['throttle:refresh', 'dos.security'])
        ->group(function () {

            Route::get('/cron/run', 'cron')->name('cron.run');
            Route::get('/language/change/{code?}', 'languageChange')->name('language.change');
            Route::get('/currency/change/{code?}', 'currencyChange')->name('currency.change');
            Route::get('/optimize-clear', "clear")->name('optimize.clear');

            /** cookie settings */
            Route::get('/set-cookie',  'setCookie');
            Route::get('/accept-cookie',  'acceptCookie')->name("accept.cookie");
            Route::get('/reject-cookie',  'rejectCookie')->name("reject.cookie");
            Route::get('/download-cookie-data',  'downloadCookieData');
            Route::get('subcategories/{category_id}/{html?}', 'getSubcategories')->name('get.subcategories');
            Route::post('get-template', 'getTemplate')->name('get.template');
            Route::get('template-config/{id}', 'templateConfig')->name('template.config');

            /** social account connect callback */
            Route::get('{guard}/account-connect/{medium}/{type?}', 'redirectAccount')->name('account.connect');
            Route::get('account/{medium}/callback', 'handleAccountCallback')->name('account.callback');
        });
});

Route::get('/error/{message?}', function (?string $message = null) {
    abort(403, $message ?? unauthorized_message());
})->name('error')->middleware(['sanitizer', 'https']);

Route::get('queue-work', function () {
    return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work')->middleware(['sanitizer', 'https']);


/** security and captcha */
Route::controller(CoreController::class)->middleware(["sanitizer", 'https'])->group(function () {
    Route::get('/security-captcha', "security")->name('dos.security');
    Route::post('/security-captcha/verify', "securityVerify")->name('dos.security.verify');
    Route::get('/default/image/{size}', 'defaultImageCreate')->name('default.image');
    Route::get('/default-captcha/{randCode}', 'defaultCaptcha')->name('captcha.genarate');
    Route::any('/webhook', 'postWebhook')->name('webhook');
});

Route::get('/maintenance-mode', [CoreController::class, 'maintenanceMode'])->name('maintenance.mode')->middleware(['sanitizer']);
