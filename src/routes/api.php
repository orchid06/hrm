<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::get('/products',function(){
//     try {
//         $client = new Client();
//         $response = $client->get('https://dummyjson.com/products');

//         if ($response->getStatusCode() === 200) {
//             $data = json_decode($response->getBody());
//             return response()->json(['data' => $data], 200);
//         } else {
//             return response()->json(['message' => 'Failed to fetch data'], 500);
//         }
//     } catch (\Exception $e) {
//         return response()->json(['message' => $e->getMessage()], 500);
//     }
// });





