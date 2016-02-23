<?php


// AUTH ROUTES
// =============================

Route::group(['middleware' => 'web'], function () {
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

// BASIC ROUTES
// ====================================================

Route::group(['middleware' => 'web'], function () {
    
    Route::get('/home', 'HomeController@index');
    Route::get('/', function () { 
        return (Auth::check()) ? redirect('/home') : view('welcome');
    });

});

// ADMIN ROUTES
// ====================================================

Route::group(['middleware' => 'web'], function () {
    
    Route::get('/users', 'UserController@index');
    Route::get('/roles', 'RoleController@index');
    Route::resource('files', 'FileController');
    Route::resource('movies', 'MovieController');
});
