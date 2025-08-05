<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// user Routes
Route::post('signup','UserController@signup');
Route::post('login','UserController@login');
Route::get('login','UserController@login')->name('login');
Route::get('logout','UserController@logout');


Route::middleware('auth:api')->group(function(){

	Route::get('/categories', 'CategoriesController@categories');
	Route::get('/users', 'UserController@userdetails');
	Route::post('/user-status', 'UserController@userstatus');
	
	Route::post('/add-challange', 'ChallangeController@addchallange');
	Route::post('search-challange' , 'ChallangeController@searchchallange');
	Route::delete('/delete-challange/{challange}' , 'ChallangeController@deletechallange');
	Route::put('/update-challange/{challange}' , 'ChallangeController@updatechallange');
	Route::get('my-challanges/{challange}' , 'ChallangeController@mychallanges');
	Route::get('challanges' , 'ChallangeController@allchallanges');
	Route::get('get-challange/{challange}' , 'ChallangeController@getchallange');
	Route::post('add-challange-comment' , 'ChallangeController@addchallangecomment');
	Route::post('challange-like' , 'ChallangeController@challangelike');
	Route::post('challange-comment-reply' , 'ChallangeController@addchallangereply');

	Route::post('add-mileston' , 'MilestonController@addmileston');
	Route::get('delete-mileston/{mileston}' , 'MilestonController@deletemileston');
	Route::put('update-mileston/{mileston}' , 'MilestonController@updatemileston');
	Route::post('add-mileston-comment' , 'MilestonController@addmilestoncomment');
	Route::post('mileston-like' , 'MilestonController@milestonlike');
	Route::post('mileston-comment-reply' , 'MilestonController@addmilestonreply');

	Route::post('conversation' , 'ChatController@conversation');
	Route::get('all-conversations' , 'ChatController@allconversations');
	Route::post('delete-conversation' , 'ChatController@deleteconversation');
	Route::post('send-message' , 'ChatController@sendmessage');
	Route::get('get-messages' , 'ChatController@getmessages');
	Route::post('delete-message' , 'ChatController@deletemessage');
	Route::get('search-person/{person}' , 'ChatController@searchperson');

	Route::post('notifications' , 'NotifyController@notifications');
	
});
