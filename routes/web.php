<?php

use Illuminate\Support\Facades\Auth;
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
Route::get('/bookshelf', 'BookController@bookshelf')->middleware('verified')->name('bookshelf');

Route::resource('clients', 'Admin\ClientController')->middleware('verified');
Route::resource('books', 'Admin\BookController')->middleware('verified');

Route::group(['middleware' => 'verified', 'prefix' => 'reports'], function () {
    Route::get('/', 'Admin\ReportController@index')->name('reports.index');
    Route::get('/create', 'Admin\ReportController@create')->name('reports.create');
    Route::get('/{report}', 'Admin\ReportController@show')->name('reports.show');
    Route::get('/download/{report}', 'Admin\ReportController@download')->name('reports.download');
});

Route::post('/theme', 'Admin\ThemeController@update')->middleware('verified')->name('theme');

Route::get('/cart', 'OrderController@index')->middleware('verified')->name('cart.index');
Route::get('/cart/checkout', 'OrderController@checkout')->middleware('verified')->name('cart.checkout');
Route::post('/cart/{book}', 'OrderController@update')->middleware('verified')->name('cart.update');
Route::post('/payment', 'OrderController@payment')->middleware('verified')->name('cart.payment');
Route::delete('/cart/{book}', 'OrderController@remove')->middleware('verified')->name('cart.remove');
Route::put('/cart/{book}', 'OrderController@edit')->middleware('verified')->name('cart.edit');
Route::get('/orders', 'OrderController@list')->middleware('verified')->name('order.list');
Route::get('/transaction/cancelled/{reference}', 'TransactionController@cancel')->name('transaction.cancel');
Route::get('/transaction/{reference}', 'TransactionController@status')->name('transaction.status');
Route::get('/retry/{reference}', 'TransactionController@retry')->name('transaction.retry');
Route::get('/transaction/result/{reference}', 'TransactionController@result')->name('transaction.result');

Route::get('/export', 'ExportController@export')->middleware('verified')->name('books.export');
Route::post('/import', 'ImportController@import')->middleware('verified')->name('books.import');

Route::get(
    '/uploads/{file}',
    function ($file) {
        return Storage::response("uploads/$file");
    }
)->middleware('verified');


