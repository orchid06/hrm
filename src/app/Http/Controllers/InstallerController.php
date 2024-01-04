<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\CentralLogics\Helpers;
use App\Enums\StatusEnum;
use App\Models\Admin;
use App\Traits\InstallerManager;
use Carbon\Carbon;
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

        if(session()->has(base64_decode('cHVyY2hhc2VfY29kZQ==')) && session()->has(base64_decode('dXNlcm5hbWU='))){

            $message = "Invalid database info. Kindly check your connection details and try again";
            $request->validate([
                'db_host'     => "required",
                'db_port'     => "required",
                'db_database' => "required",
                'db_username' => "required" ,
            
            ]);
    
            if($this->_chekcDbConnection( $request)){
                if($this->_checkDb($request) && $this->_envConfig($request)){
                    return redirect()->route('install.account.config',['verify_token' => bcrypt(base64_decode('c3lzdGVtX2NvbmZpZw=='))]);
                }
                $message = "Please empty your database then try again";
            }
    
            return back()->with("error", $message);

        }

        return redirect()->route('install.init')->with('error','Invalid verification token');

    }


    public function accountConfig() :View |RedirectResponse
    {
        if (Hash::check(base64_decode('c3lzdGVtX2NvbmZpZw=='), request()->input('verify_token'))) {
            return view('install.account_config');
        }
        return redirect()->route('install.init')->with('error','Invalid verification token');

    }


    public function accountSetup(Request $request) :View |RedirectResponse
    {
        try {
            $this->_dbMigrate();
            $request->validate([
                'username' => 'required|max:155',
                'email'    => 'required|email|max:155',
                'password' => 'required|min:5',
            ]);

            $admin =  Admin::firstOrNew(['super_admin' => StatusEnum::true->status()]);
            $admin->username                  = $request->input('username');
            $admin->name                      = 'SuperAdmin';
            $admin->email                     = $request->input('email');
            $admin->password                  =  Hash::make($request->input('password'));
            $admin->email_verified_at         = Carbon::now();
            $admin->super_admin               = StatusEnum::true->status();
            $admin->save();
    
            session()->put('password',$request->input('password'));
            $this->_dbSeed();

            $this->_systemInstalled();
    
            return redirect()->route('install.setup.finished',['verify_token' => bcrypt(base64_decode('c2V0dXBfY29tcGxldGVk'))]);
        } catch (\Exception $ex) {
            return back()->with('error', strip_tags($ex->getMessage()));

        }
       

    }


    public function setupFinished(Request $request) :View |RedirectResponse
    {
        if (Hash::check(base64_decode('c2V0dXBfY29tcGxldGVk'), request()->input('verify_token'))) {
            $admin =  Admin::where('super_admin' , StatusEnum::true->status())->first();
            optimize_clear();
            return view('install.setup_finished',[
                'admin' => $admin
            ]);
        }

        return redirect()->route('install.init')->with('error','Invalid verification token');
    }














}
