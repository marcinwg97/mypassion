<?php

use App\Http\Controllers\PostController;
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

//Auth
Route::post('login', 'Api\Auth\LoginController@login');
Route::post('register', 'Api\Auth\RegisterController@register');
Route::get('logout', 'Api\Auth\LogoutController@logout');

//Api/Posts
Route::middleware('auth:api')->group(function () {
Route::get('admin/posts', 'Api\Dashboard\PostController@index');
Route::get('admin/post/{id}', 'Api\Dashboard\PostController@edit');
Route::post('admin/post/{id}', 'Api\Dashboard\PostController@update');
Route::post('admin/posts', 'Api\Dashboard\PostController@store');
Route::post('admin/post/delete/{id}', 'Api\Dashboard\PostController@destroy');

//Api/Categories
Route::get('admin/categories', 'Api\Dashboard\CategoryController@index');
Route::get('admin/category/{id}', 'Api\Dashboard\CategoryController@edit');
Route::post('admin/category/{id}', 'Api\Dashboard\CategoryController@update');
Route::post('admin/categories', 'Api\Dashboard\CategoryController@store');
Route::post('admin/category/delete/{id}', 'Api\Dashboard\CategoryController@destroy');

//Api/StaticSites
Route::get('admin/static-sites', 'Api\Dashboard\StaticSiteController@index');
Route::get('admin/static-site/{id}', 'Api\Dashboard\StaticSiteController@edit');
Route::post('admin/static-site/{id}', 'Api\Dashboard\StaticSiteController@update');
Route::post('admin/static-sites', 'Api\Dashboard\StaticSiteController@store');
Route::post('admin/static-site/delete/{id}', 'Api\Dashboard\StaticSiteController@destroy');

//Api/Users
Route::get('admin/users', 'Api\Dashboard\UserController@index');
Route::get('admin/user/{id}', 'Api\Dashboard\UserController@edit');
Route::post('admin/user/{id}', 'Api\Dashboard\UserController@update');
Route::post('admin/users', 'Api\Dashboard\UserController@store');
Route::post('admin/user/delete/{id}', 'Api\Dashboard\UserController@destroy');

Route::post('event-add-user', 'Api\EventController@addUserToEvent');
Route::get('event/user/{id}', 'Api\EventController@VerifyUserInEvent');
Route::post('event-remove-user', 'Api\EventController@removeUserFromEvent');
});

//Api/Messages
Route::get('admin/messages', 'Api\Dashboard\FormContactController@index');
Route::post('admin/message/delete/{id}', 'Api\Dashboard\FormContactController@destroy');

//Posts
Route::get('posts/category/{id}', 'Api\PostController@index');
Route::get('post', 'Api\PostController@details');

//Categories
Route::get('categories', 'Api\CategoryController@index');
Route::get('category/{id}', 'Api\CategoryController@details');

//Events 
Route::get('events/category/{id}', 'Api\EventController@index');
Route::get('event', 'Api\EventController@details');

//StaticSites
Route::get('static-sites', 'Api\StaticSiteController@index');
Route::get('static-site/{id}', 'Api\StaticSiteController@details');
Route::get('mission', 'Api\StaticSiteController@mission');
Route::get('about-us', 'Api\StaticSiteController@aboutUs');

//Messages
Route::post('messages', 'Api\FormContactController@store');

Route::get('category/{id}/{name}', 'Api\CategoryController@details');

Route::get('/user/{id}', 'Api\UserController@details');
Route::get('/user/posts/{id}', 'Api\UserController@postsByUser');

//Search
Route::get('search', 'Api\PostController@search');
Route::get('search-hints', 'Api\PostController@searchDynamic');
