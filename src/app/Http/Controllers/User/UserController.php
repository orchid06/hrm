<?php

namespace App\Http\Controllers\User;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;

use App\Http\Services\PaymentService;
use App\Http\Services\UserService;
use App\Http\Utility\SendNotification;
use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Admin\Category;
use Illuminate\View\View;

use App\Models\Admin\PaymentMethod;
use App\Models\PaymentLog;
use App\Models\Transaction;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    
    protected $paymentService ,$userService;

    public function __construct(){
        
        $this->paymentService   = new PaymentService();
        $this->userService      = new UserService();

    }






    /**
     * Purchase a  Plan
     *
     * @return View
     */
    public function planPurchase(string $slug) :RedirectResponse{

        $user      = auth_user('web');
        $package   = Package::where("slug",$slug)->firstOrfail();
        $response  = $this->userService->createSubscription($user,$package);
        $status    = isset($response['status']) 
                         ? 'success' 
                         : 'error';
        
        return back()->with(response_status(Arr::get($response,"message",trans("default.something_went_wrong")),$status));
    }






   


   
    /**
     * payment log
     *
     * @return View
     */
    public function paymentLog() :View{

        return view('user.payment.log',[
            'meta_data'=> $this->metaData(['title' => 'Payment log']),
            'payment_logs' => PaymentLog::filter(request())->with(['package','user','method'])
            ->latest()
            ->where('user_id',auth_user('web')->id)
            ->paginate(paginateNumber())
            ->appends(request()->all()),
        ]);
    }


    /**
     * Subscription log
     *
     * @return View
     */
    public function subscription() :View{

        return view('user.subscription',[
            'meta_data'=> $this->metaData(['title' => 'Subscription log']),
            'subscriptions' => Subscription::with(['package','trx','trx.method'])->filter(request())
            ->latest()
            ->where('user_id',auth_user('web')->id)
            ->paginate(paginateNumber())
            ->appends(request()->all()),
        ]);
    }


    /**
     * transaction log
     *
     * @return View
     */
    public function transaction() :View{

        return view('user.transaction',[
            'meta_data'=> $this->metaData(['title' => 'Transaction log']),
            'transactions' => Transaction::with(['method'])->filter(request())
            ->latest()
            ->where('user_id',auth_user('web')->id)
            ->paginate(paginateNumber())
            ->appends(request()->all()),
        ]);
    }



    /**
     * payment show
     *
     * @return View
     */
    public function paymentShow(string $id) :View{

        return view('user.payment.show',[
            'meta_data'=> $this->metaData(['title' => 'Payment Log Show']),
            'log' => PaymentLog::with(['package','user','method'])
            ->latest()
            ->where('user_id',auth_user('web')->id)
            ->where('id',$id)
            ->firstOrFail()
        ]);
    }
}
