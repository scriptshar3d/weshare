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

Route::group(['as' => 'api.', 'namespace' => 'Api'], function () {

    // Backend Api
    Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {

        // auth related
        Route::namespace('Auth')->group(function () {
            Route::post('/login', 'LoginController@authenticate');
        });

        Route::middleware('auth:api')->group(function () {

            // user
            Route::apiResource('users', 'UserController')->except(['create', 'destroy']);
            
            // user profile            
            Route::post('/profiles/notifications/{userprofile}', 'UserProfileController@sendPushNotification');
            Route::post('/profiles/notifications', 'UserProfileController@sendPushNotificationToAll');            
            Route::get('/profiles/reported-users', 'UserProfileController@reportedUsers');
            Route::get('/profiles/block/{profile}', 'UserProfileController@block');
            Route::apiResource('profiles', 'UserProfileController')->except('create');

            // category
            Route::apiResource('categories', 'CategoryController');

            // comment
            Route::apiResource('comments', 'CommentController')->except(['create', 'update']);

            // post
            Route::get('/profiles/reported-posts', 'UserProfileController@reportedPosts');
            Route::apiResource('posts', 'PostController')->except(['create', 'update']);

            // settings
            Route::get('/settings/env', 'SettingController@envList');
            Route::post('/settings/env', 'SettingController@updateEnv');

            // dashboard
            Route::get('/dashboard/post-type-summary', 'DashboardController@postTypeSummary');
            Route::get('/dashboard/post-analytics', 'DashboardController@postsAnalytics');
            Route::get('/dashboard/user-analytics', 'DashboardController@userAnalytics');
            Route::get('/dashboard/daily-active-analytics', 'DashboardController@dailyUserAnalytics');
            Route::get('/dashboard/gender-statistics', 'DashboardController@genderStatistics');
            // Route::get('/dashboard/progress-statistics', 'DashboardController@progressStatistics');
        });
    });

    Route::middleware('auth:firebase')->group(function () {
        Route::post('profile', 'UserProfileController@store')->name('profile.create');
        Route::get('profile/followers/{userProfile}', 'UserProfileController@followers')->name('profile.followers');
        Route::get('profile/following/{userProfile}', 'UserProfileController@following')->name('profile.following');
        Route::post('profile/search', 'UserProfileController@search')->name('profile.search');
        Route::post('profile/follow/{userProfile}', 'UserProfileController@follow')->name('profile.follow');

        // follow requests related APIs
        Route::get('profile/follow-requests', 'UserProfileController@followRequests')->name('profile.followRequests');
        Route::get('profile/follow-requests/follow/{userprofile}', 'UserProfileController@followRequest')->name('profile.followRequest');
        Route::post('profile/follow-requests/{followrequest}/review', 'UserProfileController@reviewFollowRequest')->name('profile.reviewFollowRequest');
	Route::get('profile/{userProfile}', 'UserProfileController@show')->name('profile.show');


        Route::post('/report/{reportUser}', 'UserProfileController@report')->name('profile.report');

        Route::get('categories', 'CategoryController@index')->name('category.index');

        Route::get('posts', 'PostController@index')->name('post.index');
        Route::post('posts', 'PostController@store')->name('post.create');
        Route::get('posts/me', 'PostController@myposts')->name('post.myposts');
        Route::get('posts/{post}/show', 'PostController@show')->name('posts.show');
        Route::post('posts/{post}/like', 'PostController@like')->name('post.like');
        Route::post('posts/{post}/dislike', 'PostController@dislike')->name('post.dislike');
        Route::post('posts/{post}/share', 'PostController@share')->name('post.share');
        Route::get('posts/{post}/report', 'PostController@report')->name('post.report');
        Route::get('stories/users', 'PostController@storyUsers')->name('post.stories.users');
        Route::get('stories/users/{userProfile}', 'PostController@stories')->name('post.stories');

        Route::get('posts/{post}/comments', 'CommentController@index')->name('comment.index');
        Route::post('posts/{post}/comments', 'CommentController@store')->name('comment.create');
        Route::post('comments/{comment}/like', 'CommentController@like')->name('comment.like');
        Route::post('comments/{comment}/dislike', 'CommentController@dislike')->name('comment.dislike');

        Route::get('activities', 'PostActivityController@index')->name('activities.index');        
    });
});
