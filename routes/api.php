<?php

use Illuminate\Http\Request;

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

Route::group(['as' => 'api.', 'namespace' => 'Api', 'middleware' => 'auth:firebase'], function () {
    Route::post('profile', 'UserProfileController@store')->name('profile.create');
    Route::get('profile', 'UserProfileController@show')->name('profile.show');

    Route::get('posts', 'PostController@index')->name('post.index');
    Route::post('posts', 'PostController@store')->name('post.create');
    Route::get('posts/me', 'PostController@myposts')->name('post.myposts');
    Route::get('posts/{post}/show', 'PostController@show')->name('posts.show');
    Route::post('posts/{post}/like', 'PostController@like')->name('post.like');
    Route::post('posts/{post}/dislike', 'PostController@dislike')->name('post.dislike');
    Route::post('posts/{post}/share', 'PostController@share')->name('post.share');

    Route::get('posts/{post}/comments', 'CommentController@index')->name('comment.index');
    Route::post('posts/{post}/comments', 'CommentController@store')->name('comment.create');
    Route::post('comments/{comment}/like', 'CommentController@like')->name('comment.like');
    Route::post('comments/{comment}/dislike', 'CommentController@dislike')->name('comment.dislike');

    Route::get('activities', 'UserProfileController@activities')->name('activities.index');
});
