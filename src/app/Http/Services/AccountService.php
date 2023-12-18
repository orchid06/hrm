<?php
namespace App\Http\Services;

use App\Traits\ModelAction;
use Illuminate\Support\Facades\Config;

class AccountService
{






    /**
     * Undocumented function
     *
     * @param string $medium
     * @param array $config
     * @return void
     */
    public function setOauthConfig(string $medium , array $config) :void{
        Config::set('services.'.$medium, $config);
    }



}
