<?php

namespace App\Http\Services\Account\instagram;

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

class Account
{
    

    use AccoutManager;



    



     
    /**
     * Instagram account connecton
     *
     * @param MediaPlatform $platform
     * @param array $request
     * @param string $guard
     * @return array
     */
    public function instagram(MediaPlatform $platform ,  array $request , string $guard = 'admin') :array{

        $type        = Arr::get($request,'account_type');

        $username    = Arr::get($request,'username',null);
        $password    = Arr::get($request,'password',null);

		$cookies = true;

		
        $config = new AccountConfig($username , $password);

        $resposne = $config->login();


        @dd(  $resposne);
      
        // $response = $this->getCurrentUsergetCurrentUser()

        return [];


    }


    

}
