<?php

namespace App\Http\Services\Account\linkedin;

use App\Traits\AccoutManager;

use App\Models\SocialPost;
use Illuminate\Support\Facades\Http;


use GuzzleHttp\Client;
 
class Account
{
    

    use AccoutManager;





    public function send(SocialPost $post) :array{

        $status      = true;
         try {
            $account           = $post->account;
            $token             = $account->account_information->token;
            $client_id   = $account->platform->configuration->client_id;
            $message     = translate("Posted Successfully");

            $linkedin_id = $account->account_id;
            $body = new \stdClass();
            $body->content = new \stdClass();
            $body->content->contentEntities = [];

            $body->content->contentEntities[0] = new \stdClass();
            $body->content->contentEntities[0]->entityLocation = [$post->link ?? ''];

            $body->text = new \stdClass();
            $body->text->text = $post->content ?? '';


            if($post->file && $post->file->count() > 0){
                
                foreach ($post->file as $file) {
                    $contentEntity = new \stdClass();
                    $contentEntity->thumbnails[0] = new \stdClass();
                    $url =
                    $contentEntity->thumbnails[0]->resolvedUrl = imageUrl($file,"post",true); 
                    $imageResponse = $this->uploadImage(imageUrl($file,"post",true),$token,$client_id );
                    $contentEntity->entity = 'urn:li:digitalmediaAsset:' . $imageResponse['id'];
                    $body->content->contentEntities[] = $contentEntity;
                }
            }
          

            $body->content->title = 'Feed';
            $body->owner = 'urn:li:person:' . $linkedin_id;

            $body_json = json_encode($body);

            $client = new Client(['base_uri' => 'https://api.linkedin.com']);
            $response = $client->request('POST', '/v2/shares', [
                'headers' => [
                    "Authorization" => "Bearer " . $token,
                    "Content-Type" => "application/json",
                    "x-li-format" => "json",
                ],
                'body' => $body_json,
            ]);
            
            if (!$response->getStatusCode() == 201) {
                $status      = true;
                $message     = translate("Invalid Account");
            } 
            
            
         } catch (\Exception $ex) {
            $status  = false;
            $message = strip_tags($ex->getMessage());
         }

         return [
            'status'   => $status,
            'response' => $message,
            'url'      => @$url
        ];

    }


    private function uploadImage(string $imagePath ,string $token , int | string $clinetId)
    {
        $url = 'https://api.linkedin.com/v2/assets?action=registerUpload';
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        // Step 1: Register the image upload
        $response = Http::post($url, [
            'registerUploadRequest' => [
                'recipes' => ['urn:li:digitalmediaRecipe:feedshare-image'],
                'owner' => 'urn:li:person:' . $clinetId,
            ],
        ], $headers);

        $uploadUrl = $response['value']['uploadMechanism']['com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest']['uploadUrl'];

        // Step 2: Upload the image
        $imageResponse = Http::put($uploadUrl, [
            'Content-Type' => 'application/octet-stream',
            'Authorization' => 'Bearer ' . $token ,
        ], file_get_contents($imagePath));

        return $imageResponse;
    }


}
