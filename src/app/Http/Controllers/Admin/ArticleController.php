<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Admin\Category;
use App\Models\Article;
use App\Models\Core\File;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Traits\ModelAction;
use App\Traits\Fileable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Closure;

class ArticleController extends Controller
{


    use ModelAction , Fileable;
    protected $categories;
    /**
     *
     * @return void
     */
     public function __construct(){

        //check permissions middleware
        $this->middleware(['permissions:view_blog'])->only(['list']);
        $this->middleware(['permissions:create_blog'])->only(['store','create']);
        $this->middleware(['permissions:update_blog'])->only(['updateStatus','update','edit','bulk']);
        $this->middleware(['permissions:delete_blog'])->only(['destroy','bulk']);
        
        $this->middleware(function (Request $request, Closure $next) {
            $this->categories = Category::article()->get();
            return $next($request);
        });

    }


    /**
     * Article list
     *
     * @return View
     */
    public function list() :View{

        return view('admin.article.list',[

            'breadcrumbs'  => ['Home'=>'admin.home','Blogs'=> null],
            'title'        => 'Manage Blogs',
            'articles'     => Article::search(['title'])
                                ->filter(["status",'category:slug','is_feature'])
                                ->latest()
                                ->paginate(paginateNumber())
                                ->appends(request()->all()),

            "categories"   => $this->categories
        ]);
    }





    
    
    /**
     * craate a  new article
     *
     */
    public function create() :View{

        return view('admin.article.create',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Blogs'=> 'admin.article.list',"Create"=>null],
            'title'       => 'Create Blog',
            'categories'  =>  $this->categories,
        ]);

    }


    /**
     * store a  new Article
     *
     * @param ArticleRequest $request
     * @return RedirectResponse
     */
    public function store(ArticleRequest $request) :RedirectResponse{

        DB::transaction(function() use ($request) {

            $article                  =  new Article();
            $article->title           =  $request->input("title");
            $article->category_id     =  $request->input("category_id");
            $article->description     =  $request->input("description");
            $article->save();
            if($request->hasFile('image')){

                $response = $this->storeFile($request->file('image'), config("settings")['file_path']['article']['path']);
                if(isset($response['status'])){
                    $image = new File([
                        'name'      => Arr::get($response, 'name', '#'),
                        'disk'      => Arr::get($response, 'disk', 'local'),
                        'type'      => 'feature',
                        'size'      => Arr::get($response, 'size', ''),
                        'extension' => Arr::get($response, 'extension', ''),
                    ]);
                    $article->file()->save($image);
                }
            }
        });

        return  back()->with(response_status('Article created successfully'));
    }





    /**
     * edit a  new article
     *
     */
    public function edit(string $uid) :View{

        return view('admin.article.edit',[
            'breadcrumbs' => ['Home'=>'admin.home','Blogs'=> 'admin.article.list',"Edit"=>null],
            'title'       => 'Update Blog',
            'categories'  => $this->categories,
            'article'     => Article::where('uid',$uid)->firstOrfail()
        ]);

    }



    /**
     * Update a specific Article
     *
     * @param ArticleRequest $request
     * @return RedirectResponse
     */
    public function update(ArticleRequest $request) :RedirectResponse {



        DB::transaction(function() use ($request) {

            $article                  =  Article::where('id',$request->input('id'))->firstOrfail();
            $article->title           =  $request->input("title");
            $article->category_id     =  $request->input("category_id");
            $article->description     =  $request->input("description");
            $article->save();
            if($request->hasFile('image')){
                
                $oldFile = $article->file()->where('type','feature')->first();
                $response = $this->storeFile(
                    file        : $request->file('image'), 
                    location    : config("settings")['file_path']['article']['path'],
                    removeFile  : $oldFile
                );

                if(isset($response['status'])){
                    $image = new File([
                        'name'      => Arr::get($response, 'name', '#'),
                        'disk'      => Arr::get($response, 'disk', 'local'),
                        'type'      => 'feature',
                        'size'      => Arr::get($response, 'size', ''),
                        'extension' => Arr::get($response, 'extension', ''),
                    ]);
                    $article->file()->save($image);
                }
            }
        });
      
        return  back()->with(response_status('Article Updated Successfully'));
    }

    /**
     * Update a specific Article status
     *
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request) :string{

        $request->validate([
            'id'      => 'required|exists:articles,uid',
            'status'  => ['required',Rule::in(StatusEnum::toArray())],
            'column'  => ['required',Rule::in(['status','is_feature'])],
        ]);

        return $this->changeStatus($request->except("_token"),[
            "model"    => new Article(),
        ]);
    }


    public function destroy(string | int $uid) :RedirectResponse{

        $article  = Article::where('uid',$uid)->firstOrfail();
        $this->unlink(
            location    : config("settings")['file_path']['article']['path'],
            file        : $article->file()->where('type','feature')->first()
        );
        $article->delete();
        return  back()->with(response_status('Item deleted succesfully'));
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
                "model"        => new Article(),
                "file_unlink"  => [
                    "feature"   =>  config("settings")['file_path']['article']['path']
                ],
            ]);
    
        } catch (\Exception $exception) {
            $response  = \response_status($exception->getMessage(),'error');
        }
        return  back()->with($response);
    }
}
