<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Services\FrontendService;
use App\Models\Admin\Menu;
use App\Models\Article as Blog;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class FrontendController extends Controller
{


    private $frontendService;
    
    /**
     *
     * @return void
     */
    public function __construct(){
        $this->frontendService = new FrontendService();
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
    public function blogs() :View{


        return view('frontend.blogs',[
            'meta_data' => $this->metaData([
                "title" => trans('default.blogs')
            ]),

            'blogs'      => Blog::paginate(paginateNumber())
                                ->filter(['category:slug'])
                                ->search(['title'])
                                ->appends(request()->all())
        ]);
    }


     /**
     * get a specific blog details 
     *
     * @return View
     */
    public function blogDetails(string $slug) :View{

        $blog     = Blog::with(['category','file'])
                        ->active()->where('slug',$slug)
                        ->firstOrfail();

        $metaData = [
            "title"               =>  $blog->meta_title,
            "og_image"            =>  imageUrl(@$blog->file,"article",true),
            "img_size"            =>  config("settings")['file_path']['article']['size'],
            "meta_description"    =>  $blog->meta_description,
            "meta_keywords"       =>  (array) $blog->meta_keywords,
        ];

        return view('frontend.blog_details',[
            'meta_data' => $this->metaData($metaData),
            'menu'      => $blog
        ]);
  
    }






   
}
