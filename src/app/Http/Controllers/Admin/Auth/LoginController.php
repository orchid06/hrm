<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    
    /**
     * show login form
     *
     * @return void
     */
    public function login() :View{
        return view("admin.auth.login",[
            'title' => 'Login'
        ]);
    }

    
    /**
     * authenticate request user
     *
     * @param Request $request
     * @return void
     */
    public function authenticate(Request $request) :RedirectResponse{

        $response = response_status('Server Error!! Please Reload Then Try Again ','error');
        try {
            $this->validateLogin($request);
  
            if (Auth::guard('admin')->attempt([$this->username($request->input('login')) => $request->input('login') , "password"=>$request->input('password')])){
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard')->with(response_status('Successfully Loggedin'));
            }

            $response = response_status('Invalid Credential','error');
           
        } catch (\Throwable $th) {
          
        }
        return back()->with($response);
       
    }

    /**
     * get username
     *
     * @param string $login
     * @return string
     */
    
     public function username(string $login) :string 
    {
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {

            return 'email';

        } elseif (preg_match('/^[0-9]+$/', $login)) {

            return 'phone_number';
        }
        
        return 'username';
    }

    /**
     * Validate the admin login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {

        $request->validate([
            'login'              => 'required|string',
            'password'           => 'required|string',
        ],[
            'login.required'     => ucfirst($this->username($request)). translate(' Feild Is Required'),
            'password.required'  => translate("Password Feild Is Required")
        ]);

    }

    /**
     * logout
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request) :RedirectResponse
    {
        Auth::guard('admin')->logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken(); 
        return redirect('/admin');
    }



}
