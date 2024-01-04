<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use ZipArchive;
use Illuminate\Support\Facades\Artisan;
class SystemUpdateController extends Controller
{
    public function init() :View {

        return view('admin.system_update',[
            "title" => translate("Update System")
        ]);
    }


    /**
     * update the system
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request) :RedirectResponse {

    
        ini_set('memory_limit', '-1');


        $request->validate([
            'updateFile' => ['required', 'mimes:zip'],
        ]);

        $response = response_status(translate('Your system is currently running the latest version.','error'));

        try {
            if ($request->hasFile('updateFile')) {

                $zip_file = $request->file('updateFile');
                $basePath = base_path('/storage/app/public/temp_update/');
                if(!file_exists($basePath)) {
                    mkdir($basePath, 0777);
                }
                $res = $zip_file->move($basePath, $zip_file->getClientOriginalName());
                
                $zip = new ZipArchive;
                $res = $zip->open($basePath . $zip_file->getClientOriginalName());
             
                if ($res === true) {
               
                    $zip->extractTo($basePath);
                    $zip->close();
                } else {
                    abort(500, translate('Error! Could not open File'));
                }
            
                $str = @file_get_contents($basePath . '/config.json', true);

                if ($str === false) {
                    abort(500, translate('Error! Currapted file'));
                }

                $json = json_decode($str, true);

                if (empty($json) || (@empty($json['version']))) {
                    abort(500, translate('Error! No Configuration file found'));
                } 
     
                $newVersion      = (float) Arr::get($json,'version',1.0);
                $currentVersion  = (double) site_settings(key : "app_version",default :1.0);

                
                $src             = storage_path('app/public/temp_update');
                $dst             = dirname(base_path());

                if($newVersion  > $currentVersion){
                    if($this->copyDirectory($src, $dst)){

                        $this->_runMigrations($json);
                        $this->_runSeeder($json);
                      
        
                        Setting::updateOrInsert(
                            ['key'    => "app_version"],
                            ['value'  => $newVersion]
                        );
                        Setting::updateOrInsert(
                            ['key'    => "system_installed_at"],
                            ['value'  => Carbon::now()]
                        );
                  

                       $response = response_status(translate('System updated successfully'));
    
                    }
                }
            }

            if (storage_path('app/public/temp_update')) {
                $this->deleteDirectory(storage_path('app/public/temp_update'));
            }


        } catch (\Exception $ex) {
            $response = response_status(strip_tags($ex->getMessage()),'errror');
        }


        return back()->with($response);
       

    }


    public function _runMigrations(array $json) :void{

        $migrations = Arr::get($json , 'seeder' ,[]);

        if(count($migrations) > 0){

                $result = Arr::where($migrations, function ($value, $key ,$currentVersion) {
                    return version_compare($key, (string)$currentVersion, '>');
                });

                $migrationFiles = (array) @array_unique(Arr::collapse($result));

                foreach ($migrationFiles as $migration) {
                    Artisan::call('migrate',
                        array(
                            '--path' => $migration,
                            '--force' => true));
                }
        }
    }

    public function _runSeeder(array $json) :void{

        $seeders = Arr::get($json , 'migrations' ,[]);

        if(count($seeders) > 0){
            $result = Arr::where($seeders, function ($value, $key ,$currentVersion) {
                return version_compare($key, (string)$currentVersion, '>');
            });

            $seederFiles = (array) @array_unique(Arr::collapse($result));

            foreach ($seederFiles as $seeder) {
                Artisan::call('db:seed',
                    array(
                        '--class' => $seeder,
                        '--force' => true));
            }
        }
    }

    

    /**
     * Copy directory
     *
     * @param string $src
     * @param string $dst
     * @return boolean
     */
    public function copyDirectory(string $src, string $dst) :bool {

        try {
            $dir = opendir($src);
            @mkdir($dst);
            while (false !== ($file = readdir($dir))) {
                if (($file != '.') && ($file != '..')) {
                    if (is_dir($src . '/' . $file)) {
                        $this->copyDirectory($src . '/' . $file, $dst . '/' . $file);
                    } else {
                        copy($src . '/' . $file, $dst . '/' . $file);
                    }
                }
            }
            closedir($dir);
        } catch (\Exception $e) {
           return false;
        }

        return true;
    }


    
    /**
     * delete directory
     *
     * @param string $dirname
     * @return boolean
     */
    public function deleteDirectory(string $dirname) :bool {

        try{
            if (!is_dir($dirname)){
                return false;
            }
            $dir_handle = opendir($dirname);

            if (!$dir_handle)
                return false;
            while ($file = readdir($dir_handle)) {
                if ($file != "." && $file != "..") {
                    if (!is_dir($dirname . "/" . $file))
                        unlink($dirname . "/" . $file);
                    else
                        $this->delete_directory($dirname . '/' . $file);
                }
            }
            closedir($dir_handle);
            rmdir($dirname);
            return true;
        }
        catch (\Exception $e) {
            return false;
        }
     }
    
}
