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
    public function metaData( array $customData = [],string $identifier  = null ) :array {

        $siteTitle  =  Arr::get($customData,"title", '');
        $keywords  =  Arr::get($customData,"keywords", []);
        if($identifier){
            $seo = seo_data($identifier);
            $siteTitle =  @get_translation($seo->title);
            $keywords =  $seo->meta_keywords;
        }

        [$width, $height] = explode('x', Arr::get($customData, "img_size", config("settings")['file_path']['user_site_logo']['size']));

        $metaData = [
            'title' => $siteTitle,
            'og_type' => Arr::get($customData,"og_type", 'website'),
            'og_image' => Arr::get($customData,"og_image", imageUrl(config("settings")['file_path']['user_site_logo']['path']."/".@site_logo('user_site_logo')->file->name ,@site_logo('user_site_logo')->file->disk)),
            'og_image_type' => "image/png",
            'og_image_width' => $width,
            'og_image_height' => $height,
            'twitter_card' =>  Arr::get($customData,"twitter_card", 'summary'),
            'robots' =>  Arr::get($customData,"robots", 'follow'),
            'meta_description' =>  Arr::get($customData,"meta_description", @site_settings("site_description")),
            "meta_keywords" => (array) $keywords 
        ];
     
        return $metaData;
    }
    
    public function triggerPusher(array $setting) :bool{

        try {

            $pusher_settings =  json_decode(site_settings('pusher_settings'),true);

            $options = array(
                'cluster' => $pusher_settings['app_cluster'],
                'useTLS' => true,
            );
    
            $pusher = new Pusher(
                $pusher_settings['app_key'], $pusher_settings['app_secret'], $pusher_settings['app_id'], $options
            );

            $pusher->trigger( Arr::get($setting,"channel", 'live-chat') , Arr::get($setting,"event", 'new-message'), ['data' => Arr::get($setting,"data", [])]);

            return true;
        } catch (\Throwable $th) {
            return false;
        }


    }

 
}
