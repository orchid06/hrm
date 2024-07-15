<?php

namespace App\Http\Services\Account\facebook;

use App\Traits\AccountManager;
use App\Enums\AccountType;
use App\Enums\ConnectionType;
use App\Enums\PostStatus;
use App\Enums\StatusEnum;
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
                
                if ($post->content)     $params['message'] = $post->content;
                if ($post->link)    $params['link']    = $post->link;

                if($post->file && $post->file->count() > 0){

                    foreach ($post->file as $file) {

                        $uploadParams = [
                            'access_token'  => $token,
                            'url'           => imageURL($file,"post",true),
                            'published'     => false,
                        ];
        
                        $uploadResponse = Http::post($baseApi . $apiVersion . "/me/photos", $uploadParams);
                        $uploadData     = $uploadResponse->json();

                        if (isset($uploadData['id']))  $params['attached_media'][] = '{"media_fbid":"'.$uploadData['id'].'"}';
              
                    }
                }

                $response     = Http::post($params['api'], $params);
                $gwResponse   = $response->json();
                $postId       = Arr::get($gwResponse,'id',null);


                if(isset($gwResponse['error'])) {
                    $status  = false;
                    $message = $gwResponse['error']['message'];
                }
                $url =   $postId  ?  "https://fb.com/".$postId : null;

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
