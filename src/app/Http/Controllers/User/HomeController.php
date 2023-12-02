<?php

namespace App\Http\Controllers\User;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Core\File;
use App\Models\Favourite;
use App\Models\Link;
use App\Models\Notification;
use App\Models\PaymentLog;
use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
class HomeController extends Controller
{
    
    /**
     * Admin Dashboard
     *
     * @param Request $request
     * @return void
     */
    public function home(Request $request) :View{

        return view('user.home',[
            'meta_data'=> $this->metaData([],"home"),
            'counter' => $this->counter(),
            'payment_logs' => PaymentLog::with(['package','user','method'])->latest()->where('user_id',auth_user('web')->id)
            ->take(10)->get()
        ]);
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
            'meta_data'=> $this->metaData(['title'=>translate("Profile")])
        ]);
    }
     

   
    /**
     * profile Update
     *
     * @return View
     */
    public function profileUpdate(Request $request ) :RedirectResponse{

        $request->validate([
            'user_name' => "required|unique:users,user_name,".auth_user('web')->id,
            'phone' => "required|unique:users,phone,".auth_user('web')->id,
            'email' => "required|unique:users,email,".auth_user('web')->id,
            'name' => "required",
        ]);
     
        $user = auth_user('web');
        $user->user_name = $request->get('user_name');
        $user->phone = $request->get('phone');
        $user->email = $request->get('email');
        $user->name = $request->get('name');
        $user->save();

        if($request->hasFile('image')){
            $response = FileService::storeFile($request->file('image'), config("settings")['file_path']['profile']['user']['path'],null ,@$user->file->name );
            if($response['status']){
                $user->file()->delete();
                $image = new File();
                $image->name =  Arr::get( $response ,'name',"#");
                $image->disk =  Arr::get( $response ,'disk',"local");
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

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:5',
        ],
        [
            'current_password.required' => translate('Your Current Password is Required'),
            'password' => translate('Password Feild Is Required'),
            'password.confirmed' => translate('Confirm Password Does not Match'),
            'password.min' => translate('Minimum 5 digit or character is required'),
        ]);
        $user = auth_user('web');
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', translate("Your Current Password does not match !!"));
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with(response_status('Password Updated'));
    }



    /**
     * read a notifications
     */

    public function readNotification(Request $request) :string{

       
        return json_encode([
            "status" => $status,
            "message" => $message
        ]);

    }


    /**
     * read a notifications
     */

    public function notification(Request $request) :View{

      
        return view('user.notifications',[
            'meta_data'=> $this->metaData(['title'=>translate("Notifications")]),
            'notifications' => Notification::where('user_id',auth_user('web')->id)
            ->latest()
            ->paginate(paginateNumber())
        ]);
  

    }

}
