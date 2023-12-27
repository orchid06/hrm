<?php

namespace App\Http\Services\Account\facebook;

use App\Traits\AccoutManager;
use App\Enums\AccountType;
use App\Enums\ConnectionType;
use App\Enums\StatusEnum;
use App\Models\MediaPlatform;
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
        $groupId      = Arr::get($request,'group_id', null);

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








   
}
