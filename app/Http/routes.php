<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'web'], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('trainees', 'TraineeController');

        Route::resource('courses', 'CourseController');

        Route::post('courses/search', [
            'as' => 'search',
            'uses' => 'CourseController@search'
        ]);

        Route::post('courses/destroySelected', [
            'as' => 'destroySelected',
            'uses' => 'CourseController@destroySelected'
        ]);

        Route::get('course/exportExcel', [
            'as' => 'exportExcel',
            'uses' => 'CourseController@exportExcel'
        ]);

        Route::get('course/exportCSV', [
            'as' => 'exportCSV',
            'uses' => 'CourseController@exportCSV'
        ]);

        Route::group(['namespace' => 'Admin'], function () {
            Route::resource('subjects', 'SubjectController');

            Route::post('subjects/delete_multi', [
                'as' => 'subjects/delete_multi',
                'uses' => 'SubjectController@deleteMulti'
            ]);

            Route::resource('tasks', 'TaskController');

            Route::post('tasks/delete_multi', [
                'as' => 'tasks/delete_multi',
                'uses' => 'TaskController@deleteMulti'
            ]);
        });
    });

    Route::group(['prefix' => 'login'], function () {
        Route::get('social/{network}', [
            'as' => 'loginSocialNetwork',
            'uses' => 'SocialNetworkController@callback',
        ]);

        Route::get('{accountSocial}/redirect', [
            'as' => 'redirectSocialNetwork',
            'uses' => 'SocialNetworkController@redirect',
        ]);
    });
});
