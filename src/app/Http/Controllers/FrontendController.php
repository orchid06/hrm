<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Services\FrontendService;

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
    public function frontend() :View{
        
        return view('frontend.home',[
            'meta_data'=> $this->metaData([],"home")
        ]);
    }


   
}
