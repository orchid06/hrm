<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Enums\WithdrawStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;

use App\Models\Admin\PaymentMethod;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Http\Services\UserService;
use App\Jobs\SendMailJob;
use App\Models\Admin\Withdraw;
use App\Models\Country;
use App\Traits\ModelAction;
use Illuminate\Database\Query\Builder;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{

    use ModelAction;
    protected  $userService;
    /**
     *
     * @return void
     */
    public function __construct()
    {

        $this->userService = new UserService();
        //check permissions middleware
        $this->middleware(['permissions:view_user'])->only('list','show','selectSearch');
        $this->middleware(['permissions:create_user'])->only(['store','create']);
        $this->middleware(['permissions:update_user'])->only(['updateStatus','update','login','subscription','balance']);
        $this->middleware(['permissions:delete_user'])->only(['destroy']);
    }


    /**
     * user list
     *
     * @return View
     */
    public function list() :View{


        return view('admin.user.list', [

            'breadcrumbs'  =>  ['Home'=>'admin.home','Users'=> null],
            'title'        => 'Manage Users',

            'users'        =>  User::with(['file','country',"subscriptions" => function($q){
                                    return $q->with(['package'])->running();
                                }])
                                    ->routefilter()
                                    ->search(['name','email',"phone"])
                                    ->filter(['country:name'])
                                    ->latest()
                                    ->paginate(paginateNumber())
                                    ->appends(request()->all()),

            "countries"    => Country::get(),
    
        ]);
    }


    /**
     * store a  new user
     *
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request) :RedirectResponse{

        $user = $this->userService->save($request);
 
        return  back()->with(response_status('User created successfully'));
    }



   

    /**
     * Update a specific user
     *
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function update(UserRequest $request) :RedirectResponse{

        $user = $this->userService->save($request);

        return  back()->with(response_status('User updated successfully'));
    }


    /**
     * Update a specific user balance
     *
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function balance(Request $request) :RedirectResponse{

        try {
            
            $rules = [
                'id'              => ['required',"exists:users,id"],
                "amount"          => ['required','numeric','min:-1'],
                "type"            => ['required',Rule::in(['deposit',"withdraw"])],
                "payment_id"      => [ Rule::requiredIf(function () use ($request) {
                                                return $request->input('type') === 'deposit';
                                        }),
                                        Rule::exists('payment_methods', 'id')
                                     ],
                'method_id'       => [
                                        function ($attribute, $value, $fail) use ($request) {
                                            if ($request->input('type') === 'withdraw' && !$request->filled('method_id')) {
                                                $fail('The method_id field is required for withdraws.');
                                            }
                                        },
    
                                        Rule::exists('withdraws', 'id')
                                    ],
                "remarks"         => ['required',"string"],
            ];
    
            $forgetKey = $request->input("type") == "deposit" ? "method_id" : "payment_id" ;
            data_forget($rules, $forgetKey);
            
            $request->validate($rules);
    
            $user          =   User::findOrfail($request->input("id"));
    
            if($request->input('type') == 'deposit'){

                $method    = PaymentMethod::with(['currency'])->findOrfail($request->input("payment_id"));
                $response  = Arr::get($this->userService->createDepositLog($request ,$user ,$method),"response",[]);

            }
            else{

                $method    = Withdraw::findOrfail($request->input("method_id"));
                $response  = $this->userService->createWithdrawLog($request ,$user ,$method);
            }

        } catch (\Exception $ex) {
            $response = response_status($ex->getMessage(),'error');
        }

       
        return  back()->with($response);
    }

    /**
     * Update a specific user status
     *
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request) :string{

        $request->validate([
            'id'      => 'required|exists:users,uid',
            'status'  => ['required',Rule::in(StatusEnum::toArray())],
            'column'  => ['required',Rule::in(['status'])],
        ]);

        return $this->changeStatus($request->except("_token"),[
            "model"    => new User(),
        ]);
     
    }


    /**
     * destroy a specific user
     *
     * @param string $uid
     * @return RedirectResponse
     */
    public function destroy(int | string $id) :RedirectResponse{

        $response  =  response_status('Deleted Successfully');
        try {
           
            DB::transaction(function() use ($id) {
                $user      = User::with(['file',"otp",'notifications','tickets','tickets.messages','tickets.file','subscriptions','transactions','paymentLogs','paymentLogs.file','withdraws','withdraws.file','templates','templateUsages','kycLogs','kycLogs.file','creditLogs','affiliates'])
                                ->where('uid',$id)
                                ->firstOrfail();

                $user->subscriptions()->delete();
                $user->affiliates()->delete();
                $user->otp()->delete();
                $user->transactions()->delete();
                $user->notifications()->delete();
                $user->creditLogs()->delete();
                $user->templates()->delete();
                $user->templateUsages()->delete();

                if($user->paymentLogs()->count() > 0){
                    foreach(@$user->paymentLogs as $log){
                        $this->unlinkLogFile($log ,config("settings")['file_path']['payment']['path']);
                    }
                  $user->paymentLogs()->delete();
                }

                if($user->withdraws()->count() > 0){
                    foreach(@$user->withdraws as $withdraw){
                        $this->unlinkLogFile($withdraw ,config("settings")['file_path']['withdraw']['path']);
                    }
                   $user->withdraws()->delete();
                }

                if($user->tickets()->count() > 0){
                    foreach(@$user->tickets as $ticket){
                        $this->unlinkLogFile($ticket ,config("settings")['file_path']['ticket']['path']);
                        $ticket->messages()->delete();
                    }
                    $user->tickets()->delete();
                }

                if($user->kycLogs()->count() > 0) {
                    foreach(@$user->kycLogs as $kyc){
                        $this->unlinkLogFile($kyc ,config("settings")['file_path']['kyc']['path']);
                    }
                  $user->kycLogs()->delete();
                }

                $this->unlink(
                    location    : config("settings")['file_path']['profile']['user']['path'],
                    file        : $user->file()->where('type','profile')->first()
                );
              
                $user->delete();
            });
        } catch (\Exception $ex) {
            $response  =  response_status(strip_tags($ex->getMessage()),'error');
        }
      

        return  back()->with($response);
    }

    public function unlinkLogFile(mixed $log , string $path){

        foreach(@$log->file as $file){
            $this->unlink(
                location    : $path,
                file        : $file
            );
        } 

    }
   


    /**
     * show in as user
     *
     * @param string $uid
     * @return View
     */
    public function show(string $uid) :View{

        $user  = User::with(['file','kycLogs','templates','paymentLogs','transactions','subscriptions','tickets','withdraws','affiliates'])
                    ->where('uid',$uid)
                    ->firstOrFail();

        return view('admin.user.show',[

            'breadcrumbs'          => ['Home'=>'admin.home','Users'=> 'admin.user.list' ,'Show' => null],
            'title'                => 'Show Users',
            'user'                 => $user,
            'subscription'         => Subscription::where('user_id',$user->id)->running()->first(),
            'packages'             => Package::active()->get(),
            'withdraw_methods'     => Withdraw::active()->get(),
            'methods'              => PaymentMethod::active()->get(),
            "countries"            => Country::get(),
        ]);

    }


    /**
     * login in as user
     *
     * @param string $uid
     * @return RedirectResponse
     */
    public function login(string $uid) :RedirectResponse{

        $user                        = User::where('uid',$uid)->firstOrfail();
        $user->email_verified_at     = Carbon::now();
        $user->	last_login           = Carbon::now();
        $user->save();
        Auth::guard('web')->loginUsingId($user->id);
        return redirect()->route('home')->with(response_status('Successfully logged In As a User'));
  
    }


    /**
     * update subscription
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function subscription(Request $request) :RedirectResponse{

        $request->validate([
            'id'              => 'required|exists:users,id',
            'package_id'      => 'required|exists:packages,id',
            'remarks'         => 'required|string',
        ]);
      
        $package =  Package::where('id',$request->input("package_id"))->firstOrfail();
        $user    =  User::with(['referral','subscriptions' => function($q){
                        return $q->running();
        }])->where('id',$request->input('id'))->first();

        $response = $this->userService->createSubscription($user,$package ,$request->input("remarks"));

        return  back()->with(response_status(Arr::get($response,"message","Subscription Updated"),Arr::get($response,"status",true) ? "success" :"error"));
    }

     /**
     * Bulk action
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function bulk(Request $request) :RedirectResponse {

        try {
            $response =  $this->bulkAction($request,[
                "model"        => new User(),
            ]);
    
        } catch (\Exception $exception) {
            $response  = \response_status($exception->getMessage(),'error');
        }
        return  back()->with($response);
    }


}
