<?php

namespace App\Http\Services\Account\facebook;

use App\Traits\AccoutManager;
use App\Enums\AccountType;
use App\Enums\ConnectionType;
use App\Enums\StatusEnum;
use App\Models\MediaPlatform;
use App\Models\SocialAccount;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;


class Account
{
    

    use AccoutManager;

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
        $token       = Arr::get($request,'access_token');
        $baseApi     = $platform->configuration->graph_api_url;
        $apiVersion  = $platform->configuration->app_version;
        $api         = $baseApi."/".$apiVersion;
        $pageId      = Arr::get($request,'page_id', null);
        $groupId     = Arr::get($request,'group_id', null);
        $response   = response_status(translate('Account Created'));
    
        try {

            $fields = 'id,name,picture,link';

            switch ($type) {
                case AccountType::Profile->value:
                    $api =   $api."/me";
                    $fields = 'id,name,email,picture,link';
                    break;
                case AccountType::Page->value:
                    $api =   $api."/".$pageId;
                    break;

                case AccountType::Group->value:
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
                case AccountType::Profile->value:
                    $identification = Arr::get($apiResponse,'email',null);
                    break;
                case AccountType::Page->value || AccountType::Group->value:
                    $identification = Arr::get($apiResponse,'id',null);
                    $fields = 'id,name,picture,link';
                    $link   = $platform->configuration->group_url."/".$identification;
                    break;

            }
            
            $accountInfo = [
                'id'         => $identification ,
                'account_id' => Arr::get($apiResponse,'id',null),
                'name'       => Arr::get($apiResponse,'name',null),
                'link'       => Arr::get($apiResponse,'link',@$link),
                'email'      => Arr::get($apiResponse,'email',null),
                'token'      => $token,
                'avatar'     => @$avatar ,
            ];


            $this->saveAccount($guard ,$platform , $accountInfo ,$type ,ConnectionType::OFFICIAL->value );


        } catch (\Exception $ex) {
            $response  =   response_status(strip_tags($ex->getMessage()),'error');
        }
        

        return  $response ;
        
    }



    public function accoountDetails(SocialAccount $account) : array {


        try {
          
            $baseApi     = $account->platform->configuration->graph_api_url;
            $apiVersion  = $account->platform->configuration->app_version;
            $api         = $baseApi."/".$apiVersion;
            $token       = $account->account_information->token;
            $insightData = [];

            $fields = 'full_picture,type,caption,message,permalink_url,link,privacy,created_time';
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


            $apiResponse = Http::get( $api, [
                'access_token' =>   $token,
                'fields'       =>   $fields
            
            ]);

            $apiResponse       = $apiResponse->json();

            if($account->account_type == AccountType::Page->value) {
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

            return [
                'status'        => true,
                'response'      => $apiResponse,
                'page_insights' => $insightData,
            ];


        } catch (\Exception $ex) {
         
           return [
               'status'  => false,
               'message' => strip_tags($ex->getMessage())
           ];
        }
    


    }







   
}
