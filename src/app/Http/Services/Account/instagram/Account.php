<?php

namespace App\Http\Services\Account\instagram;

use App\Enums\ConnectionType;
use App\Traits\AccoutManager;
use App\Enums\AccountType;
use App\Models\MediaPlatform;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\MultipartStream;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\RSA;
use JanuSoftware\Facebook\Authentication\AccessToken;
use JanuSoftware\Facebook\Facades\Facebook;
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

            @dd(    $resposne);
       
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


    

}
