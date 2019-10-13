<?php

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

Route::group([
    'prefix' => 'categories',
    'as' => 'categories.',
], function ($router) {
    Route::get('/', 'CategoryController@index')->name('index');
    Route::post('/', 'CategoryController@store')->name('store');
    Route::get('/{category}', 'CategoryController@show')->name('show');
    Route::patch('/{category}', 'CategoryController@update')->name('update');
    Route::delete('/{category}', 'CategoryController@destroy')->name('destroy');
});

Route::group([
    'prefix' => 'products',
    'as' => 'products.',
], function ($router) {
    Route::get('/', 'ProductController@index')->name('index');
});
