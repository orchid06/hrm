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
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Traits\AccoutManager;
use App\Traits\PostManager;
use Illuminate\Support\Arr;

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
    public function list() :View{

        // return view('admin.social.post.list',[

        //     "title"           => translate("Social Post List"),
        //     'breadcrumbs'     => ['Home'=>'admin.home','Social Post'=> null],
        //     'posts'           => SocialAccount::with(['user','subscription','subscription.package','platform','admin'])
        //                             ->filter(["status",'user:username'])
        //                             ->latest()
        //                             ->paginate(paginateNumber())
        //                             ->appends(request()->all()),

        // ]);

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

}