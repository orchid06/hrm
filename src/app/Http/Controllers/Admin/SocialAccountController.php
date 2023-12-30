<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AccountType;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Services\Account\facebook\Account;
use App\Models\MediaPlatform;
use App\Models\Package;
use App\Models\SocialAccount;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Traits\AccoutManager;
class SocialAccountController extends Controller
{
    use ModelAction , AccoutManager;

    public function __construct(){

        $this->middleware(['permissions:view_account'])->only(['list']);
        $this->middleware(['permissions:create_account'])->only('create','reconnect','store');
        $this->middleware(['permissions:update_account'])->only('updateStatus','bulk');
        $this->middleware(['permissions:delete_account'])->only('destroy');
    }


    /**
     * Social account list
     *
     * @return View
     */
    public function list() :View{

        return view('admin.social.account.list',[

            "title"           => translate("Social Account List"),
            'breadcrumbs'     => ['Home'=>'admin.home','Social Accounts'=> null],
            'accounts'        => SocialAccount::with(['user','subscription','subscription.package','platform','admin'])
                                    ->filter(["status",'user:username','platform:slug'])
                                    ->latest()
                                    ->paginate(paginateNumber())
                                    ->appends(request()->all()),

        ]);
    }

    


    

    /**
     * Create a new account
     *
     * @return View
     */
    public function create(string $slug) :View{


        $platform = MediaPlatform::with(['file'])->active()
                        ->integrated()
                        ->where('slug', $slug)
                        ->firstOrfail();

        $route   = route('admin.social.account.list',['platform' => $platform->slug]);

        return view('admin.social.account.create',[

            "title"           =>  "Create ".$platform->name. " Account",
            'breadcrumbs'     => ['Home'=>'admin.home',"Accounts"=> $route,"Create" => null],
            'platform'        => $platform,

        ]);
    }


    /**
     * store a new account
     *
     * @return RedirectResponse
     */
    public function store(AccountRequest $request) :RedirectResponse{


        $platform = MediaPlatform::where('id',request()->input("platform_id"))
                        ->active()
                        ->integrated()
                        ->firstOrfail();


        $class   = 'App\\Http\\Services\\Account\\'.$platform->slug.'\\Account';

        $service =  new  $class();

        $response = $service->{$platform->slug}($platform,$request->except("_token"));
        return back()->with($response);
        

    }


    /**
     * store a new account
     *
     * @return RedirectResponse
     */
    public function reconnect(Request $request) :RedirectResponse{

        $request->validate([
            'id'           => "required|exists:social_accounts,id",
            'access_token' => "required",
        ]);
        

        $account = SocialAccount::with('platform')->where("id",request()->input("id"))->firstOrfail();

        $request->merge([
            'account_type' => $account->account_type,
            'page_id'      => $account->account_type == AccountType::Page->value ? $account->account_id : null,
            'group_id'     => $account->account_type == AccountType::Group->value ? $account->account_id : null,
        ]);

        
       
        $class   = 'App\\Http\\Services\\Account\\'.$account->platform->slug.'\\Account';

        $service =  new  $class();

        $response = $service->{$account->platform->slug}($account->platform,$request->except("_token"));
        return back()->with($response);
    }


     /**
     * store a new account
     *
     * @return RedirectResponse
     */
    public function show(string $uid) :View | RedirectResponse{

        $account  = SocialAccount::with(['platform'])
                        ->where('uid',$uid)
                        ->firstOrfail();

        $class    = 'App\\Http\\Services\\Account\\'.$account->platform->slug.'\\Account';
        $service  =  new  $class();

        $response = $service->accoountDetails($account);

        if(!$response['status']){
            return redirect()->route('admin.social.account.list',['platform' => $account->platform->slug])->with('error',$response['message']);
        }

        $route   = route('admin.social.account.list',['platform' => $account->platform->slug]);

        return view('admin.social.account.show',[

            "title"           => "Account Feeds",
            'breadcrumbs'     => ['Home'=>'admin.home',"Accounts"=> $route,"Create" => null],
            'response'        => $response,
            'account'         => $account,

        ]);
        

    }

    public function destroy(string $id) :RedirectResponse {

        $account  = SocialAccount::withCount(['posts'])->where('id',$id)->firstOrfail();
        $response =  response_status('Can not be deleted!! item has related data','error');
        if(1  > $account->posts_count){
            $account->delete();
            $response =  response_status('Item deleted succesfully');
        }
        return  back()->with($response);
    }


    


    /**
     * Update a specific platform status
     *
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request) :string{

        $request->validate([
            'id'      => 'required|exists:social_accounts,uid',
            'status'  => ['required',Rule::in(StatusEnum::toArray())],
            'column'  => ['required',Rule::in(['status','is_feature','is_integrated'])],
        ]);


        return $this->changeStatus($request->except("_token"),[
            "model"    => new SocialAccount(),
        ]);

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
                "model"        => new SocialAccount(),
            ]);
    
        } catch (\Exception $exception) {
            $response  = \response_status($exception->getMessage(),'error');
        }
        return  back()->with($response);
    }




    
}
