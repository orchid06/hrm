<?php

namespace App\Http\Services\Account\instagram;

use App\Enums\ConnectionType;
use App\Traits\AccoutManager;
use App\Enums\AccountType;
use App\Models\MediaPlatform;
use App\Models\SocialAccount;
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
            $userId     = $account->account_id;
            $apiUrl =    $api."/".$userId."/media";
            $fields = 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp';

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

    

}
