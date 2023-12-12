<?php

namespace App\Http\Controllers\User;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Core\File;

use App\Models\Notification;
use App\Models\PaymentLog;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Rules\General\FileExtentionCheckRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

use Illuminate\Support\Facades\Hash;
class HomeController extends Controller
{


    protected $user;

    public function __construct(){

        $this->middleware(function ($request, $next) {
            $this->user = auth_user('web');
            return $next($request);
        });
    }
    
    
    /**
     * User Dashboard
     *
     * @param Request $request
     * @return void
     */
    public function home(Request $request) :View{

        return view('user.home');
    }


    /**
     * counter dashboard data
     */

     public function counter() :array{

        $data = array();

        return $data;

     }


    /**
     * profile Update view
     *
     * @return View
     */
    public function profile(Request $request ) :View{

        return view('user.profile',[
            'meta_data'=> $this->metaData(['title'=> translate("Profile")])
        ]);
    }
     

   
    /**
     * profile Update
     *
     * @return View
     */
    public function profileUpdate(Request $request ) :RedirectResponse{

        $request->validate([
            'name'               => ["required","max:100",'string'],
            'username'           => ['required',"string","max:155","alpha_dash",'unique:users,username,'.$this->user->id],
            "country_id"         => ['nullable',"exists:countries,id"],
            'phone'              => ['unique:users,phone,'.$this->user->id],
            'email'              => ['email','required','unique:users,email,'.$this->user->id],
            "image"              => ['nullable','image', new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true)) ]
        ]);

        $user                       =  $this->user;
        $user->name                 =  $request->input('name');
        $user->username             =  $request->input('username');
        $user->phone                =  $request->input('phone');
        $user->email                =  $request->input('email');
        $user->address              =  $request->input('address',[]);
        $user->password             =  $request->input('password');
        $user->country_id           =  $request->input('country_id');
        $user->save();

         if($request->hasFile('image')){

                $oldFile = $user->file()->where('type','profile')->first();
                $response = $this->storeFile(
                    file        : $request->file('image'), 
                    location    : config("settings")['file_path']['profile']['user']['path'],
                    removeFile  : $oldFile
                );
                
                if(isset($response['status'])){
                    $image = new File([
                        'name'      => Arr::get($response, 'name', '#'),
                        'disk'      => Arr::get($response, 'disk', 'local'),
                        'type'      => 'profile',
                        'size'      => Arr::get($response, 'size', ''),
                        'extension' => Arr::get($response, 'extension', ''),
                    ]);

                    $user->file()->save($image);
                }
            }
                
    
        return back()->with(response_status('Profile Updated'));
    }


    /**
     * update password
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function passwordUpdate(Request $request ) :RedirectResponse{


        $rules   = [
            'current_password' => 'required|max:100',
            'password'         => 'required|confirmed|min:6',
        ];

        if(site_settings('strong_password') == StatusEnum::true->status()){

            $rules['password']    =  ["required","confirmed",Password::min(8)
                                        ->mixedCase()
                                        ->letters()
                                        ->numbers()
                                        ->symbols()
                                        ->uncompromised()
                                    ];
        }

        $request->validate($rules);

        $user = $this->user;

        if(!Hash::check($request->input('current_password'), $this->user->password)) {
            return back()->with('error', translate("Your Current Password does not match !!"));
        }
        $user->password = $request->input('password');
        $user->save();
        return back()->with(response_status('Password Updated'));
    }



    /**
     * read a notifications
     */

    public function readNotification(Request $request) :string{

        $notification = Notification::where('notificationable_type','App\Models\User')
                          ->where("id", $request->input("id"))
                          ->where("notificationable_id",$this->user->id)
                          ->first();
        $status  = false;
        $message = translate('Notification Not Found');
        if( $notification ){

            $notification->is_read =  (StatusEnum::true)->status();
            $notification->save();
            $status = true;
            $message = translate('Notification Readed');
        }
        return json_encode([
            "status"  => $status,
            "message" => $message
        ]);

    }


    /**
     * read a notifications
     */

    public function notification(Request $request) :View{

      
        return view('user.notifications',[
            'meta_data'=> $this->metaData(['title'=>translate("Notifications")]),
            'notifications' => Notification::where('notificationable_type','App\Models\User')
                                ->where("id", $request->input("id"))
                                ->where("notificationable_id",$this->user->id)
                                ->latest()
                                ->paginate(paginateNumber())
        ]);
  

    }

}
