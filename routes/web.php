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

Route::get(
    '/',
    function () {
        Log::channel('single')->info('A user has arrived at the welcome page.');
        return view('welcome');
    }
);

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::resource('clients', 'Admin\ClientController')->middleware('verified');
Route::resource('books', 'Admin\BookController')->middleware('verified');
Route::get('/bookshelf', 'BookController@bookshelf')->middleware('verified')->name('bookshelf');
Route::get('/cart', 'ShoppingCartController@index')->middleware('verified')->name('cart.index');
Route::post('/cart/{book}', 'ShoppingCartController@update')->middleware('verified')->name('cart.update');
Route::get(
    '/uploads/{file}',
    function ($file) {
        return Storage::response("uploads/$file");
    }
)->middleware('verified');
