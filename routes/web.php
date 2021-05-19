<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');

Route::get('/category/{category}/{product_id}', 'App\Http\Controllers\ProductController@getProduct')->name('showProduct');

Route::get('/category/{category}', 'App\Http\Controllers\ProductController@showCategory')->name('showCategory');

Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cartIndex');

Route::post('/add-to-cart', 'App\Http\Controllers\CartController@addToCart')->name('addToCart');