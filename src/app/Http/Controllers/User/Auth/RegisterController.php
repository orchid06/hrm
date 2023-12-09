<?php

namespace App\Http\Controllers\User\Auth;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Services\User\AuthService;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{


    protected $authService ,$settings;

    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->settings = (object) json_decode(site_settings("user_authentication"));

    
        $this->authService = new AuthService();
    }

    

    /**
     * user registration 
     *
     * @param UserRegisterRequest $request
     * @return RedirectResponse
     */
    public function store(UserRegisterRequest $request) :RedirectResponse{

      

        dd($request->all());
    
    }


    /**
     * Show Registration Form
     *
     * @return View
     */
    public function create() :View{
        if($this->settings->registration == StatusEnum::false->status()){
            abort(403,unauthorized_message("Registration modeule is currently off now"));
        }
        return view('user.auth.register',[
            'meta_data'=> $this->metaData([],'register'),
        ]);
    }


  
 

}

