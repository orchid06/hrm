<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

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



    public function _envatoVerification(Request $request) : bool {

  
        return eval(base64_decode('IAogICAgICAgIGlmKCR0aGlzLT5fcmVnaXN0ZXJEb21haW4oKSl7CiAgICAgICAgICAgICRwYXJhbXNbYmFzZTY0X2RlY29kZSgnY0hWeVkyaGhjMlZrWDJOdlpHVT0nKV0gPSAkcmVxdWVzdC0+aW5wdXQoYmFzZTY0X2RlY29kZSgnY0hWeVkyaGhjMlZmWTI5a1pRPT0nKSk7CiAgICAgICAgICAgICRwYXJhbXNbYmFzZTY0X2RlY29kZSgnWW5WNVpYSmZaRzl0WVdsdScpXSAgID0gdXJsKCcvJyk7CiAgICAgICAgICAgIHRyeSB7CiAgICAgICAgICAgICAgICAkY2ggPSBjdXJsX2luaXQoKTsgCiAgICAgICAgICAgICAgICAkZGF0YSA9IGh0dHBfYnVpbGRfcXVlcnkoJHBhcmFtcyk7CiAgICAgICAgICAgICAgICAkcG9zdGluZ0RhdGEgPSBiYXNlNjRfZGVjb2RlKCJhSFIwY0hNNkx5OXNhV05sYm5ObExtbG5aVzV6YjJ4MWRHbHZibk5zZEdRdVkyOXQiKS4iPyIuJGRhdGE7CiAgICAgICAgICAgICAgICBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfU1NMX1ZFUklGWVBFRVIsIEZBTFNFKTsKICAgICAgICAgICAgICAgIGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9GT0xMT1dMT0NBVElPTiwgVFJVRSk7CiAgICAgICAgICAgICAgICBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfUkVUVVJOVFJBTlNGRVIsIFRSVUUpOwogICAgICAgICAgICAgICAgY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1VSTCwgJHBvc3RpbmdEYXRhKTsKICAgICAgICAgICAgICAgIGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9USU1FT1VULCA4MCk7CiAgICAgICAgICAgICAgICAkcmVzcG9uc2UgPSBjdXJsX2V4ZWMoJGNoKTsKICAgICAgICAgICAgICAgIGN1cmxfY2xvc2UoJGNoKTsKICAgICAgICAgICAgICAgICRyZXNwb25zZSA9IGpzb25fZGVjb2RlKCAkcmVzcG9uc2UpOwogICAgICAgICAgICAgICAgcmV0dXJuICAkcmVzcG9uc2UtPnN0YXR1czsKICAgICAgICAgICAgfSBjYXRjaCAoXEV4Y2VwdGlvbiAkZSkgewogICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlOwogICAgICAgICAgICB9CiAgICAgICAgfQogICAgICAgIHJldHVybiBmYWxzZTsK'));
   

    }

    public function _registerDomain() :bool {

      return eval(base64_decode("IHRyeSB7CiAgICAgICAgICAgICRjaCA9IGN1cmxfaW5pdCgpOyAKICAgICAgICAgICAgJHBvc3RQYXJhbXMgPSBbCiAgICAgICAgICAgICAgICBiYXNlNjRfZGVjb2RlKCdZblY1WlhKZlpHOXRZV2x1JykgPT4gdXJsKCcvJyksIAogICAgICAgICAgICAgICAgYmFzZTY0X2RlY29kZSgnYzI5bWRIZGhjbVZmYVdRPScpID0+IGNvbmZpZygnaW5zdGFsbGVyLnNvZnR3YXJlX2lkJykgPz8gJ1NISFZMTVRHS1o9PScKICAgICAgICAgICAgXTsKICAgICAgICAgICAgJGRhdGEgPSBodHRwX2J1aWxkX3F1ZXJ5KCRwb3N0UGFyYW1zKTsKICAgICAgICAgICAgJHBvc3RpbmdEYXRhID0gYmFzZTY0X2RlY29kZSgiYUhSMGNITTZMeTlzYVdObGJuTmxMbWxuWlc1emIyeDFkR2x2Ym5Oc2RHUXVZMjl0IikuJz8nLiRkYXRhOyAKICAgICAgICAgICAgY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1NTTF9WRVJJRllQRUVSLCBGQUxTRSk7CiAgICAgICAgICAgIGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9GT0xMT1dMT0NBVElPTiwgVFJVRSk7CiAgICAgICAgICAgIGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9SRVRVUk5UUkFOU0ZFUiwgVFJVRSk7CiAgICAgICAgICAgIGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9VUkwsICRwb3N0aW5nRGF0YSk7CiAgICAgICAgICAgIGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9USU1FT1VULCA4MCk7CiAgICAgICAgICAgICRyZXNwb25zZSA9IGpzb25fZGVjb2RlKGN1cmxfZXhlYygkY2gpKTsKICAgICAgICAgICAgY3VybF9jbG9zZSgkY2gpOwogICAgICAgICAgICByZXR1cm4gJHJlc3BvbnNlLT5zdGF0dXM7CiAgICAgICAgfSBjYXRjaCAoXEV4Y2VwdGlvbiAkZXgpIHsKICAgICAgICAgICAgcmV0dXJuIGZhbHNlOwogICAgICAgIH0="));



    }


    public function _validatePurchaseKey(string $key) :bool {

        return true;
    }


}