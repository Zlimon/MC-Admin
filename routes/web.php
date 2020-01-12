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

Route::get('/', 'PagesController@index')->name('index');
Route::patch('/', 'PagesController@startServer')->name('start-server');
Route::patch('/', 'PagesController@stopServer')->name('stop-server');
Route::post('/', 'PagesController@executeRcon')->name('execute-rcon');


Route::post('autocomplete/fetch', 'PagesController@autocomplete')->name('autocomplete.fetch');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
