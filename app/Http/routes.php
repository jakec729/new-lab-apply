<?php

use App\Application;
Route::group(['middleware' => 'web'], function () {
    
    Route::get('/', function () { 
        return redirect('/applications');
    });

    // Authentication Routes...
    Route::get('login', 'Auth\AuthController@showLoginForm');
    Route::post('login', 'Auth\AuthController@login');
    Route::get('logout', 'Auth\AuthController@logout');

    // Registration Routes...
    Route::get('register', 'Auth\AuthController@showRegistrationForm');
    Route::post('register', 'Auth\AuthController@registerFromAuth');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');
    
});

Route::group(['middleware' => ['web', 'auth']], function() { 
    Route::get('/home', 'HomeController@index');
    Route::get('/roles', 'RoleController@index');

    Route::get('/users', 'UserController@index');
    Route::get('/users/{id}', 'UserController@profile');
    Route::post('/users/{user}', 'UserController@update');
    Route::post('/users/{id}/updatePassword', 'UserController@changePassword');

    Route::get('/files/import', 'FileController@import');
    Route::post('/files/review', 'FileController@review');
    Route::post('/files', 'FileController@store');
    Route::post('/applications/download', 'FileController@downloadCSV');

    Route::get('/applications', 'ApplicationController@index');
    Route::post('/applications/updatePPG', 'ApplicationController@updatePPG');
    Route::get('/applications/shortlisted', 'ApplicationController@shortlisted');
    Route::post('/applications/assignReviewersToApps', 'ApplicationController@assignReviewersToApps');
    Route::get('/applications/{applications}', 'ApplicationController@show');
    Route::get('/applications/{applications}/edit', 'ApplicationController@edit');
    Route::post('/applications/{applications}/edit', 'ApplicationController@update');
    Route::post('/applications/{application}/reviewers', 'ApplicationController@assignReviewers');
    Route::post('/applications/{applications}/comments', 'ApplicationController@addComment');
    Route::post('/applications/{application}/rate', 'ApplicationController@rate');

    Route::post('/comments', 'CommentController@store');
});
