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
    
    protected $userService;

    public function __construct(){
        
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






 
}
