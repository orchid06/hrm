<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Enums\SubscriptionStatus;
use App\Http\Services\UserService;
use App\Http\Utility\SendNotification;
use App\Http\Utility\SendSMS;
use App\Jobs\SendMailJob;
use App\Jobs\SendSmsJob;
use App\Models\Admin\Currency;
use App\Models\Core\Language;
use App\Models\Package;
use App\Models\Subscriber;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Closure;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class CoreController extends Controller
{


    
     
    /**
     * change  language
     *
     * @param string $code
     * @return RedirectResponse
     */
     public function languageChange(string $code ) :RedirectResponse
     {
        $response['status'] = "success";
        $response['message'] = translate('Language Switched Successfully');

        if(!Language::where('code', $code)->exists()){
            $code = 'en';
        }
        
        optimize_clear();
        session()->put('locale', $code);
        app()->setLocale($code);

       return back()->with("success",translate('Language Switched Successfully'));
     }



    /**
     * change  language
     *
     * @param string $code
     * @return RedirectResponse
     */
    public function currencyChange(string $code ) :RedirectResponse
    {
        $currency = Currency::active()->where('code',$code)->firstOrFail();
        session()->put('currency',$currency);
        return back()->with("success",translate('Currency switched to '.$currency->name));
    }


     /**
      * create default image
      *
      * @param string|null $size
      * @return void
      */
     public function defaultImageCreate(string $size=null) :void
     {
         $width = explode('x',$size)[0];
         $height = explode('x',$size)[1];
         $image = imagecreate($width, $height);
         $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
         if($width > 100 && $height > 100){
             $fontSize = 30;
         }else{
             $fontSize = 5;
         }
         $text = $width . 'X' . $height;
         $backgroundcolor = imagecolorallocate($image, 237, 241, 250);
         $textcolor    = imagecolorallocate($image, 107, 111, 130);
         imagefill($image, 0, 0, $textcolor);
         $textsize = imagettfbbox($fontSize, 0, $fontFile, $text);
         $textWidth  = abs($textsize[4] - $textsize[0]);
         $textHeight = abs($textsize[5] - $textsize[1]);
         $xx = ($width - $textWidth) / 2;
         $yy = ($height + $textHeight) / 2;
         header('Content-Type: image/jpeg');
         imagettftext($image, $fontSize, 0, $xx, $yy, $backgroundcolor , $fontFile, $text);
         imagejpeg($image);
         imagedestroy($image);
     }
     
   /**
    * genarate default cpatcha code
    *
    * @return void
    */
   public function defaultCaptcha(int | string $randCode) :void{

       $phrase = new PhraseBuilder;
       $code = $phrase->build(4);
       $builder = new CaptchaBuilder($code, $phrase);
       $builder->setBackgroundColor(220, 210, 230);
       $builder->setMaxAngle(25);
       $builder->setMaxBehindLines(0);
       $builder->setMaxFrontLines(0);
       $builder->build($width = 100, $height = 40, $font = null);
       $phrase = $builder->getPhrase();

       if(Session::has('gcaptcha_code')) {
           Session::forget('gcaptcha_code');
       }
       Session::put('gcaptcha_code', $phrase);
       header("Cache-Control: no-cache, must-revalidate");
       header("Content-Type:image/jpeg");
       $builder->output();
    }

    public function clear() :RedirectResponse{

        optimize_clear();
        return back()->with(response_status("Cache Clean Successfully"));
    }

    public function cron() :Void{

        try {
      
            $subscriptions = Subscription::with(['user','package'])
                            ->running()
                            ->expired()
                            ->cursor();

            foreach($subscriptions as $subscription){

                $subscription->update([
                    'status'     => SubscriptionStatus::value('Expired', true),
                    'expired_at' => date('Y-m-d'),
                ]);


                $code = [
                    'time'    => Carbon::now(),
                    'name'    => $subscription->package->title,
                    'link'    => route('user.subscription.report.list'),
                    'reason'  => translate("Auto renewal package does not exist"),
                ];
            

                $notificationTypes =  [
                    "database_notifications"  => "App\Http\Utility\SendNotification",
                    "email_notifications"     => "App\Jobs\SendMailJob",
                    "sms_notifications"       => "App\Jobs\SendSmsJob",
                ];

                foreach( $notificationTypes as $type => $key){

                     if(notify($type)){
                        if($type == "database_notifications"){
                            $key::database_notifications($subscription->user,"SUBSCRIPTION_EXPIRED",$code,Arr::get( $code , "link", null));
                        }
                        else{
                            $key::dispatch($subscription->user,'SUBSCRIPTION_EXPIRED',$code);
                        }
                     }
                }

                // Auto-renewal 
                if($subscription->user &&  $subscription->user->auto_subscription == StatusEnum::true->status()){

                    $getPackageId       = site_settings("auto_subscription_package");
                    if(site_settings('auto_subscription') == StatusEnum::true->status() && $subscription->user->auto_subscription_by){
                        $getPackageId   =  $subscription->user->auto_subscription_by;
                    }

                    $package = Package::where('id',$getPackageId)->first();

                    $flag = 1;
                    if($package){
                        $userService       =  new UserService();
                        $response          =  $userService->createSubscription($subscription->user , $package ,translate("Auto Subscription renewal"));
                        $code ['reason']   = Arr::get($response, 'message' ,translate("Auto renewal package doesnot exists"));
                        if(isset($response['status']) && $response['status']){
                            $flag = 0;
                        }

                    }
                    if($flag == 1){
                        foreach( $notificationTypes as $type => $key){
                            if(notify($type)){
                               if($type == "database_notifications"){
                                   $key::database_notifications($subscription->user,"SUBSCRIPTION_FAILED",$code,Arr::get( $code , "link", null));
                               }
                               else{
                                   $key::dispatch($subscription->user,'SUBSCRIPTION_FAILED',$code);
                               }
                            }
                        }
                    }

                }

            }

            session()->put('last_corn_run',Carbon::now());
        } catch (\Throwable $th) {
            //throw $th;
        }

    }


    /** security control */


    public function security() :View{

        if(site_settings('dos_prevent') == StatusEnum::true->status() && !session()->has('dos_captcha')){

            return view('dos_security',[
                'title' => translate("Security Verification")
            ]);
        }
        abort(403);
    }


    public function securityVerify(Request $request) :RedirectResponse{

    
        $request->validate([
            "captcha" =>   ['required' , function (string $attribute, mixed $value, Closure $fail) {
                if (strtolower($value) != strtolower(session()->get('gcaptcha_code'))) {
                    $fail(translate("Invalid Captch Code"));
                }
            }]
        ]);

        session()->forget('gcaptcha_code');
        session()->forget('security_captcha');
        session()->put('dos_captcha',$request->input("captcha"));
        return redirect()->route('admin.home');
    }


    
    public function acceptCookie(Request $request) :\Illuminate\Http\Response
    {

        $response = response('Cookie accepted')->cookie('cookie_consent', 'accepted')->cookie('accepted_at', now());
        $this->saveCookieData($request->cookie());
        return $response;
    }

    public function rejectCookie(Request $request) :\Illuminate\Http\Response
    {
        $response = response('Cookie rejected')->cookie(Cookie::forget('cookie_consent'))->cookie(Cookie::forget('accepted_at'));
        $this->saveCookieData($request->cookie());
        return $response;
    }

    public function downloadCookieData() :\Illuminate\Http\Response
    {

        $cookieData = $this->getSavedCookieData();

        $csv = implode(',', array_keys($cookieData)) . PHP_EOL;
        $csv .= implode(',', $cookieData) . PHP_EOL;

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="cookie_data.csv"');
    }

    private function saveCookieData(array $data) :void
    {

        @dd($data , get_ip_info());
        $folderPath = storage_path('app');
        $filePath = $folderPath . '/cookie_data.json';

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        $existingData = [];

        if (!file_exists($filePath)) {
            file_put_contents($filePath, json_encode([]));
        } else {
            $existingData = json_decode(file_get_contents($filePath), true);
        }

        $combinedData = array_merge($existingData, $data);
        file_put_contents($filePath, json_encode($combinedData));
    }

    private function getSavedCookieData() :array
    {
        $path = storage_path('app/cookie_data.json');

        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true);
        }

        return [];
    }


}
