<?php

namespace App\Http\Controllers;

use App\Models\Admin\Frontend;
use App\Models\Admin\Menu;
use App\Models\Admin\Page;
use App\Models\Blog;
use App\Models\Package;
use Illuminate\View\View;

class FrontendController extends Controller
{


    public  $lastSegment;

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

        $blogContent  = get_content("content_blog")->first();

        return view('frontend.blogs',[
            'meta_data'   => $this->metaData([
                "title"    => trans('default.blogs')
            ]),

            'blogs'        => Blog::search(['title'])
                                            ->filter(['category:slug'])
                                            ->paginate(paginateNumber())
                                            ->appends(request()->all()),
                                            
            'menu'         => Menu::where('url',$this->lastSegment)->active()->firstOrfail(),

            'breadcrumbs'  => ['Home'=>'home',"Blogs" => null],
            'banner'       => (object) ['title' => @$blogContent->value->sub_title , 'description' => @$blogContent->value->description]
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
                                        ->take(6)
                                        ->get();

        $metaData = [
            "title"               =>  $blog->meta_title,
            "og_image"            =>  imageURL(@$blog->file,"blog",true),
            "img_size"            =>  config("settings")['file_path']['blog']['size'],
            "meta_description"    =>  $blog->meta_description,
            "meta_keywords"       =>  (array) $blog->meta_keywords,
        ];

        return view('frontend.blog_details',[
            'meta_data'         => $this->metaData($metaData),
            'blog'              => $blog,
            'related_blogs'     => $relatedBlogs,
            'breadcrumbs'       => ['Home'=>'home',"Blogs" => 'blog',$blog->title => null],
            'banner'            => (object) ['title' => $blog->title , 'description' => limit_words(strip_tags($blog->description),100)]
        ]);
  
    }


    /**
     * @return View
     */
    public function plan() :View{

        $planContent  = get_content("content_plan")->first();

        return view('frontend.plans',[
            'meta_data' => $this->metaData(["title"    =>  trans('default.plan')] ),
            'menu'      => Menu::where('url',$this->lastSegment)->active()->firstOrfail(),
            "plans"     => Package::active()->get(),
            'breadcrumbs'       => ['Home'=>'home',"Plans" => null],
            'banner'            => (object) ['title' => @$planContent->value->sub_title , 'description' => @$planContent->value->description]
        ]);
    }




    /**
     * View Pages
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
            'meta_data'    => $this->metaData($metaData),
            'page'         => $page,
            'breadcrumbs'  => ['Home'=>'home',$page->title => null],
            'banner'       => (object) ['title' => $page->title , 'description' => limit_words(strip_tags($page->description),100)]
        ]);
    }



    /**
     * View integration details
     *
     * @return View
     */
    public function integration(string $slug ,string $uid) :View{

        $section          = Frontend::active()->where('uid',$uid)
                                              ->firstOrfail();
        return view('frontend.integration',[
            'meta_data'    => $this->metaData([ "title" => $section->value->title]),
            'section'      => $section,
            'breadcrumbs'  =>  ['Home'=>'home',$section->value->title => null],
            'banner'       => (object) ['title' => @$section->value->title , 'description' => limit_words(strip_tags(@$section->value->short_description),100)]
        ]);

    }



    /**
     * View Service details
     *
     * @return View
     */
    public function service(string $slug ,string $uid) :View{

        $service          = Frontend::active()->where('uid',$uid)
                                              ->firstOrfail();
        return view('frontend.service',[
            'meta_data'    => $this->metaData([ "title" => $service->value->title]),
            'service'      => $service,
            'breadcrumbs'  =>  ['Home'=>'home',$service->value->title => null],
            'banner'       => (object) ['title' => @$service->value->title , 'description' => limit_words(strip_tags(@$service->value->description),100)]
        ]);

    }


   
}
