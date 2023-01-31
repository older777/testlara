<?php
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */
Route::pattern('id', '[0-9]{1,2}');
Route::get('/{id?}', [
    'as' => 'mainpage.id',
    'uses' => 'App\Http\Controllers\MainPageController@mainPage'
]);
Route::get('/second', [
    'as' => 'secondpage',
    'uses' => 'App\Http\Controllers\MainPageController@secondPage'
]);
Route::get('/product/{page?}', [
    'as' => 'productpage',
    'uses' => 'App\Http\Controllers\MainPageController@productPage'
])->where('page', '[^(add|delete)]');
Route::get('/product/add', [
    'as' => 'productpage.add',
    'uses' => 'App\Http\Controllers\MainPageController@productAdd'
]);
Route::get('/product/delete/{id}', [
    'as' => 'productpage.del',
    'uses' => 'App\Http\Controllers\MainPageController@productDelete'
]);

Route::get('/currex', ['as' => 'currex.alias', 'uses' => 'App\Http\Controllers\CurrExController@page']);
