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

use App\Traits\PostManager;
use App\Traits\AccountManager;
class CoreController extends Controller
{



    use AccountManager ,PostManager;
    
     
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

         $fontSize = 5;
         if($width > 100 && $height > 100){
             $fontSize = 30;
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



    /**
     * Handle schedule post
     *
     * @return void
     */
    public function handleSchedulePost() :void{

        $posts = SocialPost::whereIn('status',[strval(PostStatus::value('Pending',true)) ,strval(PostStatus::value('Schedule',true))])->cursor();

        foreach($posts->chunk(20) as $chunkPosts){
            foreach($chunkPosts as $post){
                sleep(1);
                if($post->schedule_time <= Carbon::now()){
                    $post->status = strval(PostStatus::value('Pending',true));
                    $post->save();
                }
                if($post->status ==  strval(PostStatus::value('Pending',true))){
                    $this->publishPost($post);
                }
            }
        }




    }

    /**
     * Handle expire subscriptions
     *
     *  @return void
     */
    public function handleExpireSubscriptions() :void{

        $userService   = new UserService();
        $subscriptions = Subscription::with(['user','package'])
                            ->running()
                            ->expired()
                            ->cursor();

        foreach($subscriptions as $subscription){

            $subscription->update([
                'status'     => SubscriptionStatus::value('Expired', true),
                'expired_at' => date('Y-m-d'),
            ]);


            // inactive  user profile
            $userService->inactiveSocialAccounts($subscription);

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

    }





    /** security control */
    public function security() :View{

        if(site_settings('dos_prevent') == StatusEnum::true->status() && !session()->has('dos_captcha')){

            return view('dos_security',[
                'meta_data' => $this->metaData(
                    [
                        "title"    =>  trans('default.too_many_request')
                    ]
                ),
   
            ]);
        }
        abort(403);
    }


    public function securityVerify(Request $request) :RedirectResponse{

    
        $request->validate([
            "captcha" =>   ['required' , function (string $attribute, mixed $value, Closure $fail) {
                if (strtolower($value) != strtolower(session()->get('gcaptcha_code'))) {
                    $fail(translate("Invalid captcha code"));
                }
            }]
        ]);

        session()->forget('gcaptcha_code');
        session()->forget('security_captcha');
        session()->put('dos_captcha',$request->input("captcha"));

        $route = 'home';
        if(session()->has('requested_route')){
            $route = session()->get('requested_route');
        }

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

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

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

        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true);
        }

        return [];
    }


    
    
    public function getSubcategories(int | string $id , bool $html = false) :array {


        $categories =  Category::where('parent_id', $id)
                        ->active()->get();

        $options    = "<option value=''> Select Subcategory </option>";
        if ($html) {
            foreach ($categories as $category) {
                $options .= '<option value="' . $category->id . '">' . $category->title . '</option>';
            }
        }

        return [

            'status'     => true,
            'html'       => $options,
            'categories' => $categories->pluck('title','id')->toArray(),
        ];

    }




    public function getTemplate(Request $request) :array {


        $request->validate([
            'category_id'     => "required|exists:categories,id",
            'sub_category_id' => "nullable|exists:categories,id",
            'user_id'         => 'nullable|exists:users,id'
        ]);

        $flag           = false;
        $templateAccess = [];
        if($request->input('user_id')) {
            $user          = User::with(['runningSubscription'])->find($request->input('user_id'));
            if(!$user || !$user->runningSubscription){
                return ['status'=> false,'message'=> translate('Invalid User!! No Template Found')];
            }
            $subscription   = $user->runningSubscription;
            $templateAccess = $subscription ?  (array)subscription_value($subscription,"template_access",true) :[];
            $flag           = true;
        }

        $category           = Category::template()
                                        ->doesntHave('parent')
                                        ->where("id", $request->input("category_id"))->first();
     

        $templates          =    AiTemplate::where("category_id", @$category->id)
                                    ->when($request->input('sub_category_id') , function ($query) use ($request ,$category ){
                                        $subCategory     = Category::where("parent_id", $category->id)
                                                                ->where('id',$request->input('sub_category_id'))
                                                                ->first();
                                        $query->where('sub_category_id', @$subCategory->id);
                                    })->when($flag && count($templateAccess) > 0 , function ($query) use ($request , $templateAccess){
                                        $query->whereIn('id', $templateAccess);
                                        
                                    })->active()->get();

        $options    = "<option value=''> Select Template </option>";
   
        if($templates ->count() > 0){
            foreach ($templates as $template) {
                $options .= '<option value="' . $template->id . '">' . $template->name . '</option>';
            }
        }
        
        return [
            'status'     => true,
            'html'       => $options,
            'templates'  => $templates->pluck('name','id')->toArray(),
        ];

    }


    public function templateConfig(int  $id , bool $is_user = false) :array {

        $template = AiTemplate::active()->where('id', $id)->first();
        $html     ='';
        $message  = translate('You dont have access to this template');
        $flag     = true;

        if($is_user){
            $user          = auth_user('web');
            $flag          = false;
            if($user 
                  && $user->runningSubscription 
                  && in_array($user->id, (array)subscription_value($user->runningSubscription,"template_access",true))){
                $flag     = true;
            }
        }

        if($template && $flag){

            if ($template->prompt_fields) {
                foreach ($template->prompt_fields as $key => $input) {
                    $html .= '<div class="col-lg-12">
                                <div class="form-inner">
                                    <label for="' . $key . '">' . @$input->field_label . ' ' . (@$input->validation == 'required' ? '<small class="text-danger">*</small>' : '') . '</label>';
                    if ($input->type == "text") {
                        $html .= '<input data-name="' . '{' . @$input->field_name . '}' . '" placeholder="' . @$input->field_label . '" ' . (@$input->validation == 'required' ? 'required' : '') . ' name="custom[' . @$input->field_name . ']" id="' . $key . '" value="' . old("custom." . @$input->field_name) . '" type="text" class="prompt-input">';
                    } else {
                        $html .= '<textarea class="prompt-input" data-name="' . '{' . @$input->field_name . '}' . '" placeholder="' . @$input->field_label . '" ' . (@$input->validation == 'required' ? 'required' : '') . ' name="custom[' . @$input->field_name . ']"  id="' . $key . '"  cols="30" rows="6">' . old("custom." . @$input->field_name) . '</textarea>';
                    }
                    $html .= '</div></div>';
                }
            }
            $html .= '<div class="col-lg-12">
                        <div class="form-inner">
                            <label for="promptPreview">' . translate('Prompt Preview') . '</label>
                            <textarea data-prompt_input="' . $template->custom_prompt . '" readonly id="promptPreview" cols="30" rows="10">' . $template->custom_prompt . '</textarea>
                        </div>
                    </div>';

        }


        return [
            'status'     => $flag,
            "html"       =>  $html,
            "$message"   => $message,
        ];

    }






    /**
     * socail account redirect function
     *
     * @param Request $request
     * @param $service
     * @return void
     */
    public function redirectAccount(Request $request, string $guard ,string $medium , string $type = null) :mixed {

        try {
            if(!auth()->guard($guard)->check()) {
                abort(403, "Unauthenticated user request");
            }
            $platform = $this->setConfig($medium);
            session()->put("guard", $guard);
            return Socialite::driver($medium)->redirect();
        } catch (\Exception $ex) {

            $message = strip_tags($ex->getMessage());
            $message = preg_replace('/[^A-Za-z0-9\-]/', ' ', $message);
            
            return back()->with('error',$message);
        }


    }


    /**
     * Set configuration
     *
     * @param string $medium
     * @return void
     */
    public function setConfig(string $medium) :MediaPlatform{

        $platform                     = MediaPlatform::where('slug',$medium)->first();
        $credential["client_secret"]  = @$platform->configuration->client_secret;
        $credential["client_id"]      = @$platform->configuration->client_id;
        $credential["redirect"]       = url('account/'.$medium.'/callback');

        Config::set('services.'.$medium, $credential);

        return $platform;

    }

    /**
     * handle o auth call back
     *
     * @param $service
     * @return void
     */
    public function handleAccountCallback(string $service) : RedirectResponse
    {

        try {

            $platform  = $this->setConfig($service);
            $guard = session()->get('guard');

            if(!$guard || !auth()->guard($guard)->check() ){
                abort(403, "Unauthenticated user request");
            }

            $account = Socialite::driver($service)->stateless()->user();
            

            $id = Arr::get($account->attributes,'id',null);
            if(!$account || !$account->token || !$id ){
                abort(403, "Unauthenticated user request");
            }

            $identification = Arr::get($account->attributes,'email',null);
            if(!$identification){
                $identification = $id;
            }
        
            $accountInfo = [
                'id'                => @$account->id,
                'account_id'        => $identification,
                'name'              => Arr::get($account->attributes,'name',null),
                'avatar'            => Arr::get($account->attributes,'avatar',null),
                'email'             => Arr::get($account->attributes,'email',null),
                'token'             => @$account->token,
                'token_secret'      => @$account->token_secret,
                'consumer_key'      => @$account->consumer_key,
                'consumer_secret'   => @$account->consumer_secret,
                'bearer_token'      => @$account->bearer_token,
                'expiresIn'         => @$account->expiresIn,
            ];


            $response  = $this->saveAccount($guard,$platform,$accountInfo,AccountType::Profile->value ,ConnectionType::OFFICIAL->value);
            $routeName =  $guard =='admin' ? "admin.social.account.list":"user.social.account.list";
            return redirect()->route($routeName,['platform' => $platform->slug])->with(response_status("Account Added"));
            
    
        } catch (\Exception $e) {

            abort(403, "Unauthenticated user request");
        }
       	

    }



    public  function maintenanceMode() :View | RedirectResponse{

        if(site_settings('maintenance_mode') == (StatusEnum::false)->status() ){
            return redirect()->route('home');
        }
        $title = translate('Maintenance Mode');
        return view('maintenance_mode', [
            'title'=> $title,
        ]);

     }

     


     /**
      * Handle post webhook
      *
      */
    public function postWebhook(string $uid  = null) {

        $hubToken   = request()->query('hub_verify_token');
        $apiKey     = site_settings("webhook_api_key");
        $usersCount = User::where('webhook_api_key',  $hubToken )->count();

        if ($apiKey  == $hubToken || $usersCount > 0 ) {
            return response(request()->query('hub_challenge'));
        }
        
        $user = User::where('uid',$uid)->first();
        
        PostWebhookLog::create([
            'user_id'           =>  $user?  $user->id : null,
            'webhook_response'  => request()->all()
        ]);

    }



    






}
