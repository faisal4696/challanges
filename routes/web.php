<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/',function(){ return redirect()->route('adminpannel'); });

Route::get('/adminsignin','AdminController@signin')->name('admin.signin');
Route::post('/adminsignin','AdminController@adminsignin')->name('adminsignin');

Route::get('/adminpannel','AdminController@index')->middleware('admin')->name('adminpannel');

// Route::group(['middleware'=>['auth','admin']],function(){

// admin Routes
Route::get('categories' , 'AdminController@categories')->middleware('admin')->name('categories');
Route::post('addcategory', 'AdminController@addcategory')->middleware('admin')->name('addcategory');
Route::get('deletecategory/{category}', 'AdminController@deletecategory')->middleware('admin');
Route::post('updatecategory', 'AdminController@updatecategory')->middleware('admin')->name('updatecategory');
Route::get('allusers', 'AdminController@allusers')->middleware('admin')->name('allusers');
Route::get('deleteuser/{user}', 'AdminController@deleteuser')->middleware('admin');
Route::post('updateuser' , 'AdminController@updateuser')->middleware('admin')->name('updateuser');
Route::get('/logout' , 'AdminController@adminlogout')->middleware('admin')->name('admin.logout');

// challanges routes
Route::get('challanges' , 'AdminController@challanges')->middleware('admin')->name('challanges');
Route::get('delete-challange/{challange}' , 'AdminController@deletechallange')->middleware('admin')->name('delete-challange');
Route::post('update-challange' , 'AdminController@updatechallange')->middleware('admin')->name('update-challange');
Route::get('view-milestons/{challange}' , 'AdminController@viewmilestons')->middleware('admin')->name('view-milestons');
Route::post('update-mileston/{mileston}' , 'AdminController@updatemileston')->middleware('admin')->name('update-mileston');
Route::get('delete-mileston/{mileston}' , 'AdminController@deletemileston')->middleware('admin')->name('delete-mileston');

// });