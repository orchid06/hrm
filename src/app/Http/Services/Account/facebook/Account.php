<?php

namespace App\Http\Services\Account\facebook;

use App\Traits\AccountManager;
use App\Enums\AccountType;
use App\Enums\ConnectionType;
use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Enums\StatusEnum;
use App\Models\Core\File;
use App\Models\MediaPlatform;
use App\Models\SocialAccount;
use App\Models\SocialPost;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;


class Account
{
    

    use AccountManager;

    /**
     * Connet facebook account
     *
     * @param MediaPlatform $platform
     * @param array $request
     * @param string $guard
     * @return array
     */
    public function facebook(MediaPlatform $platform ,  array $request , string $guard = 'admin') :array {

        $type        = Arr::get($request,'account_type');
        
        $accountId   = Arr::get($request,'account_id', null);
        $token       = Arr::get($request,'access_token');
        $baseApi     = $platform->configuration->graph_api_url;
        $apiVersion  = $platform->configuration->app_version;
        $api         = $baseApi."/".$apiVersion;
        $pageId      = Arr::get($request,'page_id', null);
        $groupId     = Arr::get($request,'group_id', null);
        $response    = response_status(translate('Account Created'));

    
        try {

            $fields = 'id,name,picture,link';

            switch ($type) {
                case AccountType::PROFILE->value:
                    $api =   $api."/me";
                    $fields = 'id,name,email,picture,link';
                    break;
                case AccountType::PAGE->value:
                    $api =   $api."/".$pageId;
                    break;

                case AccountType::GROUP->value:
                    $api =   $api."/".$groupId;
                    break;
            }
            
            $apiResponse = Http::get( $api, [
                'access_token' =>   $token,
                'fields'       =>   $fields
            ]);

            $apiResponse       = $apiResponse->json();

            if(isset($apiResponse['error'])) {
                return response_status($apiResponse['error']['message'],'error');
            }

            if(isset($apiResponse['picture']['data'])){
                $avatar = $apiResponse['picture']['data']['url'];
            }

            switch ($type) {
                case AccountType::PROFILE->value:
                    $identification = Arr::get($apiResponse,'email',null);
                    break;
                case AccountType::PAGE->value || AccountType::GROUP->value:
                    $identification = Arr::get($apiResponse,'id',null);
                    $fields = 'id,name,picture,link';
                    $link   = $platform->configuration->group_url."/".$identification;
                    break;

            }
            
            $accountInfo = [
                'id'         => Arr::get($apiResponse,'id',null) ,
                'account_id' => $identification ,
                'name'       => Arr::get($apiResponse,'name',null),
                'link'       => Arr::get($apiResponse,'link',@$link),
                'email'      => Arr::get($apiResponse,'email',null),
                'token'      => $token,
                'avatar'     => @$avatar ,
            ];


            $this->saveAccount($guard ,$platform , $accountInfo ,$type ,ConnectionType::OFFICIAL->value ,$accountId);


        } catch (\Exception $ex) {
            $response  =   response_status(strip_tags($ex->getMessage()),'error');
        }
        

        return  $response ;
        
    }



    public function accountDetails(SocialAccount $account) : array {

        try {
          
            $baseApi     = $account->platform->configuration->graph_api_url;
            $apiVersion  = $account->platform->configuration->app_version;
            $api         = $baseApi."/".$apiVersion;
            $token       = $account->account_information->token;
            $insightData = [];
            $fields = 'id,full_picture,type,message,permalink_url,link,privacy,created_time,reactions.summary(true),comments.summary(true),shares';
            switch ($account->account_type) {
                case AccountType::PROFILE->value:

                    $api =   $api."/me/feed";
                    break;
                case AccountType::PAGE->value:
                    $fields = 'status_type,message,full_picture,created_time,permalink_url';
                    $api    =  $api."/".$account->account_id."/feed";
                    break;

                case AccountType::GROUP->value:
                    $api =   $api."/".$account->account_id."/feed";
                break;
            }


            $apiResponse = Http::get( $api, [
                'access_token' =>   $token,
                'fields'       =>   $fields
            
            ]);

            $apiResponse       = $apiResponse->json();

            if($account->account_type == AccountType::PAGE->value) {
                $since = strtotime('-1 month');
                $until = strtotime('now');
                $insightApi = Http::get($baseApi."/".$apiVersion."/".$account->account_id."/insights/page_post_engagements", [
                                'access_token' =>   $token,
                                'since' => $since,
                                'until' => $until,
                            ]);

                $insightApiResponse       = $insightApi->json();

                $insightData              = Arr::get($insightApiResponse,'data', []);

            }


            if(isset($apiResponse['error'])) {

                $this->disConnectAccount($account);
                return [
                    'status'  => false,
                    'message' => $apiResponse['error']['message']
                ];
            }

            return( [
                'status'        => true,
                'response'      => $apiResponse,
                'page_insights' => $insightData,
            ]);


        } catch (\Exception $ex) {
         
           return [
               'status'  => false,
               'message' => strip_tags($ex->getMessage())
           ];
        }
    
    }




    /**
     * Summary of send
     * @param \App\Models\SocialPost $post
     * @return array
     */
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
                    case AccountType::PROFILE->value:
                        $api    =   $api."/me/feed";
                        break;
                    case AccountType::PAGE->value:
                        $api    =  $api."/".$account->account_id."/feed";
                        break;
    
                    case AccountType::GROUP->value:
                        $api =   $api."/".$account->account_id."/feed";
                    break;
                }
    
    
                $params = array(
                    'api'          => $api ,
                    'access_token' => $token,
                );
        

                #POST IN FEED
                if($post->post_type == PostType::FEED->value){

                    $gwResponse = $this->postFeed($post,$params,$token,$baseApi , $apiVersion);
                    if(isset($gwResponse['error'])) {
                        $status  = false;
                        $message = $gwResponse['error']['message'];
                    }

                    $postId       = Arr::get($gwResponse,'id');

                    $url =   $postId  ?  "https://fb.com/".$postId : null;

                }

                #POST IN REELS
                if($post->post_type == PostType::REELS->value){

                    $gwResponse = $this->postReels($post,$token,$baseApi , $apiVersion);

                    if(!$gwResponse['status']) {
                        $status  = false;
                        $message = @$gwResponse['message'];
                    }
        
                    $postId       = Arr::get($gwResponse,'post_id');

                    $url =   $postId  ?  "https://www.facebook.com/reel/".$postId : null;

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






    
    /**
     * Summary of postReels
     * @param \App\Models\SocialPost $post
     * @param array $params
     * @param string $token
     * @param string $baseApi
     * @param string|int|float $apiVersion
     * @return mixed
     */
    public function postReels(SocialPost $post ,string $token ,string $baseApi ,string|int|float $apiVersion) : array {


        $account           = $post->account;

        if($post->file && $post->file->count() > 0){


            foreach ($post->file as $file) {

                $fileURL = imageURL($file,"post",true);

            

                if(isValidVideoUrl($fileURL)){
                   

                    $sessionParams = [
                        "upload_phase" => "start",
                        "access_token" => $token
                    ];
                    $sessionResponse     = Http::post($baseApi.$apiVersion."/".$account->account_id."/video_reels", $sessionParams);
                    $sessionResponse     = $sessionResponse->json();


                    if(!isset($sessionResponse['video_id']) ){
                        return [
                            "status"  => false,
                            "message" => translate('Cannot create an upload session for uploading reels video to the Facebook page')
                        ];
                    }


                    $uploadResponse = Http::withHeaders([
                        'Authorization' => 'OAuth ' . $token,
                        'file_url'      => $fileURL
                    ])->post(@$sessionResponse['upload_url']);

                    $uploadResponse     = $uploadResponse->json();


                    if(isset($uploadResponse['success'])){

                        try {

                            $params = [
                                "video_id" => $sessionResponse['video_id'],
                                "upload_phase" => "finish",
                                "video_state" => "PUBLISHED",
                                "description" => $post->content,
                                "access_token" => $token
                            ];

                            $response     = Http::post($baseApi.$apiVersion."/".$account->account_id."/video_reels", $params);
                            @dd(    $response );
                            $response     = $sessionResponse->json();


                            if($response['success']){
                                return [
                                    "status" => true,
                                    "post_id" => $sessionResponse['video_id']
                                ];
                            }

                            return [
                                "status"  => false,
                                "message" => @$response['error']['message'] ?? translate("Unable to upload!! API error")
                            ];
                        

                    
                        } catch (\Exception $e) {
                            return [
                                "status" => false,
                                "message" => $e->getMessage(),
                            ];
                        }
                  
                    }

                    return [
                        "status"  => false,
                        "message" => @$uploadResponse['debug_info']['message'] ?? translate("Unable to upload!! API error")
                    ];

                   
                }
                
                return [
                    "status"  => false,
                    "message" => translate("Facebook reels doesnot support uploading images")
                ];

            }
        }

 
        return [
            "status"  => false,
            "message" => translate("No file found!! Facebook REELS doesnot support just upload links or texgt")
        ];



    }




    /**
     * Summary of postFeed
     * @param \App\Models\SocialPost $post
     * @param array $params
     * @param string $token
     * @param string $baseApi
     * @param string|int|float $apiVersion
     * @return mixed
     */
    public function postFeed(SocialPost $post ,array $params, string $token ,string $baseApi ,string|int|float $apiVersion){


        if ($post->content)     $params['message'] = $post->content;
        if ($post->link)    $params['link']    = $post->link;

        if($post->file && $post->file->count() > 0){
            foreach ($post->file as $file) {
                $response = $this->uploadMedia($file, $token ,  $baseApi , $apiVersion);
                if (isset($response['id']))  $params['attached_media'][] = '{"media_fbid":"'.$response['id'].'"}';
            }
        }

        $response     = Http::post($params['api'], $params);
        return $response->json();

    }

    /**
     * Summary of uploadMedia
     * @param \App\Models\Core\File $file
     * @param string $token
     * @param string $baseApi
     * @param string|int|float $apiVersion
     * @return mixed
     */
    public function uploadMedia(File $file , string $token,string $baseApi ,string|int|float $apiVersion): mixed {

        $fileURL = imageURL($file,"post",true);
        $apiString =  "/me/videos";
        $uploadParams = [
            'file_url' =>  $fileURL,
            'published' => false,
            'access_token'  => $token
        ];

        if(check_image($fileURL)){
            $apiString =  "/me/photos";
            $uploadParams = [
                'access_token'  => $token,
                'url'           => $fileURL,
                'published'     => false,
            ];
        }
       
        $uploadResponse = Http::post($baseApi . $apiVersion . $apiString, $uploadParams);
        return   $uploadResponse->json();

    }



}
