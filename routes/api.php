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


//Admin
Route::middleware('auth:api')->group(function () {

//Api/Posts
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



});

//UserProfile
Route::middleware('auth:api')->group(function () {

    //PostFavorite and UserFavorite
    Route::get('user/post-favorite', 'Api\User\PostController@getPostsFavorite');
    Route::get('user/user-favorite', 'Api\User\UserController@getUsersFavorite');

    //EventMember
    Route::get('user/event-member', 'Api\User\EventController@getEventWhereMember');
    Route::post('user/event-member/delete/{id}', 'Api\User\EventController@deleteEventWhereMember');

    //Posts

    Route::get('user/posts', 'Api\User\PostController@index');
    Route::get('user/post/{id}', 'Api\User\PostController@edit');
    Route::post('user/post/{id}', 'Api\User\PostController@update');
    Route::post('user/post/delete/{id}', 'Api\User\PostController@destroy');

    Route::get('user/events', 'Api\User\EventController@index');
    Route::get('user/event/{id}', 'Api\User\EventController@edit');
    Route::post('user/event/{id}', 'Api\User\EventController@update');
    Route::post('user/event/delete/{id}', 'Api\User\EventController@destroy');

    //User
    Route::get('user', 'Api\User\UserController@index');
    Route::post('user/avatar', 'Api\User\UserController@updateAvatar');
    Route::post('user', 'Api\User\UserController@update');

    //Events


});

//MainPage

Route::get('posts', 'Api\PostController@getPostOnMainPage')->middleware('auth:api');

//Posts
Route::get('posts/category/{id}', 'Api\PostController@index');
Route::get('post', 'Api\PostController@details');
Route::get('comments/{id}', 'Api\CommentController@index');

//Categories
Route::get('categories', 'Api\CategoryController@index');
Route::get('category/{id}', 'Api\CategoryController@details');
Route::get('category/{id}/{name}', 'Api\CategoryController@details');
Route::post('comment/store', 'Api\CommentController@store')->middleware('auth:api');

//Events
Route::get('events/category/{id}', 'Api\EventController@index');
Route::get('event', 'Api\EventController@details');
Route::post('event-add-user', 'Api\EventController@addUserToEvent')->middleware('auth:api');
Route::get('event/user/{id}', 'Api\EventController@VerifyUserInEvent')->middleware('auth:api');
Route::post('event-remove-user', 'Api\EventController@removeUserFromEvent')->middleware('auth:api');
Route::post('events', 'Api\EventController@addEvent')->middleware('auth:api');
Route::get('events', 'Api\EventController@events');

//FavoritePost

Route::post('favorite-add-post', 'Api\PostController@addPostToFavorite')->middleware('auth:api');
Route::get('favorite/post/{id}', 'Api\PostController@VerifyPostFavorite')->middleware('auth:api');
Route::post('favorite-remove-post', 'Api\PostController@removePostFromFavorite')->middleware('auth:api');

//FavoriteUser

Route::post('favorite-add-user', 'Api\UserController@addUserToFavorite')->middleware('auth:api');
Route::get('favorite/user/{id}', 'Api\UserController@VerifyUserFavorite')->middleware('auth:api');
Route::post('favorite-remove-user', 'Api\UserController@removeUserFromFavorite')->middleware('auth:api');


//Messages
Route::post('messages', 'Api\FormContactController@store');

//Users
Route::get('/user/{id}', 'Api\UserController@details');
Route::get('/user/posts/{id}', 'Api\UserController@postsByUser');

//StaticSites
Route::get('static-sites', 'Api\StaticSiteController@index');
Route::get('static-site/{id}', 'Api\StaticSiteController@details');
Route::get('mission', 'Api\StaticSiteController@mission');
Route::get('about-us', 'Api\StaticSiteController@aboutUs');

//Search
Route::get('search', 'Api\PostController@search');
Route::get('search-hints', 'Api\PostController@searchDynamic');
