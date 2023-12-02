<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
use Pusher\Pusher;
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    /**
     * prepare meta data
     *
     * @param string $identifier
     * @param array $customData
     * @return array
     */
    public function metaData( array $customData = [], ) :array {


        [$width, $height] = explode('x', Arr::get($customData, "img_size", config("settings")['file_path']['user_site_logo']['size']));
        return  [

            'title'            => Arr::get($customData,"title", trans("default.home")),
            'og_type'          => Arr::get($customData,"og_type", 'website'),
            'og_image'         => Arr::get($customData,"og_image",imageUrl(@site_logo('user_site_logo')->file,"user_site_logo",true)),
            'og_image_type'    => "image/png",
            'og_image_width'   => $width,
            'og_image_height'  => $height,
            'twitter_card'     =>  Arr::get($customData,"twitter_card", 'summary'),
            'robots'           =>  Arr::get($customData,"robots", 'follow'),
            'meta_description' =>  Arr::get($customData,"meta_description", @site_settings("site_description")),
            "meta_keywords"    =>  Arr::get($customData,"keywords", json_decode(site_settings('site_meta_keywords',true))) 
            
        ];

    }
 
}
