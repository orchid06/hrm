<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Services\FrontendService;
use App\Models\Admin\Category;
use App\Models\Admin\Menu;
use App\Models\Admin\Page;
use App\Models\Package;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class FrontendController extends Controller
{


    public $lastSegment;

    public function __construct()
    {
       $this->lastSegment = collect(request()->segments())->last();
   
    }
    /**
     * frontent view
     *
     * @return View
     */
    public function home() :View{
    
        return view('frontend.home',[
            'meta_data' => $this->metaData(),
            'menu'      => Menu::default()->first()
        ]);
    }


  
    /**
     * get all blogs 
     *
     * @return View
     */
    public function blog() :View{

        return view('frontend.blogs',[
            'meta_data'   => $this->metaData([
                "title"   => trans('default.blogs')
            ]),

            'blogs'       => Blog::search(['title'])
                                ->filter(['category:slug'])
                                ->paginate(paginateNumber())
                                ->appends(request()->all()),
            "categories"  => Category::active()->whereHas("articles")->get(),
            'menu'        => Menu::where('url',$this->lastSegment)->active()->firstOrfail()
        ]);
    }


    /**
     * get a specific blog details 
     *
     * @return View
     */
    public function blogDetails(string $slug) :View{

        $blog          = Blog::active()->where('slug',$slug)
                            ->firstOrfail();

        $relatedBlogs  = Blog::active()
                          ->where("category_id",$blog->category_id)
                          ->where('id','!=',$blog->id)
                          ->take(4)
                          ->get();

        $metaData = [
            "title"               =>  $blog->meta_title,
            "og_image"            =>  imageURL(@$blog->file,"article",true),
            "img_size"            =>  config("settings")['file_path']['article']['size'],
            "meta_description"    =>  $blog->meta_description,
            "meta_keywords"       =>  (array) $blog->meta_keywords,
        ];

        return view('frontend.blog_details',[
            'meta_data'         => $this->metaData($metaData),
            'blog'              => $blog,
            'related_blogs'     => $relatedBlogs,
        ]);
  
    }


    /**
     * frontent view
     *
     * @return View
     */
    public function plan() :View{
        return view('frontend.plans',[
            'meta_data' => $this->metaData(
                [
                    "title"    =>  trans('default.plan')
                ]
            ),
            'menu'      => Menu::where('url',$this->lastSegment)->active()->firstOrfail(),
            "plans"     => Package::active()->get()
        ]);
    }




    /**
     * view Pages
     *
     * @return View
     */
    public function page(string $slug) :View{


        $page          = Page::active()->where('slug',$slug)
                          ->firstOrfail();

        $metaData = [
            "title"               =>  $page->meta_title,
            "meta_description"    =>  $page->meta_description,
            "meta_keywords"       =>  (array) $page->meta_keywords,
        ];

        return view('frontend.page',[
            'meta_data'   => $this->metaData($metaData),
            'page'        => $page,
        ]);
    }


   
}
