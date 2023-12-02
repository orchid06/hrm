<?php

namespace App\Http\Controllers\User;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;

use App\Http\Services\PaymentService;
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

class UserController extends Controller
{
    
    protected $paymentService , $linkService;

    public function __construct(){
        
        $this->paymentService = new PaymentService();

    }



    /**
     * Pricing Plan
     *
     * @return View
     */
    public function plan(Request $request) :View{

        return view('user.plan',[
        
            'meta_data'=> $this->metaData(["title" => translate("Pricing Plan")]),
            'packages' => Package::active()->get(),
            "payment_methods" => PaymentMethod::with(['image'])
                                ->active()
                                ->orderBy('serial_id','asc')
                                ->get(),
            "subscription" => Subscription::where('user_id',auth_user('web')->id)
                ->where('status', StatusEnum::true->status())
                ->first()
        ]);
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
