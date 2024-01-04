<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\CentralLogics\Helpers;
use App\Traits\InstallerManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class InstallerController extends Controller
{

    use InstallerManager;

    public function __construct(){

        $this->middleware(function ($request, $next) {
            if($this->is_installed()){
                return redirect()->route('home')->with('success',trans('default.already_installed'));
            }
            return $next($request);
        });
    
    }
    public function init() :View
    {
        return view('install.init');
    }


    public function requirementVerification() : View |RedirectResponse
    {   

        if (Hash::check(base64_decode('cmVxdWlyZW1lbnRz'), request()->input('verify_token'))) {
            return view('install.requirements',[
                'requirements' => $this->checkRequirements(
                    config('installer.requirements')
                ),
                "phpSupportInfo" =>  $this->checkPHPversion(config('requirements.core.minPhpVersion')),
                'permissions'    => $this->permissionsCheck(
                                        config('installer.permissions')
                                    )
                
            ]);
        }

        return redirect()->route('install.init')->with('error','Invalid verification token');
    }

    public function envatoVerification() :View |RedirectResponse
    {
        if (Hash::check(base64_decode('ZW52YXRvX3ZlcmlmaWNhdGlvbg=='), request()->input('verify_token'))) {
            return view('install.envato_verification');
        }
        return redirect()->route('install.init')->with('error','Invalid verification token');
    }


    public function codeVerification(Request $request) :View |RedirectResponse
    {
        $request->validate([
            base64_decode('cHVyY2hhc2VfY29kZQ==') => "required",
            base64_decode('dXNlcm5hbWU=') => "required"
        ]);

        #todo remote not sign & call this function using eval
        if(!$this->_envatoVerification($request)){
            session()->put( base64_decode('cHVyY2hhc2VfY29kZQ=='), $request->input(base64_decode('cHVyY2hhc2VfY29kZQ==')));
            session()->put( base64_decode('dXNlcm5hbWU='), $request->input(base64_decode('dXNlcm5hbWU=')));
            return redirect()->route('install.db.setup',['verify_token' => bcrypt(base64_decode('ZGJzZXR1cF8='))]);
        }
    
        return redirect()->back()->with('error','Invalid verification code');
    }



    public function dbSetup() :View |RedirectResponse
    {
        if (Hash::check(base64_decode('ZGJzZXR1cF8='), request()->input('verify_token'))) {
            return view('install.db_setup');
        }
        return redirect()->route('install.init')->with('error','Invalid verification token');
    }

    public function dbStore(Request $request) :View |RedirectResponse
    {

        $request->validate([
            'db_host'     => "required",
            'db_port'     => "required",
            'db_database' => "required",
            'db_username' => "required" ,
            'db_password' => "required"
        ]);
        // if (Hash::check(base64_decode('ZGJzZXR1cF8='), request()->input('verify_token'))) {
        //     return view('install.db_setup');
        // }
        // return redirect()->route('install.init')->with('error','Invalid verification token');
    }






    public function step4(Request $request)
    {
        if (Hash::check('step_4', $request['token'])) {
            return view('installation.step4');
        }
        session()->flash('error', 'Access denied!');
        return to_route('step0');
    }

    public function step5(Request $request)
    {
        if (Hash::check('step_5', $request['token'])) {
            return view('installation.step5');
        }
        session()->flash('error', 'Access denied!');
        return to_route('step0');
    }

  
    public function system_settings(Request $request)
    {
        if (!Hash::check('step_6', $request['token'])) {
            session()->flash('error', 'Access denied!');
            return to_route('step0');
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'same:confirm_password'],
            'confirm_password' => 'required',
        ]);
        if ($validator->fails()) {
            session()->flash('error', 'Confirm password does not match!');
            return back();
        }

        DB::table('admins')->insertOrIgnore([
            'f_name' => $request['f_name'],
            'l_name' => $request['l_name'],
            'email' => $request['email'],
            'role_id' => 1,
            'password' => bcrypt($request['password']),
            'phone' => $request['phone_code'].$request['phone'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('business_settings')->where(['key' => 'business_name'])->update([
            'value' => $request['business_name']
        ]);


        Helpers::insert_business_settings_key('system_language','[{"id":1,"direction":"ltr","code":"en","status":1,"default":true}]');

        //version 7.0
        Helpers::insert_data_settings_key('admin_login_url', 'login_admin' ,'admin');
        Helpers::insert_data_settings_key('admin_employee_login_url', 'login_admin_employee' ,'admin_employee');
        Helpers::insert_data_settings_key('restaurant_login_url', 'login_restaurant' ,'restaurant');
        Helpers::insert_data_settings_key('restaurant_employee_login_url', 'login_restaurant_employee' ,'restaurant_employee');

        Helpers::insert_business_settings_key('take_away', '1');
        Helpers::insert_business_settings_key('repeat_order_option', '1');
        Helpers::insert_business_settings_key('home_delivery', '1');

        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);
        //sleep(5);

        Helpers::remove_dir('storage/app/public');
        Storage::disk('public')->makeDirectory('/');
        Madzipper::make('installation/backup/public.zip')->extractTo('storage/app');
        return view('installation.step6');
    }

    public function database_installation(Request $request)
    {
        if (self::check_database_connection($request->DB_HOST, $request->DB_DATABASE, $request->DB_USERNAME, $request->DB_PASSWORD)) {

            $key = base64_encode(random_bytes(32));
            $output = 'APP_NAME=stackfood' . time() .
                'APP_ENV=live
                    APP_KEY=base64:' . $key . '
                    APP_DEBUG=false
                    APP_INSTALL=true
                    APP_LOG_LEVEL=debug
                    APP_MODE=live
                    APP_URL=' . URL::to('/') . '

                    DB_CONNECTION=mysql
                    DB_HOST=' . $request->DB_HOST . '
                    DB_PORT=3306
                    DB_DATABASE=' . $request->DB_DATABASE . '
                    DB_USERNAME=' . $request->DB_USERNAME . '
                    DB_PASSWORD=' . $request->DB_PASSWORD . '

                    BROADCAST_DRIVER=log
                    CACHE_DRIVER=file
                    SESSION_DRIVER=file
                    SESSION_LIFETIME=120
                    QUEUE_DRIVER=sync

                    REDIS_HOST=127.0.0.1
                    REDIS_PASSWORD=null
                    REDIS_PORT=6379

                    PUSHER_APP_ID=
                    PUSHER_APP_KEY=
                    PUSHER_APP_SECRET=
                    PUSHER_APP_CLUSTER=mt1

                    PURCHASE_CODE=' . session('purchase_key') . '
                    BUYER_USERNAME=' . session('username') . '
                    ';
            $file = fopen(base_path('.env'), 'w');
            fwrite($file, $output);
            fclose($file);

            $path = base_path('.env');
            if (file_exists($path)) {
                return to_route('step4', ['token' => $request['token']]);
            } else {
                session()->flash('error', 'Database error!');
                return to_route('step3', ['token' => bcrypt('step_3')]);
            }
        } else {
            session()->flash('error', 'Database host error!');
            return to_route('step3', ['token' => bcrypt('step_3')]);
        }
    }

    public function import_sql()
    {
        try {
            $sql_path = base_path('installation/backup/database.sql');
            DB::unprepared(file_get_contents($sql_path));
            return to_route('step5', ['token' => bcrypt('step_5')]);
        } catch (\Exception $exception) {
            session()->flash('error', 'Your database is not clean, do you want to clean database then import?');
            return back();
        }
    }

    public function force_import_sql()
    {
        try {
            Artisan::call('db:wipe', ['--force' => true]);
            $sql_path = base_path('installation/backup/database.sql');
            DB::unprepared(file_get_contents($sql_path));
            return to_route('step5', ['token' => bcrypt('step_5')]);
        } catch (\Exception $exception) {
            session()->flash('error', 'Check your database permission!');
            return back();
        }
    }

    function check_database_connection($db_host = "", $db_name = "", $db_user = "", $db_pass = ""): bool
    {
        try {
            if (@mysqli_connect($db_host, $db_user, $db_pass, $db_name)) {
                return true;
            } else {
                return false;
            }
        }catch(\Exception $exception){
            return false;
        }
    }
}
