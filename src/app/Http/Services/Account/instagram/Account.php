<?php

namespace App\Http\Services\Account\instagram;

use App\Enums\ConnectionType;
use App\Traits\AccoutManager;
use App\Enums\AccountType;
use App\Models\MediaPlatform;
use App\Models\SocialAccount;
use App\Models\SocialPost;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
class Account
{
    

    use AccoutManager;

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
    
                $this->saveAccount($guard ,$platform , $accountInfo ,AccountType::Profile->value ,ConnectionType::UNOFFICIAL->value );
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

        if($account->is_official  == ConnectionType::OFFICIAL->value){
           $response =  $this->official($post);
        }
        else{
            $response =  $this->unofficial($post);
        }
        return $response;
   
   }


   public function official(SocialPost $post) :array{

        try {

            $account           = $post->account;
            $platform          = @$post->account->platform->configuration;
            $accountConnection = $this->accountDetails($account);

            $isConnected       = Arr::get($accountConnection,'status', false);
            $message           = translate("Account is not connected");
            $status            = false;
            $token             = $account->account_information->token;

            if($isConnected && $post->file && $post->file->count() > 0){
                $message       = translate("Text and url not supported in insta feed");
                
                if($post->file && $post->file->count() > 0){
                    $message     = translate("Posted Successfully");
                    $status      = true;
                    $fb = new \JanuSoftware\Facebook\Facebook([
                        'app_id'                => $platform->client_id,
                        'app_secret'            => $platform->client_secret,
                        'default_graph_version' => $platform->app_version,
                    ]);

                    $upload_endpoint = "/".$account->account_id."/media";
                    $endpoint        = "/".$account->account_id."/media_publish";

            
                    $media_ids = [];

                    if($post->file->count() > 1){

                        foreach ($post->file as $file) {
                        
                            $upload_params = [
                                'image_url'        => imageUrl($file,"post",true),
                                'caption'          => $post->content??"feed",
                                'is_carousel_item' => true
                            ];
                            $upload_response = $fb->post( $upload_endpoint, $upload_params, $token)->getDecodedBody();
                            $media_ids[]     = $upload_response['id'];
                        }
        
                        $upload_params = [
                            'media_type' => 'CAROUSEL',
                            'children'   => $media_ids,
                            'caption'    => $post->content??"feed"
                        ];
                    
                        $upload_response = $fb->post( $upload_endpoint, $upload_params, $token)->getDecodedBody();
        
                        $params = [
                            'creation_id' => $upload_response['id']
                        ];
        
                        $response = $fb->post( $endpoint, $params, $token)->getDecodedBody();
                        $media_response = $fb->get( "/". $response["id"]."?fields=shortcode",$token)->getDecodedBody();
            
                        $url  = "https://www.instagram.com/p/".$media_response['shortcode'];

                    }
                    else{

                        $file = $post->file->first();
           
                        $upload_params = [
                            'image_url' => imageUrl($file,"post",true),
                            'caption'   => $post->content??"feed"
                        ];
                        $upload_response = $fb->post( $upload_endpoint, $upload_params, $token)->getDecodedBody();

                        $params = [
                            'creation_id' => $upload_response['id'],
                        ];

                        $response = $fb->post( $endpoint, $params, $token)->getDecodedBody();
                        $media_response = $fb->get( "/". $response["id"]."?fields=shortcode", $token)->getDecodedBody();
                        
                        $url  = "https://www.instagram.com/p/".$media_response['shortcode'];


                    }
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
                    $medias[] = imageUrl($file,"post",true);
                }
                
                if(count($medias) < 2){
                    $response = $igAuth->uploadPhoto($post->account->account_id, $medias[0], $post->content??"feed",);
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
