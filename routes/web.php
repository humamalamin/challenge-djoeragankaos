<?php

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

Route::get('/','IndexController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth' => 'web'])->group(function(){

    Route::resource('supliers','Admin\SuplierController');

    Route::resource('produks','Admin\ProdukController');

    Route::resource('kotas','Admin\KotaController');
});
