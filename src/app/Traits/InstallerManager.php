<?php

namespace App\Traits;

use App\Models\Core\Setting;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

trait InstallerManager
{
    private $_minPhpVersion = '8.1';

   

    public function is_installed() :bool{
        return false;
    }


    public function checkRequirements(array $requirements) :array{


        $results = [];

        foreach ($requirements as $type => $requirement) {
            switch ($type) {
    
                case 'php':
                    foreach ($requirements[$type] as $requirement) {
                        $results['requirements'][$type][$requirement] = true;

                        if (! extension_loaded($requirement)) {
                            $results['requirements'][$type][$requirement] = false;

                            $results['errors'] = true;
                        }
                    }
                    break;
                case 'apache':
                    foreach ($requirements[$type] as $requirement) {
                        if (function_exists('apache_get_modules')) {
                            $results['requirements'][$type][$requirement] = true;

                            if (! in_array($requirement, apache_get_modules())) {
                                $results['requirements'][$type][$requirement] = false;

                                $results['errors'] = true;
                            }
                        }
                    }
                    break;
            }
        }

        return $results;

    }



    
    /**
     * Get current Php version information.
     *
     * @return array
     */
    private static function getPhpVersionInfo()
    {
        $currentVersionFull = PHP_VERSION;
        preg_match("#^\d+(\.\d+)*#", $currentVersionFull, $filtered);
        $currentVersion = $filtered[0];

        return [
            'full' => $currentVersionFull,
            'version' => $currentVersion,
        ];
    }

    /**
     * Get minimum PHP version ID.
     *
     * @return string _minPhpVersion
     */
    protected function getMinPhpVersion()
    {
        return $this->_minPhpVersion;
    }



    /**
     * Check PHP version requirement.
     *
     * @return array
     */
    public function checkPHPversion(string $minPhpVersion = null) :array
    {
        $minVersionPhp = $minPhpVersion;
        $currentPhpVersion = $this->getPhpVersionInfo();
        $supported = false;

        if ($minPhpVersion == null) {
            $minVersionPhp = $this->getMinPhpVersion();
        }

        if (version_compare($currentPhpVersion['version'], $minVersionPhp) >= 0) {
            $supported = true;
        }

        $phpStatus = [
            'full' => $currentPhpVersion['full'],
            'current' => $currentPhpVersion['version'],
            'minimum' => $minVersionPhp,
            'supported' => $supported,
        ];

        return $phpStatus;
    }



    /** file permissions */


    public function permissionsCheck(array $folders) :array{

        foreach ($folders as $folder => $permission) {
            if (! ($this->getPermission($folder) >= $permission)) {
                $permissions [] =  $this->addFileAndSetErrors($folder, $permission, false);
            } else {
                $permissions [] =  $this->addFile($folder, $permission, true);
            }
        }

        return $permissions;


    }


    /**
     * Get a folder permission.
     *
     * @param $folder
     * @return string
     */
    private function getPermission($folder)
    {
        return substr(sprintf('%o', fileperms(base_path($folder))), -4);
    }


    /**
     * Add the file and set the errors.
     *
     * @param $folder
     * @param $permission
     * @param $isSet
     */
    private function addFileAndSetErrors($folder, $permission, $isSet) :array
    {
        return $this->addFile($folder, $permission, $isSet);
    }


    /**
     * Add the file to the list of results.
     *
     * @param $folder
     * @param $permission
     * @param $isSet
     */
    private function addFile($folder, $permission, $isSet) :array
    {
        return [
            'folder' => $folder,
            'permission' => $permission,
            'isSet' => $isSet,
        ];
     
    }



    public function _envatoVerification(Request $request) : mixed {


        return eval(base64_decode('IAogICAgICAgIGlmKCR0aGlzLT5fcmVnaXN0ZXJEb21haW4oKSl7CiAgICAgICAgICAgICRwYXJhbXNbYmFzZTY0X2RlY29kZSgnY0hWeVkyaGhjMlZrWDJOdlpHVT0nKV0gPSAkcmVxdWVzdC0+aW5wdXQoYmFzZTY0X2RlY29kZSgnY0hWeVkyaGhjMlZmWTI5a1pRPT0nKSk7CiAgICAgICAgICAgICRwYXJhbXNbYmFzZTY0X2RlY29kZSgnWW5WNVpYSmZaRzl0WVdsdScpXSAgID0gdXJsKCcvJyk7CiAgICAgICAgICAgIHRyeSB7CiAgICAgICAgICAgICAgICAkY2ggPSBjdXJsX2luaXQoKTsgCiAgICAgICAgICAgICAgICAkZGF0YSA9IGh0dHBfYnVpbGRfcXVlcnkoJHBhcmFtcyk7CiAgICAgICAgICAgICAgICAkcG9zdGluZ0RhdGEgPSBiYXNlNjRfZGVjb2RlKCJhSFIwY0hNNkx5OXNhV05sYm5ObExtbG5aVzV6YjJ4MWRHbHZibk5zZEdRdVkyOXQiKS4iPyIuJGRhdGE7CiAgICAgICAgICAgICAgICBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfU1NMX1ZFUklGWVBFRVIsIEZBTFNFKTsKICAgICAgICAgICAgICAgIGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9GT0xMT1dMT0NBVElPTiwgVFJVRSk7CiAgICAgICAgICAgICAgICBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfUkVUVVJOVFJBTlNGRVIsIFRSVUUpOwogICAgICAgICAgICAgICAgY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1VSTCwgJHBvc3RpbmdEYXRhKTsKICAgICAgICAgICAgICAgIGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9USU1FT1VULCA4MCk7CiAgICAgICAgICAgICAgICAkcmVzcG9uc2UgPSBjdXJsX2V4ZWMoJGNoKTsKICAgICAgICAgICAgICAgIGN1cmxfY2xvc2UoJGNoKTsKICAgICAgICAgICAgICAgICRyZXNwb25zZSA9IGpzb25fZGVjb2RlKCAkcmVzcG9uc2UpOwogICAgICAgICAgICAgICAgcmV0dXJuICAkcmVzcG9uc2UtPnN0YXR1czsKICAgICAgICAgICAgfSBjYXRjaCAoXEV4Y2VwdGlvbiAkZSkgewogICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlOwogICAgICAgICAgICB9CiAgICAgICAgfQogICAgICAgIHJldHVybiBmYWxzZTsK'));
   

    }

    public function _registerDomain() :mixed {

      return eval(base64_decode("IHRyeSB7CiAgICAgICAgICAgICRjaCA9IGN1cmxfaW5pdCgpOyAKICAgICAgICAgICAgJHBvc3RQYXJhbXMgPSBbCiAgICAgICAgICAgICAgICBiYXNlNjRfZGVjb2RlKCdZblY1WlhKZlpHOXRZV2x1JykgPT4gdXJsKCcvJyksIAogICAgICAgICAgICAgICAgYmFzZTY0X2RlY29kZSgnYzI5bWRIZGhjbVZmYVdRPScpID0+IGNvbmZpZygnaW5zdGFsbGVyLnNvZnR3YXJlX2lkJykgPz8gJ1NISFZMTVRHS1o9PScKICAgICAgICAgICAgXTsKICAgICAgICAgICAgJGRhdGEgPSBodHRwX2J1aWxkX3F1ZXJ5KCRwb3N0UGFyYW1zKTsKICAgICAgICAgICAgJHBvc3RpbmdEYXRhID0gYmFzZTY0X2RlY29kZSgiYUhSMGNITTZMeTlzYVdObGJuTmxMbWxuWlc1emIyeDFkR2x2Ym5Oc2RHUXVZMjl0IikuJz8nLiRkYXRhOyAKICAgICAgICAgICAgY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1NTTF9WRVJJRllQRUVSLCBGQUxTRSk7CiAgICAgICAgICAgIGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9GT0xMT1dMT0NBVElPTiwgVFJVRSk7CiAgICAgICAgICAgIGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9SRVRVUk5UUkFOU0ZFUiwgVFJVRSk7CiAgICAgICAgICAgIGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9VUkwsICRwb3N0aW5nRGF0YSk7CiAgICAgICAgICAgIGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9USU1FT1VULCA4MCk7CiAgICAgICAgICAgICRyZXNwb25zZSA9IGpzb25fZGVjb2RlKGN1cmxfZXhlYygkY2gpKTsKICAgICAgICAgICAgY3VybF9jbG9zZSgkY2gpOwogICAgICAgICAgICByZXR1cm4gJHJlc3BvbnNlLT5zdGF0dXM7CiAgICAgICAgfSBjYXRjaCAoXEV4Y2VwdGlvbiAkZXgpIHsKICAgICAgICAgICAgcmV0dXJuIGZhbHNlOwogICAgICAgIH0="));


    }


    public function _validatePurchaseKey(string $key) :mixed {

        return true;
    }

    public  function _chekcDbConnection(Request $request) :mixed {
        
        return eval(base64_decode("CiAgICAgICAgdHJ5IHsKICAgICAgICAgICAgaWYgKEBteXNxbGlfY29ubmVjdCgkcmVxdWVzdC0+aW5wdXQoJ2RiX2hvc3QnKSwgJHJlcXVlc3QtPmlucHV0KCdkYl91c2VybmFtZScpLCAgJHJlcXVlc3QtPmlucHV0KCdkYl9wYXNzd29yZCcpLCAkcmVxdWVzdC0+aW5wdXQoJ2RiX2RhdGFiYXNlJykgLCAkcmVxdWVzdC0+aW5wdXQoJ2RiX3BvcnQnKSkpIHsKICAgICAgICAgICAgICAgIHJldHVybiB0cnVlOwogICAgICAgICAgICB9CiAgICAgICAgICAgIHJldHVybiBmYWxzZTsKICAgICAgICB9Y2F0Y2goXEV4Y2VwdGlvbiAkZXhjZXB0aW9uKXsKICAgICAgICAgICAgcmV0dXJuIGZhbHNlOwogICAgICAgIH0="));

    }


    
    public  function _checkDb(Request $request) :mixed {

        return eval(base64_decode("CiAgICAgICAgdHJ5IHsKICAgICAgICAgICAgJHNlcnZlcm5hbWUgPSAkcmVxdWVzdC0+aW5wdXQoJ2RiX2hvc3QnKTsKICAgICAgICAgICAgJHVzZXJuYW1lICAgPSAkcmVxdWVzdC0+aW5wdXQoJ2RiX3VzZXJuYW1lJyk7CiAgICAgICAgICAgICRwYXNzd29yZCAgID0gJHJlcXVlc3QtPmlucHV0KCdkYl9wYXNzd29yZCcpOwogICAgICAgICAgICAkZGJuYW1lICAgICA9ICRyZXF1ZXN0LT5pbnB1dCgnZGJfZGF0YWJhc2UnKTsKICAgIAogICAgICAgICAgICAkY29ubiA9IG5ldyBcbXlzcWxpKCRzZXJ2ZXJuYW1lLCAkdXNlcm5hbWUsICRwYXNzd29yZCwgJGRibmFtZSk7CgogICAgICAgICAgICAkY29ubiAgID0gbmV3IFxteXNxbGkoJHNlcnZlcm5hbWUsICR1c2VybmFtZSwgJHBhc3N3b3JkLCAkZGJuYW1lKTsKICAgICAgICAgICAgJHJlc3VsdCA9ICRjb25uLT5xdWVyeSgiU0hPVyBUQUJMRVMiKTsKICAgICAgICAgICAgJGNvbm4tPmNsb3NlKCk7CiAgICAgICAgICAgIGlmICgkcmVzdWx0LT5udW1fcm93cyA+IDApIHsKICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTsKICAgICAgICAgICAgfSAKICAgICAgICAgICAgcmV0dXJuIHRydWU7CgogICAgICAgIH0gY2F0Y2ggKEV4Y2VwdGlvbiAkZSkgewogICAgICAgICAgIHJldHVybiBmYWxzZTsKICAgICAgICB9Cgo="));

      
    }
    public  function _envConfig(Request $request) :mixed {


        try {

   
            $key = base64_encode(random_bytes(32));
            $appName = config('installer.app_name');
            $output =
                'APP_NAME=' . $appName . PHP_EOL .
                'APP_ENV=live' . PHP_EOL .
                'APP_KEY=base64:' . $key . PHP_EOL .
                'APP_DEBUG=true' . PHP_EOL .
                'APP_INSTALL=true' . PHP_EOL .
                'APP_LOG_LEVEL=debug' . PHP_EOL .
                'APP_MODE=live' . PHP_EOL .
                'APP_URL=' . URL::to('/') . PHP_EOL .
            
                'DB_CONNECTION=mysql' . PHP_EOL .
                'DB_HOST=' . $request->input("db_host") . PHP_EOL .
                'DB_PORT=' . $request->input("db_port") . PHP_EOL .
                'DB_DATABASE=' . $request->input("db_database") . PHP_EOL .
                'DB_USERNAME=' . $request->input("db_username") . PHP_EOL .
                'DB_PASSWORD=' . $request->input("db_password") . PHP_EOL .
            
                'BROADCAST_DRIVER=log' . PHP_EOL .
                'CACHE_DRIVER=file' . PHP_EOL .
                'SESSION_DRIVER=file' . PHP_EOL .
                'SESSION_LIFETIME=120' . PHP_EOL .
                'QUEUE_DRIVER=sync' . PHP_EOL .
            
                'REDIS_HOST=127.0.0.1' . PHP_EOL .
                'REDIS_PASSWORD=null' . PHP_EOL .
                'REDIS_PORT=6379' . PHP_EOL .
            
                'PUSHER_APP_ID=' . PHP_EOL .
                'PUSHER_APP_KEY=' . PHP_EOL .
                'PUSHER_APP_SECRET=' . PHP_EOL .
                'PUSHER_APP_CLUSTER=mt1' . PHP_EOL .
            
                'PURCHASE_KEY=' . session()->get(base64_decode('cHVyY2hhc2VfY29kZQ==')) . PHP_EOL .
                'ENVATO_USERNAME=' . session()->get(base64_decode('dXNlcm5hbWU=')) . PHP_EOL;
            
            $file = fopen(base_path('.env'), 'w');
            fwrite($file, $output);
            fclose($file);
    
            $path = base_path('.env');
            if (file_exists($path)) {
                $this->_dbMigrate();
                return true;
            }
    
            return false;

        } catch (\Throwable $th) {
       
            return false;
        }
    


    }

    public function _dbMigrate() :void{
        ini_set('max_execution_time', 0);

        Artisan::call('migrate:fresh', ['--force' => true]);
    }
    public function _dbSeed() :void{
        ini_set('max_execution_time', 0);
        Artisan::call('db:seed', ['--force' => true]);
    }


    public function _systemInstalled() :void {

        $version = Arr::get(config("installer.core"),'appVersion',null);
        $data = [
            ['key' => "app_version", 'value' => $version],
            ['key' => "system_installed_at", 'value' => Carbon::now()],
            ['key' => "purchase_key", 'value' => config('app.purchase_key')],
            ['key' => "envato_username", 'value' => config('app.envato_username')],
        ];
        
        foreach ($data as $item) {
            Setting::updateOrInsert(['key' => $item['key']], $item);
        }

    }



}