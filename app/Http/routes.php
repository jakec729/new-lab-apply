<?php

use App\Application;
Route::group(['middleware' => 'web'], function () {
    
    Route::get('/', function () { 
        return redirect('/applications');
    });
    
    Route::auth();
});

Route::group(['middleware' => ['web', 'auth']], function() { 
    Route::get('/home', 'HomeController@index');
    Route::get('/roles', 'RoleController@index');

    Route::get('/users', 'UserController@index');
    Route::get('/users/{id}', 'UserController@profile');
    Route::post('/users/{id}', 'UserController@changePassword');

    Route::get('/files/import', 'FileController@import');
    Route::post('/files/review', 'FileController@review');
    Route::post('/files', 'FileController@store');

    Route::get('/applications', 'ApplicationController@index');
    Route::get('/applications/download', 'ApplicationController@downloadCSV');
    Route::get('/applications/{applications}', 'ApplicationController@show');
    Route::post('/applications/{applications}/comments', 'ApplicationController@addComment');
    Route::post('/applications/{application}/rate', 'ApplicationController@rate');

    Route::post('/comments', 'CommentController@store');
});
