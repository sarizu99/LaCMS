<?php

Route::get('wizard', 'WizardController@index');

Route::post('wizard', 'WizardController@store');

Route::group(['middleware' => ['web_is_set']], function () {

    Route::get('/', 'PostController@homepage');
    
    Route::get('/factory-test', function () {
        return factory(App\Post::class, 10)->make();
    });
    
    Auth::routes();
    
    Route::get('/home', 'HomeController@index')->name('home');
    
    Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
        Route::get('/', 'AdminController@index');
        Route::resource('post', 'PostController');
    
        Route::group(['prefix' => 'category', 'middleware' => 'is_admin'], function () {
            Route::get('/', 'CategoryController@index');
            Route::post('/', 'CategoryController@store');
            Route::put('{id}', 'CategoryController@update');
            Route::delete('{id}', 'CategoryController@destroy');
        });
    
        Route::group(['prefix' => 'users', 'middleware' => 'is_admin'], function () {
            Route::get('/', 'UserController@index');
            Route::put('/{id}', 'UserController@update');
            Route::delete('/{id}', 'UserController@destroy');
    
            Route::get('create', 'UserController@create');
            Route::post('create', 'UserController@store');
        });
    
        Route::group(['prefix' => 'settings'], function () {
            Route::get('general', 'SettingsController@basicIndex')->middleware('is_admin');
            Route::put('general', 'SettingsController@updateBasic')->middleware('is_admin');
    
            Route::get('account', 'SettingsController@accountIndex');
            Route::put('account', 'AdminController@updateAccount');
        });
    
        Route::group(['prefix' => 'api/datatables'], function () {
            Route::post('posts', 'ApiController@posts');
        });
    
        Route::post('make-permalink', 'ApiController@makePermalink');
    });
    
    Route::get('/search', 'PostController@search');
    
    Route::get('/category/{category}', 'PostController@category');
    Route::get('/{slug}', 'PostController@show');
    
});