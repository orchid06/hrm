<?php

namespace App\Http\Services\Account\instagram;

use App\Enums\ConnectionType;
use App\Traits\AccountManager;
use App\Enums\AccountType;
use App\Enums\PostType;
use App\Models\MediaPlatform;
use App\Models\SocialAccount;
use App\Models\SocialPost;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use App\Http\Services\Account\instagram\AccountConfig;
use App\Models\Core\File;

class Account
{
    

    use AccountManager;

    public $igUrl ;
    public function __construct(){
        $this->igUrl = "https://www.instagram.com/";
    }

    
    /**
     * Instagram account connecton
     *
     * @param MediaPlatform $platform
     * @param array $request
     * @param string $guard
     * @return array
     */
    public function instagram(MediaPlatform $platform ,  array $request , string $guard = 'admin') :array{

        $responseStatus   = response_status(translate('Invalid username or password'),'error');
        try {
            
            $username    = Arr::get($request,'username',null);
            $password    = Arr::get($request,'password',null);
            $config      = new AccountConfig($username , $password);
            $resposne    = $config->login();
            if(isset($resposne['logged_in_user'])){
                $responseStatus   = response_status(translate('Account Created'));
                $igUser  = $resposne['logged_in_user'];
                $accountInfo = [
                    'id'         => Arr::get($igUser,'pk',null), 
                    'account_id' => Arr::get($igUser,'pk',null), 
                    'username'   => Arr::get($igUser,'username',null),
                    'name'       => Arr::get($igUser,'username',null),
                    'password'   => $password,
                    'link'       => $this->igUrl.Arr::get($igUser,'username',null),
                    'avatar'     => Arr::get($igUser,'profile_pic_url',null) ,
                ];
    
                $this->saveAccount($guard ,$platform , $accountInfo ,AccountType::PROFILE->value ,ConnectionType::UNOFFICIAL->value );
            }
        } catch (\Exception $ex) {
            $responseStatus   = response_status(strip_tags($ex->getMessage()),'error');
        }

      
        return     $responseStatus ;


    }

    
    public function accountDetails(SocialAccount $account) : array {


        try {

            $baseApi     = $account->platform->configuration->graph_api_url;
            $apiVersion  = $account->platform->configuration->app_version;
            $api         = $baseApi."/".$apiVersion;
            $token       = $account->account_information->token;
            $userId      = $account->account_id;
            $apiUrl      = $api."/".$userId."/media";
            $fields      = 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp';

            $params = [
                'fields' => $fields,
                'access_token' => $token,
            ];
            
            $response = Http::get($apiUrl, $params);
            $apiResponse = $response->json();
      
            if(isset($apiResponse['error'])) {

                $this->disConnectAccount($account);
                return [
                    'status'  => false,
                    'message' => $apiResponse['error']['message']
                ];
            }

            $apiResponse  = $this->formatResponse($apiResponse);
        
            return[
                'status'        => true,
                'response'      => $apiResponse,
            ];


        } catch (\Exception $ex) {
            
           return [
               'status'  => false,
               'message' => strip_tags($ex->getMessage())
           ];
        }
    
    }

    public function formatResponse(array $response) : array {

        
        $responseData = Arr::get($response,'data', []);

        if(count($responseData) > 0) {

            $formattedData = [];
            foreach($responseData as $key => $value) {
                $formattedData [] = [
                    'status_type' => Arr::get($value,'media_type',null),
                    'full_picture' => Arr::get($value,'media_url',null),
                    'link' => Arr::get($value,'permalink',null),
                    'created_time' => Arr::get($value,'timestamp',null),
                ];
            }
            $response ['data'] = $formattedData;
        }

        return   $response;


    }


    public function send(SocialPost $post) :array{
        $account           = $post->account;
        if($account->is_official  == ConnectionType::OFFICIAL->value) return $this->official($post);
        return  $this->unofficial($post);
   }


   public function official(SocialPost $post) :array{

        try {

            $account           = $post->account;
            $platform          = @$post->account->platform->configuration;
            $accountConnection = $this->accountDetails($account);

            $isConnected       = Arr::get($accountConnection,'status', false);
            $message           = translate("Invalid access token");
            $status            = false;
            $token             = $account->account_information->token;

            if($isConnected && $post->file && $post->file->count() > 0){
                $message       = translate("Text and url not supported in insta feed");
                

                if($post->file && $post->file->count() > 0){
                    $message     = translate("Posted Successfully");
                    $status      = true;

                    $igConnection = new \JanuSoftware\Facebook\Facebook([
                                        'app_id'                => $platform->client_id,
                                        'app_secret'            => $platform->client_secret,
                                        'default_graph_version' => $platform->app_version,
                                    ]);

            
                    #POST IN FEED
                    if($post->post_type == PostType::FEED->value){
                        $response = $this->postFeed($post,$igConnection);
                    }
                    #POST IN REELS
                    elseif($post->post_type == PostType::REELS->value){
                        $response = $this->postReel($post,$igConnection);
                    }
                    #POST IN REELS
                    elseif($post->post_type == PostType::STORY->value){
                        $response = $this->postStory($post,$igConnection);
                    }

                    $url     = Arr::get( $response ,'url');
                    $message = Arr::get( $response ,'message',$message);
                    $status  = Arr::get( $response ,'status',$status);
                    
                }
 
            }

            
        } catch (\Exception $ex) {
            $status  = false;
            $message = strip_tags($ex->getMessage());
        }

        return [
            'status'   => @$url ? false : true,
            'response' => @$message,
            'url'      => @$url
        ]; 

   }



   /**
    * Summary of postFeed
    * @param \App\Models\SocialPost $post
    * @param mixed $ig
    * @return array
    */
   public function postFeed(SocialPost $post,mixed $ig): array{

        $account           = $post->account;

        $token             = $account->account_information->token;

        $upload_endpoint = "/".$account->account_id."/media";
        $endpoint        = "/".$account->account_id."/media_publish";

        $media_ids = [];

        if($post->file->count() > 1){

            foreach ($post->file as $file) {

                $fileURL = imageURL($file,"post",true);
                $upload_params = [
                    'media_type' => "VIDEO",
                    'video_url' =>  $fileURL,
                    'caption' => $post->content??"feed",,
                    'is_carousel_item' => true
                ];

                if(check_image($fileURL)){
                    $upload_params = [
                        'image_url'        => $fileURL,
                        'caption'          => $post->content??"feed",
                        'is_carousel_item' => true
                    ];
                }

                $upload_response = $ig->post( $upload_endpoint, $upload_params, $token)->getDecodedBody();
                $media_ids[]     = @$upload_response['id'];
        
            }

            $upload_params = [
                'media_type' => 'CAROUSEL',
                'children'   => $media_ids,
                'caption'    => $post->content??"feed"
            ];
        
            $upload_response = $ig->post( $upload_endpoint, $upload_params, $token)->getDecodedBody();
            $params = ['creation_id' => $upload_response['id']];

            $response = $ig->post( $endpoint, $params, $token)->getDecodedBody();
            if(@$response["id"]){
                $media_response = $ig->get( "/". $response["id"]."?fields=shortcode",$token)->getDecodedBody();
                $url  = "https://www.instagram.com/p/".$media_response['shortcode'];
            }

        }
        else{
            
            $file          = $post->file->first();
            $params        = $this->uploadMedia($file ,$ig ,$post->content?? "feed" ,$token ,$upload_endpoint);
            $response      = $ig->post( $endpoint, $params, $token)->getDecodedBody();
            if(@$response["id"]){
                $mediaResponse = $ig->get( "/". @$response["id"]."?fields=shortcode", $token)->getDecodedBody();
                $url           = "https://www.instagram.com/p/".@$mediaResponse['shortcode'];
            }
        }

        return [
            'url'        => @$url,
            'status'     => @$url ? true : false,
            'message'    => @$url ? translate('Posted successfully') : translate('Failed to post'),
        ];

   }

  

    /**
     * Summary of uploadMedia
     * @param \App\Models\Core\File $file
     * @param mixed $ig
     * @param string $caption
     * @param string $token
     * @param string $upload_endpoint
     * @return mixed
     */
    public function uploadMedia(File $file , mixed $ig , string $caption , string $token,string $upload_endpoint): array {

        $fileURL = imageURL($file,"post",true);

        $upload_params = [
            'media_type' => "VIDEO",
            'video_url' =>  $fileURL ,
            'caption' => $caption
        ];
        
        if(check_image($fileURL)){
            $upload_params = ['image_url' => imageURL($file,"post",true),'caption'   => $caption];
        }
        $uploadResponse = $ig->post( $upload_endpoint, $upload_params, $token)->getDecodedBody();
        return  ['creation_id' => $uploadResponse['id']];
    }



   public function postReel(SocialPost $post,mixed $ig) :array{

        $account           = $post->account;

        $token             = $account->account_information->token;

        $upload_endpoint   = "/".$account->account_id."/media";
        $endpoint          = "/".$account->account_id."/media_publish";

         $file             = $post->file->first();

         $fileURL = imageURL($file,"post",true);

         if(isValidVideoUrl($fileURL)){

            $upload_params = [
                'media_type' => "REELS",
                'video_url'  =>  $fileURL,
                'caption'    =>  $post->content?? "feed"
            ];
            $upload_response = $ig->post( $upload_endpoint, $upload_params, $token)->getDecodedBody();

            $params   = ['creation_id' => $upload_response['id']];
            $response = $ig->post( $endpoint, $params, $token)->getDecodedBody();


            if(@$response['id']){
                $mediaResponse = $ig->get( "/". $response["id"]."?fields=shortcode", $token)->getDecodedBody();
                $url           = "https://www.instagram.com/p/".@$mediaResponse['shortcode'];
                return [
                    'url'        => @$url,
                    'status'     => true ,
                    'message'    => translate('Posted successfully')
                ];
            }
    
         }
         
        return [
            "status"  => false,
            "message" => translate("Instagram reels doesnot support uploading images")
        ];

    
   }


   public function postStory(SocialPost $post,mixed $ig) :array{

            $account           = $post->account;
            $token             = $account->account_information->token;
            $upload_endpoint   = "/".$account->account_id."/media";
            $endpoint          = "/".$account->account_id."/media_publish";
            $file              = $post->file->first();
            $fileURL           = imageURL($file,"post",true);

            if(isValidVideoUrl($fileURL)){

                $upload_params = [
                    'media_type' => "STORIES",
                    'video_url'  =>  $fileURL,
                    'caption'    =>  $post->content?? "feed",

                ];
                $upload_response = $ig->post( $upload_endpoint, $upload_params, $token)->getDecodedBody();
                $params = [
                    'creation_id' => $upload_response['id'],
                ];

                $response = $ig->post( $endpoint, $params, $token)->getDecodedBody();

                if(@$response['id']){
                    $mediaResponse = $ig->get( "/". $response["id"]."?fields=shortcode", $token)->getDecodedBody();
                    $url           = "https://www.instagram.com/p/".@$mediaResponse['shortcode'];
                }

     
            }else{

                $upload_params = [
                    'media_type' => "STORIES",
                    'image_url'  => $fileURL,
                    'caption'    => $post->content?? "feed",
                ];

                $upload_response = $ig->post( $upload_endpoint, $upload_params, $token)->getDecodedBody();
   
                $params = [
                    'creation_id' => $upload_response['id'],
                ];

                $response = $ig->post( $endpoint, $params, $token)->getDecodedBody();
                if(@$response['id']){
                    $mediaResponse = $ig->get( "/". $response["id"]."?fields=shortcode", $token)->getDecodedBody();
                    $url           = "https://www.instagram.com/p/".@$mediaResponse['shortcode'];
                }



            }

            return [
                'url'        => @$url,
                'status'     => @$url ? true : false,
                'message'    => @$url ? translate('Posted successfully') : translate('Failed to post'),
            ];



    
   }
   public function unofficial(SocialPost $post) :array {

         $account           = $post->account;
         $username          = $account->account_information->username;
         $password          = $account->account_information->password;
         $message           = translate("Unknow error , invalid images");
         $status            = false;

         $igAuth = new AccountConfig($username , $password);
         $igAuth->login();

          try {
            $message           = translate("No images found!!");
            $link              = "";
            if($post->file && $post->file->count() > 0){
                $medias = [];

                foreach ($post->file as $file) {
                    $medias[] = imageURL($file,"post",true);
                }
                
                if(count($medias) < 2){
                    $response = $igAuth->uploadPhoto($post->account->account_id, $medias[0], $post->content??"feed");
                }
                else{
                    $response = $igAuth->generateAlbum($post->account->account_id, $medias,$post->content??"feed", 0);
                }

                $message           = Arr::get($response,"message",'Unknown error');

                if(isset($response["status"]) && $response["status"] == "ok"){
                    $message     = translate("Posted Successfully");
                    $status      = true;
                    $url  = "https://www.instagram.com/p/".$response['code'];
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
