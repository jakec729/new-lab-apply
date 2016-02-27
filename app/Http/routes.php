<?php

use App\Application;
Route::group(['middleware' => 'web'], function () {
    
    Route::get('/', function () { 
        return redirect('/home');
    });
    
    Route::auth();
    Route::get('/home', 'HomeController@index');
    Route::get('/users', 'UserController@index');
    Route::get('/roles', 'RoleController@index');

Route::get('/files/import', 'FileController@import');
    Route::post('/files/review', 'FileController@review');
    Route::post('/files', 'FileController@store');

    Route::post('/movies/{id}/comments/create', 'MovieController@addComment');
    Route::post('/movies/form', 'MovieController@indexForm');
    Route::get('/movies/assign', 'MovieController@assignMoviesToUsers');
    Route::resource('movies', 'MovieController');

    Route::get('/applications', 'ApplicationController@index');
    Route::get('/applications/download', 'ApplicationController@downloadCSV');
    Route::get('/applications/{applications}', 'ApplicationController@show');
    Route::post('/applications/{application}/rate', 'ApplicationController@rate');
});
