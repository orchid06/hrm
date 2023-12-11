<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;

use App\Models\Admin\Category;
use App\Models\Article;
use App\Models\Admin\PaymentMethod;
use App\Models\Admin\Withdraw;

use App\Models\Core\File;
use App\Models\Link;
use App\Models\Notification;
use App\Models\Package;
use App\Models\PaymentLog;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Traits\Fileable;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
 

    use Fileable;

    /**
     * Admin Dashboard
     *
     * @param Request $request
     * @return void
     */
    public function home(Request $request) :View{


        return view('admin.home',[
            'title' => "Dashboard",
            'data' => $this->getDashboardData($request)
      
        ]);
    }



     /**
     * get dashboard data
     */

     public function getDashboardData($request =  null) :array{

        $data['total_user'] = User::count();
        $data['total_category'] = Category::count();
        $data['total_package'] = Package::count();
        $data['total_visitor'] = Visitor::count();
        $data['total_article'] = Article::count();
        $data['total_withdraw_method'] = Withdraw::count();
        $data['total_payment_method'] = PaymentMethod::count();
        $data['total_earning'] = round(PaymentLog::where('status','1')->sum('amount')) + round(PaymentLog::where('status','1')->sum('charge'));
        $data['latest_log'] = PaymentLog::latest()->take(6)->get();


        $data['visitor_by_months'] = sortByMonth(Visitor::selectRaw("MONTHNAME(created_at) as months, count(*) as total")
        ->whereYear('created_at', '=',date("Y"))
        ->groupBy('months')
        ->pluck('total', 'months')
        ->toArray());


        $data['earning_per_months'] = sortByMonth(PaymentLog::where('status','1')->selectRaw("MONTHNAME(created_at) as months, SUM(amount + charge) as total")
        ->whereYear('created_at', '=',date("Y"))
        ->groupBy('months')
        ->pluck('total', 'months')
        ->toArray());

        $gateways = PaymentLog::with(['method'])->selectRaw('method_id, COUNT(*) AS count')
            ->whereYear('created_at',date("Y"))
            ->groupBy('method_id')
            ->get();


        $gatewayCounter = [];
        foreach ($gateways as $gateway) {
            if ($gateway->method->name !== 'N/A') {
                $gatewayCounter[$gateway->method->name]=  $gateway->count;
            }
        }


        $subscriptions = Subscription::with("package")->selectRaw('package_id, COUNT(*) AS count')
        ->whereYear('created_at',date("Y"))
        ->groupBy('package_id')
        ->get();


        $subscriptionCounter = [];
        foreach ($subscriptions as $subscription) {
            if ($subscription->package->title !== 'N/A') {
                $subscriptionCounter[$subscription->package->title] =  $subscription->count;
            }
        }

        $data["gateways"] = $gatewayCounter;
        $data["subscription"] = $subscriptionCounter;

        return $data;

     }



    /**
     * Admin profile
     *
     * @return View
     */
    public function profile() :View{

        return view('admin.profile',[

            'breadcrumbs' =>  ['home'=>'admin.home','profile'=> null],
            "user"        =>  auth_user(),
            'title'       => "Profile",
        ]);
    }
    /**
     * Admin profile
     *
     * @return View
     */
    public function profileUpdate(ProfileRequest $request ) :RedirectResponse{
     

        $response = response_status('Profile Updated');

        try {

            DB::transaction(function() use ($request) {
                $admin = auth_user();
                $admin->username    = $request->input('username');
                $admin->phone       = $request->input('phone');
                $admin->email       = $request->input('email');
                $admin->name        = $request->input('name');
                $admin->save();


                if($request->hasFile('image')){
                    $response = $this->storeFile($request->file('image'), config("settings")['file_path']['profile']['admin']['path']);
                    if(isset($response['status'])){
                        $image = new File([
                            'name'      => Arr::get($response, 'name', '#'),
                            'disk'      => Arr::get($response, 'disk', 'local'),
                            'type'      => 'avatar',
                            'size'      => Arr::get($response, 'size', ''),
                            'extension' => Arr::get($response, 'extension', ''),
                        ]);
                        $admin->file()->save($image);
                    }
                }
    
            });

        } catch (\Exception $ex) {
           $response = response_status(strip_tags($ex->getMessage(),"error"));
        }
          
   

          return back()->with($response);
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
            'password'         => 'required|confirmed|min:5',
        ],
        [
            'current_password.required' => translate('Your Current Password is Required'),
            'password' => translate('Password Feild Is Required'),
            'password.confirmed' => translate('Confirm Password Does not Match'),
            'password.min' => translate('Minimum 5 digit or character is required'),
        ]);
        $admin = auth_user();
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->with('error', translate("Your Current Password does not match !!"));
        }
        $admin->password = Hash::make($request->password);
        $admin->save();
        return back()->with(response_status('Password Updated'));
    }



    /**
     * read a notifications
     */

     public function readNotification(Request $request) :string{

        $notification = Notification::where('notificationable_type','App\Models\Admin')
                            ->where("id", $request->id)
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

        Notification::where('notificationable_type','App\Models\Admin')
                        ->update([
                            "is_read" =>  (StatusEnum::true)->status()
                        ]);
                        
        return view('admin.notification',[

            'breadcrumbs'    =>  ['home'=>'admin.home','Notifications'=> null],
            'title'          =>  "Notifications",
            'notifications'  =>  Notification::where('notificationable_type','App\Models\Admin')
                                 ->latest()
                                 ->paginate(paginateNumber())
        ]);
  
    

    }



}
