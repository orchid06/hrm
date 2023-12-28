<?php

namespace App\Http\Services\Account\twitter;

use App\Enums\ConnectionType;
use App\Traits\AccoutManager;
use App\Enums\AccountType;
use App\Models\MediaPlatform;
use Illuminate\Support\Arr;
use Coderjerk\BirdElephant\BirdElephant;
class Account
{
    

    use AccoutManager;


    public $twUrl ,$params ;
    public function __construct(){
        $this->twUrl = "https://twitter.com/";

        $this->params = [
            'expansions' => 'pinned_tweet_id',
            'user.fields' => 'id,name,url,verified,username,profile_image_url'
        ];

    }

    
    /**
     * Instagram account connecton
     *
     * @param MediaPlatform $platform
     * @param array $request
     * @param string $guard
     * @return array
     */
    public function twitter(MediaPlatform $platform ,  array $request , string $guard = 'admin') :array{

        $responseStatus   = response_status(translate('Authentication failed incorrect keys'),'error');

        try {

            $responseStatus  = response_status(translate('Api error'),'error');
            $consumer_key    = Arr::get($request,'consumer_key',null);
            $consumer_secret = Arr::get($request,'consumer_secret',null);
            $access_token    = Arr::get($request,'access_token',null);
            $token_secret    = Arr::get($request,'token_secret',null);
            $bearer_token    = Arr::get($request,'bearer_token',null);
            
                $config = array(
                    'consumer_key'      => $consumer_key,
                    'consumer_secret'   => $consumer_secret,
                    'bearer_token'      => $bearer_token,
                    'token_identifier'  => $access_token,
                    'token_secret'      => $token_secret  
                );

                $twitter = new BirdElephant($config);

                $response = $twitter->me()->myself([
                    'expansions' => 'pinned_tweet_id',
                    'user.fields' => 'id,name,url,verified,username,profile_image_url'
                ]);

                if($response->data && $response->data->id){
                    $responseStatus   = response_status(translate('Account Created'));
                    $config           = array_merge($config , (array)$response->data);
                    $config['link']   =  $this->twUrl.Arr::get($config,'username');
                    $config['avatar'] = Arr::get($config,'profile_image_url');
                    $response         = $this->saveAccount($guard,$platform,$config,AccountType::Profile->value ,ConnectionType::OFFICIAL->value);
                }


        } catch (\Exception $ex) {
            $responseStatus   = response_status(strip_tags($ex->getMessage()),'error');
        }

      
        return     $responseStatus ;


    }


    

}
