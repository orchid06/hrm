<?php

namespace App\Http\Services\Account\twitter;

use App\Enums\ConnectionType;
use App\Traits\AccountManager;
use App\Enums\AccountType;
use App\Models\MediaPlatform;
use App\Models\SocialAccount;
use App\Models\SocialPost;
use Illuminate\Support\Arr;
use Coderjerk\BirdElephant\BirdElephant;
use Illuminate\Support\Facades\Http;

use Coderjerk\BirdElephant\Compose\Tweet;

class Account
{
    

    use AccountManager;

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

                $accountId   = Arr::get($request,'account_id', null);

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
                    'expansions'  => 'pinned_tweet_id',
                    'user.fields' => 'id,name,url,verified,username,profile_image_url'
                ]);
                
                if($response->data && $response->data->id){
                    $responseStatus       = response_status(translate('Account Created'));
                    $config               = array_merge($config , (array)$response->data);
    
                    $config['link']       =  $this->twUrl.Arr::get($config,'username');
                    $config['avatar']     = Arr::get($config,'profile_image_url');

                    $config['account_id'] =  Arr::get($config,'id');

                    $response         = $this->saveAccount($guard,$platform,$config,AccountType::PROFILE->value ,ConnectionType::OFFICIAL->value ,$accountId);
                }
              


        } catch (\Exception $ex) {
           
        }

      
        return     $responseStatus ;


    }



    public function send(SocialPost $post) :array{


        try {

            $status        = false;
            $message       = 'Failed to tweet!!! Configuration error';
            $account       = $post->account;
            $accountConfig = $account->account_information;

            $config = array(
                'consumer_key'      => $accountConfig->consumer_key,
                'consumer_secret'   => $accountConfig->consumer_secret,
                'bearer_token'      => $accountConfig->bearer_token,
                'token_identifier'  => $accountConfig->token_identifier,
                'token_secret'      => $accountConfig->token_secret  
            );

            $twitter = new BirdElephant($config);
            
            $tweet = '';
            if ($post->content) $tweet  .= $post->content;
            if ($post->link)  $tweet  .= $post->link;

            $mediaIds = [];

            if($post->file && $post->file->count() > 0){
                foreach ($post->file as $file) {
                   $fileURL = imageURL($file,"post",true);
                   $image      = $twitter->tweets()->upload($fileURL);
                   if(isset($image->media_id_string)) $mediaIds[] = $image->media_id_string;
                }
            }

            if(count($mediaIds) > 0){
                $media = (new \Coderjerk\BirdElephant\Compose\Media)->mediaIds(
                    $mediaIds
                );
                $tweet    = (new Tweet)->text($tweet)->media($media);
            }
            else{
                $tweet    = (new Tweet)->text($tweet);
            }


            $response = $twitter->tweets()->tweet($tweet);
            if(isset($response->data->id)) {
                
                $message       = translate("Posted Successfully");
                $status        = true;
                $url           =  "https://twitter.com/tweet/status/".$response->data->id;
            }

        } catch (\Exception $ex) {
           $status  = false;
           $message = strip_tags($ex->getMessage());
        }

        return [
           'status'   => $status,
           'response' => $message,
           'url'      => @$url
       ];

   }



    

}
