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
    Route::get('/' , ['as' =>'home', 'uses' => 'HomeController@index']);

    Route::get('register/verify/{confirmation_code}', [
        'as' => 'user.active',
        'uses' => 'Auth\AuthController@confirm'
    ]);

    Route::get('language/{lang}', ['as' => 'lang', 'uses' => 'HomeController@chooseLanguage']);

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

    Route::group(['middleware' => 'isAdmin'], function () {
       

        Route::get('admin/{id}/profile', [
            'as' => 'admin.profile',
            'uses' => 'AdminController@profile'
        ]);

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

            Route::post('assignTrainee', [
                'as' => 'assignTrainee',
                'uses' => 'CourseController@assignTrainee'
            ]);

            Route::get('contact', [
                'as' => 'contact',
                'uses' => 'HomeController@contact',
            ]);

            Route::get('/dashboard', [
                'as' => 'dashboard',
                'uses' => 'HomeController@index'
            ]);

            Route::post('/getActivities', [
                'as' => 'getActivities',
                'uses' => 'HomeController@getActivities'
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

         Route::resource('admin', 'AdminController');
    });

    Route::group(['middleware' => 'isUser'], function () {
        Route::resource('users', 'UserController');
        Route::resource('user.subject', 'UserController', ['only' => ['index', 'show']]);
        Route::post('user/finishSubject', [
            'as' => 'finishSubject',
            'uses' => 'UserController@finishSubject'
        ]);

        Route::group(['namespace' => 'User'], function () {
            Route::resource('users.tasks', 'TaskController');

            Route::get('users/{id}/report', [
                'as' => 'report',
                'uses' => 'TaskController@showReport'
            ]);

            Route::get('users/{id}/finish/{task_id}/{subject_id}/{user_course_id}/{status}', [
                'as' => 'tasks/finish',
                'uses' => 'TaskController@finishTask'
            ]);
        });
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('home', [
            'as' => 'home',
            'uses' => 'HomeController@index'
        ]);
    });
});
