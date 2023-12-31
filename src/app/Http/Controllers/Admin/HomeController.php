<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;

use App\Models\Admin\Category;
use App\Models\Article;
use App\Models\Admin\PaymentMethod;
use App\Models\Admin\Withdraw;
use App\Models\AiTemplate;
use App\Models\Core\File;
use App\Models\Link;
use App\Models\MediaPlatform;
use App\Models\Notification;
use App\Models\Package;
use App\Models\PaymentLog;
use App\Models\SocialAccount;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Visitor;
use App\Models\WithdrawLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Traits\Fileable;
use Barryvdh\Debugbar\Twig\Extension\Debug;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Http;

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
            'data'  => $this->getDashboardData()
        ]);
    }



    /**
     * get dashboard data
     * 
     */

     public function getDashboardData() :array{

        //    $fb = new \JanuSoftware\Facebook\Facebook([
        //     'app_id' => '705395747786690',
        //     'app_secret' => 'ea78e9fa5a2bd6e170107c75eb8bca42',
        //     'default_graph_version' => 'v18.0',
        //   ]);
          

        //        $response = $fb->get('/me?fields=id,name,picture','EAAKBjb75D8IBOyQQjMFJceloQ0TfknMZAEPOet7RPLWIHYZBvaKbIZB2DqHJTDZCjyrOMBBUOrfl2oFqZAiil0ruBeXbrDxdn2RMHENwbZBdTQojF81ngYqW2UJsZBgUGxzpjN422iSNHPLpYD7cp4zfX78plHGcIb9n5RKrzwdf6gBIZBCZCNCAAadyDBKhvqDuIZCNTGwHQzWZBZAV2FSqGZAYZARnvA3HjAPO0ClGJZAaucZD')->getDecodedBody();
        //        $id = $response['id'];

        //        $postData['access_token'] = "EAAKBjb75D8IBOyQQjMFJceloQ0TfknMZAEPOet7RPLWIHYZBvaKbIZB2DqHJTDZCjyrOMBBUOrfl2oFqZAiil0ruBeXbrDxdn2RMHENwbZBdTQojF81ngYqW2UJsZBgUGxzpjN422iSNHPLpYD7cp4zfX78plHGcIb9n5RKrzwdf6gBIZBCZCNCAAadyDBKhvqDuIZCNTGwHQzWZBZAV2FSqGZAYZARnvA3HjAPO0ClGJZAaucZD";
        //        $postData['message'] ='test';

        //        $response = Http::post("https://graph.facebook.com/v10.0/$id/feed", $postData);
        //        @dd( $response->json() );

        // $response = Http::get('https://graph.instagram.com/me', [
        //     'fields' => 'id,username',
        //     'access_token'=>'IGQWROeFhCXzZAsdUlNc20yMGpPUldWR2pFZAlhwRERZAemVPVmJ5azNuRnV3alg2eHdNNVQwR3pILWtib043cDRyRnhRbWsxeTVRMlo0aURGRjhLVldOY2Jvb2Vua1VoYVNaZAVZAPUzZAZAVUY3SktlN2ZAFQzBsMmhDcmsZD',
        // ]);

        
        // // Decode the JSON response
        // $data = $response->json();

        // @dd($data);


        // // Access the data as needed
        // $id = $data['id'];


        // $upload_params = [
        //     'image_url' => imageUrl(@site_logo('favicon')->file,'favicon',true),
        //     'caption' => 'test',
        // ];

        //  $fb = new \JanuSoftware\Facebook\Facebook([
        //     'app_id' => '705395747786690',
        //     'app_secret' => 'ea78e9fa5a2bd6e170107c75eb8bca42',
        //     'default_graph_version' => 'v18.0',
        //   ]);
          

        // // $endpoint = "/". $id."/media_publish";
        //   $response = $fb->get('/me?fields=id,name,picture','EAAKBjb75D8IBOxnZAZCZCeZB4lYGhBJwQiPEqVPYoRcGavgD9BIJzeiv5GYq1lFrHQlgZAy7BeitHWjWc3ZCTg74V3KMLZBfbO9RyITusUvudfFq0WrfK0i1jO8JVIVBMESOyUocogaWX2Yd4QO5ezZBIFIZBJ3JLgChP4uceL6wiAnTfV1NMW5bB0ZB0rWT9wxXMxdgoHuW550DIUJvhtSizA1O6eYlZBDG3sIJ6mjThcqObELPDWBL5xijSpJ8OPSzNKkIBXlBwKuLhoZD')->getDecodedBody();



        //   $endpoint = "/".$response['id']."/";

        //   $endpoint .= "feed";
        //   $params = ['message' =>'test'];
        //         //   $data = $response->json();

        //   $response = $fb->post( $endpoint, $params,"EAAKBjb75D8IBOxnZAZCZCeZB4lYGhBJwQiPEqVPYoRcGavgD9BIJzeiv5GYq1lFrHQlgZAy7BeitHWjWc3ZCTg74V3KMLZBfbO9RyITusUvudfFq0WrfK0i1jO8JVIVBMESOyUocogaWX2Yd4QO5ezZBIFIZBJ3JLgChP4uceL6wiAnTfV1NMW5bB0ZB0rWT9wxXMxdgoHuW550DIUJvhtSizA1O6eYlZBDG3sIJ6mjThcqObELPDWBL5xijSpJ8OPSzNKkIBXlBwKuLhoZD")->getDecodedBody();

        //   @dd(   $response );
        
        //   $response = $fb->get('/me/accounts?fields=instagram_business_account,id,name,username,fan_count,link,is_verified,picture,access_token,category&limit=10000',"IGQWRNNU0wLUZAlOXJqSE1RWlg4elloeVFVbFJZAMEdxRzZAsT0xBOGQ2MUtHNTFWaTRQOGVhV3hIUnAyRW1Ub0tSLUt4aVVTbTRlU2xVdll3bFExZA1FVQmlERVp3N3BDbmktREg1NV8ySk5vVGxWeHFmTWpucUpFQUkZD");

        

        // $username = $data['username'];

        // $data = $response->json();

        // $response = Http::get("https://graph.instagram.com/v12.0/{$id}?fields=profile_picture&access_token=IGQWROOE51RnFZAUW9sYlJPVlZA5R0tFV195Ykl0UjloZAUpzdmV2TXhDVzF4Y1NBSUlmSE9KcjNHQ1d5dkhzQlp0cVlNcHk5cERUV1JTUjd2S2YyX0NFdzhLOG56UnVEWVpiMjdoRFFaRU1RbEp6MUJjWEF2TDNLSFEZD");

        // $profileData = $response->json();
        // @dd($profileData);

        $data['latest_log']               = PaymentLog::with(['user','method','method.currency','currency'])
                                                ->date()               
                                                ->latest()
                                                ->take(6)
                                                ->get();
        $data['latest_subscriptions']     = Subscription::with(['package','admin','user'])
                                                ->date()               
                                                ->latest()
                                                ->take(8)
                                                ->get();

        $data['account_repot']            = [

                "total_account"         => SocialAccount::count(),
                "active_account"        => SocialAccount::active()->count(),
                "inactive_account"      => SocialAccount::inactive()->count(),
                "accounts_by_platform"  => MediaPlatform::withCount(['accounts'])
                                            ->integrated()
                                            ->pluck('accounts_count','name')
                                            ->toArray()
        ];

        $subscripIncome = Subscription::date()->whereYear('created_at', '=',date("Y"))->sum('payment_amount');
        $charge         = PaymentLog::paid()->date()->whereYear('created_at','=',date('Y'))->sum("charge");
        $withDrawCharge = WithdrawLog::approved()->date()->whereYear('created_at','=',date('Y'))->sum("charge");
        

        $data['subscription_reports']    = [

                                    "total_subscriptions"         => Subscription::date()->whereYear('created_at', '=',date("Y"))->count(),
                                    "total_income"                => num_format(
                                                                                number: $subscripIncome,
                                                                                calC:true
                                                                               ),
            
                                     "monthly_subscriptions"      =>  sortByMonth(Subscription::date()
                                                                        ->selectRaw("MONTHNAME(created_at) as months,  count(*) as total")
                                                                        ->whereYear('created_at', '=',date("Y"))
                                                                        ->groupBy('months')
                                                                        ->pluck('total', 'months')
                                                                        ->toArray()),
                    
                                     "monthly_income"             =>   sortByMonth(Subscription::date()
                                                                        ->selectRaw("MONTHNAME(created_at) as months, SUM(payment_amount) as total")
                                                                        ->whereYear('created_at', '=',date("Y"))
                                                                        ->groupBy('months')
                                                                        ->pluck('total', 'months')
                                                                        ->toArray(),true)

        ];



        $data['total_user']               = User::date()->count();
        $data['total_category']           = Category::date()->count();
        $data['total_package']            = Package::date()->count();
        $data['total_visitor']            = Visitor::date()->count();
        $data['total_article']            = Article::date()->count();
        $data['total_template']           = AiTemplate::date()->count();
        $data['total_earning']            = num_format(
                                                number: $subscripIncome + $charge + $withDrawCharge,
                                                calC:true
                                            ) ;
        $data['total_platform']           = MediaPlatform::active()->count();




        $data['earning_per_months']     = sortByMonth(PaymentLog::paid()->selectRaw("MONTHNAME(created_at) as months, SUM(amount + charge) as total")
                                            ->whereYear('created_at', '=',date("Y"))
                                            ->groupBy('months')
                                            ->pluck('total', 'months')
                                            ->toArray());

        $data['subscription_by_plan']  =  Package::withCount(['subscriptions'])
                                                ->pluck('subscriptions_count','title')
                                                ->toArray();



        $data['withdraw_charge']        = num_format(number:$withDrawCharge,calC:true);
        $data['payment_charge']         = num_format(number:$charge,calC:true);

        $data['monthly_payment_charge']       =  sortByMonth(PaymentLog::date()->paid()->selectRaw("MONTHNAME(created_at) as months, SUM(charge) as total")
                                                ->whereYear('created_at', '=',date("Y"))
                                                ->groupBy('months')
                                                ->pluck('total', 'months')
                                                ->toArray(),true);


                                                
        $data['monthly_withdraw_charge']       =  sortByMonth(WithdrawLog::date()->approved()->selectRaw("MONTHNAME(created_at) as months, SUM(charge) as total")
                                                    ->whereYear('created_at', '=',date("Y"))
                                                    ->groupBy('months')
                                                    ->pluck('total', 'months')
                                                    ->toArray(),true);


        $data['latest_transactiions']           =  Transaction::with(['user','admin','currency'])
                                                        ->search(['remarks','trx_code'])
                                                        ->filter(["user:username",'trx_type'])
                                                        ->date()               
                                                        ->latest()
                                                        ->take(7)
                                                        ->get();

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
