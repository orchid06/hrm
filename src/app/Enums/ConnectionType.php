<?php

namespace App\Enums;

enum ConnectionType: int 
{
    use EnumTrait;

    case UNOFFICIAL              = 1;
    case ON_CLICK_CONNECT        = 0;



    // use Illuminate\Http\Request;
    // use Illuminate\Support\Facades\Http;
    
    // class FacebookController extends Controller
    // {
    //     public function saveProfile(Request $request)
    //     {
    //         // Validate and save profile to the database
    //         $profile = Profile::create($request->only(['profile_id', 'access_token']));
    //         return response()->json($profile);
    //     }
    
    //     public function savePage(Request $request)
    //     {
    //         // Validate and save page to the database
    //         $page = Page::create($request->only(['page_id', 'access_token']));
    //         return response()->json($page);
    //     }
    
    //     public function saveGroup(Request $request)
    //     {
    //         // Validate and save group to the database
    //         $group = Group::create($request->only(['group_id', 'access_token']));
    //         return response()->json($group);
    //     }
    
    //     public function postToProfile(Request $request)
    //     {
    //         $profileId = $request->input('profile_id');
    //         $message = $request->input('message');
    //         $link = $request->input('link');
    //         $pictures = $request->input('pictures');
    
    //         $profile = Profile::findOrFail($profileId);
    
    //         $postId = $this->scheduleProfilePost($profile->profile_id, $profile->access_token, compact('message', 'link', 'pictures'));
    
    //         return response()->json(['post_id' => $postId]);
    //     }
    
    //     public function postToPage(Request $request)
    //     {
    //         $pageId = $request->input('page_id');
    //         $message = $request->input('message');
    //         $link = $request->input('link');
    //         $pictures = $request->input('pictures');
    
    //         $page = Page::findOrFail($pageId);
    
    //         $postId = $this->schedulePagePost($page->page_id, $page->access_token, compact('message', 'link', 'pictures'));
    
    //         return response()->json(['post_id' => $postId]);
    //     }
    
    //     public function postToGroup(Request $request)
    //     {
    //         $groupId = $request->input('group_id');
    //         $message = $request->input('message');
    //         $link = $request->input('link');
    //         $pictures = $request->input('pictures');
    
    //         $group = Group::findOrFail($groupId);
    
    //         $postId = $this->scheduleGroupPost($group->group_id, $group->access_token, compact('message', 'link', 'pictures'));
    
    //         return response()->json(['post_id' => $postId]);
    //     }
    
    //     private function scheduleProfilePost($profileId, $profileAccessToken, $postData)
    //     {
    //         $postData['access_token'] = $profileAccessToken;
    //         $response = Http::post("https://graph.facebook.com/v10.0/$profileId/feed", $postData);
    
    //         return $response->json()['id'];
    //     }
    
    //     private function schedulePagePost($pageId, $pageAccessToken, $postData)
    //     {
    //         $postData['access_token'] = $pageAccessToken;
    //         $response = Http::post("https://graph.facebook.com/v10.0/$pageId/feed", $postData);
    
    //         return $response->json()['id'];
    //     }
    
    //     private function scheduleGroupPost($groupId, $groupAccessToken, $postData)
    //     {
    //         $postData['access_token'] = $groupAccessToken;
    //         $response = Http::post("https://graph.facebook.com/v10.0/$groupId/feed", $postData);
    
    //         return $response->json()['id'];
    //     }
    // }
    

}