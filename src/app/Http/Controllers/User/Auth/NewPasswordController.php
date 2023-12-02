<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\User\AuthService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View ;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class NewPasswordController extends Controller
{

    private $authService;
    public function __construct()
    {
        $this->authService = new AuthService();
    }


    /**
     * forget password 
     *
     * @return View
     */
    public function create():View{

        return view('user.auth.forgot_password',[
            'meta_data'=> $this->metaData([],'login'),
            'title'=> "Reset Passsword",
        ]);
    }


    /**
     * forget password 
     *
     * @return mixed
     */
    public function store(Request $request):mixed{

        $request->validate([
            'email' => "required|email|exists:users,email"
        ]);
        $message = response_status("Invalid Email","error");
        $user = User::where('email',$request->email)->first();
        if($user){
            $response =  $this->authService->sendOtp($user,'reset_password',"email",'PASSWORD_RESET');
            $message = response_status('Can\'t Sent Email!! Configuration Error' , "error");
            if($response['status']){
                $request->session()->flash('success', translate("Check your email a code sent successfully for verify reset password process !! You Need To Verify Your Account!!"));
                session()->put("reset_password_email",$user->email);
                return redirect()->route("password.verify");
            }
        }

        return redirect()->back()->with($message);
    }
    


    /**
     * return verification route
     *
     * @return View
     */
    public function verify() :View{

        return view("user.auth.verification",[
            'meta_data'=> $this->metaData([],'verification'),
            'title'=> "Verify Your Email",
        ]);
    }


    /**
     * verify code
     *
     * @return mixed
     */
    public function verifyCode(Request $request) :mixed {

        $request->validate([
            'email' => "required|email|exists:users,email",
            'code' => "required",
        ]);      

        $message = response_status("Invalid Code","error");
        $user = User::with("otp")->where('email',$request->email)->first();
        if($user && $user->email == session()->get("reset_password_email")){
            $userOtp = $user->otp()?->where('type','reset_password')->first();
            if($userOtp && $userOtp->otp == $request->get("code")){
              session()->put("user_reset_password_otp",$userOtp->otp);
              return redirect()->route('password.reset');
            }
        }
        return redirect()->back()->with($message);
    }

    /**
     * reset view
     *
     * @return View
     */
    public function resetPassword () :View{

        return view("user.auth.reset",[
            'meta_data'=> $this->metaData([
                "title"=>"Reset Password"
            ]),
            'title'=> "Reset Your Password",
        ]);
    }


    /**
     * update password 
     *
     * @return View
     */
    public function updatePassword(Request $request) :RedirectResponse {

        $request->validate([
            'password' => ['required', 'confirmed', 'min:5']
        ]);

        $user = User::with("otp")->where('email',session()->get("reset_password_email"))->first();
        $userOtp = $user->otp()?->where('type','reset_password')->first();
        if($user && $userOtp->otp == session()->get("user_reset_password_otp")){
            $user->password = Hash::make($request->get('password'));
            $user->save();
            session()->forget("reset_password_email");
            session()->forget("user_reset_password_otp");
            $user->otp()?->where('type','reset_password')->delete();
            return redirect()->route('login')->with(response_status("Your Password Has Been Updated!!"));
        }
        return back()->with(response_status("Invalid Email",'error'));
    }






}
