<?php

namespace App\Http\Controllers\User\Auth;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
     /**
     * socail auth redirect function
     *
     * @param Request $request
     * @param $service
     * @return void
     */
    public function redirectToOauth(Request $request, string $service)
    {
        return Socialite::driver($service)->redirect();
    }

    /**
     * handle o auth call back
     *
     * @param $service
     * @return void
     */
    public function handleOauthCallback(string $service) : \Illuminate\Http\RedirectResponse
    {
        
        try {
            $userOauth = Socialite::driver($service)->stateless()->user();
    
        } catch (\Exception $e) {
            return back()->with('error',translate('Setup Your Social Credentail!! Then Try Agian'));
        }
       	
        $user = User::where('email',$userOauth->email)->first();
        if(!$user){
            $user                    = new User();
            $user->name              = Arr::get($userOauth->user,"name", null) ;
            $user->email             = $userOauth->email ; 
            $user->o_auth_id         = Arr::get($userOauth->user,"id", null);
            $user->email_verified_at = Carbon::now();
            $user->save();
        }
        
        Auth::guard('web')->login($user);
        return redirect()->route('user.home')->with(response_status("Login Success"));
    }
}
