<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Enums\AccountType;
use App\Enums\StatusEnum;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\SocialPostRequest;
use App\Http\Services\Account\facebook\Account;
use App\Models\Admin\Category;
use App\Models\Content;
use App\Models\MediaPlatform;
use App\Models\Package;
use App\Models\SocialAccount;
use App\Models\SocialPost;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Traits\AccoutManager;
use App\Traits\PostManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SocialPostController extends Controller
{
    use ModelAction , AccoutManager ,PostManager;

    public function __construct(){

        $this->middleware(['permissions:view_post'])->only(['list']);
        $this->middleware(['permissions:create_post'])->only('create','reconnect','store');
        $this->middleware(['permissions:update_post'])->only('updateStatus','bulk');
        $this->middleware(['permissions:delete_post'])->only('destroy');
    }




    /**
     * Social post list
     *
     * @return View
     */
    public function analytics() :View{

        return view('admin.social.post.analytics',[

            "title"           => translate("Post Analytics Dashboard"),
            'breadcrumbs'     => ['Home'=>'admin.home','Post Analytics '=> null],
            'data'            => $this->getDashboardData()



        ]);

    }




     /**
     * get dashboard data
     * 
     */

     public function getDashboardData() :array{


        $data['latest_post']               = SocialPost::with(['user','admin','account','account.platform','account.platform.file'])
                                                ->date()               
                                                ->latest()
                                                ->take(6)
                                                ->get();

        $data['total_account']            = SocialAccount::date()->count();
        $data['total_post']               = SocialPost::date()->count();
 
        $data['pending_post']             = SocialPost::pending()->date()->count();
        $data['schedule_post']            = SocialPost::schedule()->date()->count();
        $data['success_post']             = SocialPost::success()->date()->count();
        $data['failed_post']              = SocialPost::failed()->date()->count();
        $data['platform']                 = MediaPlatform::active()->integrated()->count();

        $postByPlatform                   = [];

        $socialMedias                     = MediaPlatform::with(['accounts' => function ($query) {
                                                $query->withCount('posts');
                                            }])
                                            ->active()
                                            ->integrated()
                                            ->get();

        foreach ($socialMedias as $socialMedia) {
            $postByPlatform[$socialMedia->name] =  $socialMedia->accounts->sum("posts_count");
        }

        $data['post_by_platform']  =  $postByPlatform;


               
    $data['monthly_post_graph']          = sortByMonth(SocialPost::date()->selectRaw("MONTHNAME(created_at) as months, COUNT(*) as total")
                                                ->whereYear('created_at', '=',date("Y"))
                                                ->groupBy('months')
                                                ->pluck('total', 'months')
                                                ->toArray(),true);

     $data['monthly_pending_post']      = sortByMonth(SocialPost::date()->selectRaw("MONTHNAME(created_at) as months, COUNT(*) as total")
                                                ->whereYear('created_at', '=',date("Y"))
                                                ->pending()
                                                ->groupBy('months')
                                                ->pluck('total', 'months')
                                                ->toArray(),true);

     $data['monthly_schedule_post']     = sortByMonth(SocialPost::date()->selectRaw("MONTHNAME(created_at) as months, COUNT(*) as total")
                                                ->whereYear('created_at', '=',date("Y"))
                                                ->schedule()
                                                ->groupBy('months')
                                                ->pluck('total', 'months')
                                                ->toArray(),true);

     $data['monthly_success_post']      = sortByMonth(SocialPost::date()->selectRaw("MONTHNAME(created_at) as months, COUNT(*) as total")
                                                ->whereYear('created_at', '=',date("Y"))
                                                ->success()
                                                ->groupBy('months')
                                                ->pluck('total', 'months')
                                                ->toArray(),true);

     $data['monthly_failed_post']      = sortByMonth(SocialPost::date()->selectRaw("MONTHNAME(created_at) as months, COUNT(*) as total")
                                                ->whereYear('created_at', '=',date("Y"))
                                                ->failed()
                                                ->groupBy('months')
                                                ->pluck('total', 'months')
                                                ->toArray(),true);
                        
    


        return $data;

     }




    /**
     * Social post list
     *
     * @return View
     */
    public function list() :View{

        return view('admin.social.post.list',[

            "title"           => translate("Social Post List"),
            'breadcrumbs'     => ['Home'=>'admin.home','Social Post'=> null],
            'posts'           => SocialPost::with(['user','admin','account','account.platform','account.platform.file'])
                                    ->filter(["status",'user:username','account:account_id'])
                                    ->date()
                                    ->latest()
                                    ->paginate(paginateNumber())
                                    ->appends(request()->all()),
            'accounts'        =>  SocialAccount::get()

        ]);

    }

    



    /**
     * Create a new post
     *
     * @return View
     */
    public function create() :View{



        $accounts = SocialAccount::where('admin_id',auth_user()->id)->with(['platform'])->active()->connected()->get();

        return view('admin.social.post.create',[
        
            "title"           => "Create Post",
            'breadcrumbs'     => ['Home'=>'admin.home',"Post"=> "admin.social.post.list","Create" => null],
            'accounts'        => $accounts,
            'contents'        => Content::whereNull("user_id")->get(),
            'categories'      => Category::template()->doesntHave('parent')->get(),
            'platforms'       => MediaPlatform::with(['file'])->integrated()->active()->get(),

        ]);
    }


    /**
     * store a new post
     *
     * @return RedirectResponse
     */
    public function store(SocialPostRequest $request) :RedirectResponse{
        $response = $this->savePost( $request->except(['_token']) ,auth_user());
        return back()->with('success',Arr::get($response,'message'));
    }


    /**
     * show a new post
     * 
     * @param string $uid
     *
     * @return RedirectResponse
     */
    public function show(string $uid) :View{

        $post  = SocialPost::with(['file','user','admin','account','account.platform','account.platform.file'])->where("uid",$uid)->firstOrfail();
        return view('admin.social.post.show',[
            "title"           => "Show Post",
            'breadcrumbs'     => ['Home'=>'admin.home',"Post"=> "admin.social.post.list","Show" => null],
            'post'            => $post,
            
        ]);

    }


    public function destroy(string $id) :RedirectResponse {

        $post  = SocialPost::with(['file','user','admin','account','account.platform','account.platform.file'])
                    ->where("id",$id)
                    ->firstOrfail();

        foreach($post->file as $file){
            $this->unlink(
                location    : config("settings")['file_path']['post']['path'],
                file        : $file
            );
        }
        $post->delete();

        $response =  response_status('Item deleted succesfully');


        return  back()->with($response);
    }


}