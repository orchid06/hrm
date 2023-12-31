<?php

namespace App\Http\Services\Account\twitter;

use App\Enums\ConnectionType;
use App\Traits\AccoutManager;
use App\Enums\AccountType;
use App\Models\MediaPlatform;
use App\Models\SocialAccount;
use App\Models\SocialPost;
use Illuminate\Support\Arr;
use Coderjerk\BirdElephant\BirdElephant;
use Illuminate\Support\Facades\Http;
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
                    'user.fields' => 'id,name,url,verified,username,profile_image_url,auth_token'
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



    public function send(SocialPost $post) :array{

        try {

           $account           = $post->account;
           $accountConnection = $this->accountDetails($post->account);


           $isConnected       = Arr::get($accountConnection,'status', false);
           $message           = translate("Gateway connection error");
           $status            = false;

           if($isConnected){
               $message     = translate("Posted Successfully");
               $status      = true;
               $baseApi     = $account->platform->configuration->graph_api_url;
               $apiVersion  = $account->platform->configuration->app_version;
               $token       = $account->account_information->token;
               $api         =  $baseApi .$apiVersion;

               switch ($account->account_type) {
                   case AccountType::Profile->value:
                       $api =   $api."/me/feed";
                       break;
                   case AccountType::Page->value:
                       $fields = 'status_type,message,full_picture,created_time,permalink_url';
                       $api    =  $api."/".$account->account_id."/feed";
                       break;
   
                   case AccountType::Group->value:
                       $api =   $api."/".$account->account_id."/feed";
                   break;
               }
   
   
               $params = array(
                   'api'          => $api ,
                   'access_token' => $token,
               );
               
               if ($post->content) {
                   $params['message'] = $post->content;
               }
               if ($post->link) {
                   $params['link']    = $post->link;
               }

               if($post->file && $post->file->count() > 0){
                   foreach ($post->file as $file) {
                       $uploadParams = [
                           'access_token'  => $token,
                           'url'           => imageUrl($file,"post",true),
                           'published'     => false,
                       ];
                       $uploadResponse = Http::post($baseApi . $apiVersion . "/me/photos", $uploadParams);
                       $uploadData     = $uploadResponse->json();
                       if (isset($uploadData['id'])) {
                           $params['attached_media'][] = '{"media_fbid":"'.$uploadData['id'].'"}';
                       }
                   }
               }

               $response     = Http::post($params['api'], $params);
               $gwResponse   = $response->json();


               if(isset($gwResponse['error'])) {
                   $status  = false;
                   $message = $gwResponse['error']['message'];
               }
               else{
                   $url = "https://fb.com/".$gwResponse['id'];
               }

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
