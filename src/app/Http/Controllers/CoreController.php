<?php

namespace App\Http\Controllers;

use App\Enums\AccountType;
use App\Enums\ConnectionType;
use App\Enums\PostStatus;
use App\Enums\StatusEnum;
use App\Enums\SubscriptionStatus;
use App\Http\Services\UserService;
use App\Http\Utility\SendNotification;
use App\Http\Utility\SendSMS;
use App\Jobs\SendMailJob;
use App\Jobs\SendSmsJob;
use App\Models\Admin\Category;
use App\Models\Admin\Currency;
use App\Models\AiTemplate;
use App\Models\Core\Language;
use App\Models\Core\Setting;
use App\Models\MediaPlatform;
use App\Models\Package;
use App\Models\PostWebhookLog;
use App\Models\SocialPost;
use App\Models\Subscriber;
use App\Models\Subscription;
use App\Models\User;
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
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use App\Traits\PostManager;
use App\Traits\AccountManager;
use Illuminate\Http\Response;

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

        if(!Language::where('code', $code)->exists()) $code = 'en';
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
      * @param string $size
      * @return Response
      */
     public function defaultImageCreate(string $size)  :Response {

        $width   = explode('x',$size)[0];
        $height  = explode('x',$size)[1];
        $img     = Image::canvas( $width,$height ,'#ccc');
        $text    = $width . 'X' . $height;

        $fontSize     = $width > 100 && $height > 100
                              ? 60 : 20;


        $img->text($text, $width / 2,  $height / 2, function ($font) use($fontSize) {
            $font->file(realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf');
            $font->color('#000');
            $font->align('center');
            $font->valign('middle');
            $font->size($fontSize);
        });

        return $img->response('png');

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

    public function clear() :RedirectResponse {

        optimize_clear();
        return back()->with(response_status("Cache Clean Successfully"));
    }

    /**
     * Process cron job
     *
     * @return void
     */
    public function cron() :void{

        try {
            $this->handleSchedulePost();
            $this->handleExpireSubscriptions();
        } catch (\Throwable $th) {

        }

        Setting::updateOrInsert(
            ['key'    => 'last_cron_run'],
            ['value'  => Carbon::now()]
        );



    }





    /** security control */
    public function security() :View{

        if(site_settings('dos_prevent') == StatusEnum::true->status() &&
           !session()->has('dos_captcha')){
            return view('dos_security',[
                'meta_data' => $this->metaData(["title"    =>  trans('default.too_many_request')]),
            ]);
        }
        abort(403);
    }


    public function securityVerify(Request $request) :RedirectResponse{


        $request->validate([
            "captcha" =>   ['required' , function (string $attribute, mixed $value, Closure $fail) {
                if (strtolower($value) != strtolower(session()->get('gcaptcha_code')))  $fail(translate("Invalid captcha code"));
            }]
        ]);

        session()->forget('gcaptcha_code');
        session()->forget('security_captcha');
        session()->put('dos_captcha',$request->input("captcha"));

        $route = 'home';
        if(session()->has('requested_route')) $route = session()->get('requested_route');

        return redirect()->route($route);
    }



    public function acceptCookie(Request $request) :\Illuminate\Http\Response
    {

        $response = response(["message" => 'Cookie accepted'])->cookie('cookie_consent', 'accepted')->cookie('accepted_at', now());
        $this->saveCookieData($request->cookie());
        return $response;
    }

    public function rejectCookie(Request $request) :\Illuminate\Http\Response
    {
        $response = response([
            "message" => 'Cookie rejected',
        ])->cookie(Cookie::forget('cookie_consent'))->cookie(Cookie::forget('accepted_at'));
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

        session()->put("cookie_consent",true);

        $data = array_merge($data  ,get_ip_info());
        $folderPath = storage_path('app');
        $filePath = $folderPath . '/cookie_data.json';

        if (!file_exists($folderPath))  mkdir($folderPath, 0755, true);

        $existingData = [];

        if (!file_exists($filePath)) {
            file_put_contents($filePath, json_encode([]));
        } else {
            $existingData = (array)json_decode(file_get_contents($filePath), true);
        }

        $combinedData = array_merge($existingData, $data);
        file_put_contents($filePath, json_encode($combinedData));
    }

    private function getSavedCookieData() :array
    {
        $path = storage_path('app/cookie_data.json');

        if (file_exists($path))  return json_decode(file_get_contents($path), true);

        return [];
    }



    public  function maintenanceMode() :View | RedirectResponse{


        $title = translate('Maintenance Mode');

        if(site_settings('maintenance_mode') == (StatusEnum::false)->status() )     return redirect()->route('user.home');

        return view('maintenance_mode', [
            'title'=> $title,
        ]);

     }
}
