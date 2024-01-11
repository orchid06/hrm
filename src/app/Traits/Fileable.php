<?php

namespace App\Traits;

use App\Models\Core\File as CoreFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

trait Fileable
{


    public $storage = [
        "s3"      => "awsConfig",
        "ftp"     => "ftpConfig"
    ];

    /**
     * store a file & image
     *
     * @param  $file
     * @param string $location
     * @param string $size
     * @param string $removeFile
     * @param string $name
     * @return array
     */
    public  function storeFile(mixed $file , string $location , string $size = null , mixed $removeFile = null ,string $name = null ): array 
    {

        $name          = uniqid() . time() . '.' . $file->getClientOriginalExtension();
        $imagePath     = $location . '/' .$name ;
        $status        = true;
        $message       = translate("File Uploaded Successfully");
    
        if($removeFile){
            $this->unlink($location ,$removeFile) ;    
        }
      
        if(is_array($this->storage) && in_array(site_settings('storage'), array_keys($this->storage))){

            $this->{$this->storage[site_settings('storage')]}();
    
            \Storage::disk(site_settings('storage'))->putFileAs(
                $location ,
                $file,
                $name 
            );

        }
        else{

            if (!file_exists($location)) {
                mkdir($location, 0755, true);
            }

            if(substr($file->getMimeType(), 0, 5) == 'image') {

                $image = Image::make(file_get_contents($file));
                if (isset($size)) {
                    
                    list($width, $height) = explode('x', strtolower($size));
                    $image->resize($width, $height,function ($constraint) {
                        $constraint->aspectRatio();
                    });
                   
                }
                $image->save($imagePath);
            }
            else{
                $file->move($location,$name);
            }
        }

        return [
            'status'     => $status,
            'message'    => $message,
            'name'       => $name,
            'disk'       => site_settings('storage') ,
            "size"       => $this->formatSize( $file->getSize()),
            "extension"  => strtolower($file->getClientOriginalExtension())
        ];
   
    }


    function formatSize(string | int $bytes) :string {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        for ($i = 0; (int) $bytes >= 1024 && $i < 4; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }



    /**
     * Unlink File Or Image 
     *
     * @param string $location
     * @param mixed $file
     * @return void
     */
    public function unlink(string $location ,mixed $file = null) :void{


        try {

            if($file->disk ==  'local'){
                if (file_exists($location . '/' . @$file->name) && is_file($location . '/' . @$file->name)) {
                    @unlink($location . '/' . @$file->name);
                }
            }
            else{

                $this->{$this->storage[$file->disk]}();
                if(Storage::disk($file->disk)->exists($location . '/' . @$file->name)){
                    Storage::disk($file->disk)->delete($location . '/' . @$file->name);
                }
            }

            @$file->delete();
       

           
        } catch (\Throwable $th) {

        }
       


    }


    /**
     * aws configuration 
     *
     * @return void
     */
    public function awsConfig() :void{
        $aws_config = json_decode(site_settings('aws_s3'),true);
        config(
            [
                'filesystems.disks.s3.key' => $aws_config['s3_key'],
                'filesystems.disks.s3.secret' => $aws_config['s3_secret'],
                'filesystems.disks.s3.region' => $aws_config['s3_region'],
                'filesystems.disks.s3.bucket' => $aws_config['s3_bucket'],
                'filesystems.disks.s3.use_path_style_endpoint' => false,
            ]
        );
    }


    /**
     * ftp configuration 
     *
     * @return void
     */
    public function ftpConfig() :void{

        $ftp_config = json_decode(site_settings('ftp'),true);
        config(
            [
                'filesystems.disks.ftp.host' => $ftp_config['host'],
                'filesystems.disks.ftp.username' => $ftp_config['user_name'],
                'filesystems.disks.ftp.password' => $ftp_config['password'],
                'filesystems.disks.ftp.port' => (int) $ftp_config['port'],
                'filesystems.disks.ftp.root' => $ftp_config['root']
            ]
        );

    }


    function getConfigValue($path, $config) {
        $keys = explode(',', $path);
    
        $current = $config;
    
        foreach ($keys as $key) {
            if (isset($current[$key])) {
                $current = $current[$key];
            } else {
                return null;
            }
        }
    
        return $current;
    }
    



    /**
     * get image url
     *
     * @param File $image
     * @param string $path
     * @return string
     */
    public function getImageUrl(mixed  $file, string $path ,bool $size , ?string $foreceSize  = null ) :string
    {
        $config    = config("settings")['file_path'];
        $basepath  = $this->getConfigValue($path, $config);
        $image_url = asset('assets/images/default/default.jpg');

        if($size){
            $default = $foreceSize?? "100x100";
            $image_url = route('default.image',Arr::get($basepath,'size',$default));
        }

        try {

            if(isset($basepath['path'])){

                $image = $basepath['path']."/".@$file->name;
                if(@$file->disk == "local"){
                    if (file_exists($image) && is_file($image)) {
                        $image_url =  asset($image);
                    }
                }
                else{
                    $this->{$this->storage[@$file->disk]}();
                    if(Storage::disk(@$file->disk)->exists($image)){
                        $image_url = \Storage::disk(@$file->disk)->url($image);
                    }
                }
    
            }
         
        } catch (\Throwable $th) {
            
        }
        return  $image_url;          
    }
    

    /**
     * Check if file exists or not
     *
     * @param string $url
     * @return boolean
     */
    public static function  check_file(string $url) :bool
    {
        $headers = get_headers($url);
        return (bool) preg_match('/\bContent-Type:\s+(?:image|audio|video)/i', implode("\n", $headers));
    }



    /**
     * download a file
     *
     * @param string $location
     * @param mixed $file
     * @return mixed
     */
    public function downloadFile(string $location, mixed $file) :mixed
    {
        $filePath = $location . '/' . $file->name;
        $url = null;

        try {

            if(is_array($this->storage) && in_array($file->disk, array_keys($this->storage))){
                $this->{$this->storage[$file->disk]}();
                $headers = [
                    'Content-Disposition' => 'attachment; filename="'. $file->name .'"',
                ];

                $url =  Response::make(\Storage::disk($file->disk)->get($filePath),200, $headers);
            }

            else{
                $headers = [
                    'Content-Type' => File::mimeType($filePath),
                ];
                $url =  Response::download( $filePath,$file->name, $headers);
            }
        } catch (\Throwable $th) {

        }

        return $url;
    }


}