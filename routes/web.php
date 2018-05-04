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

Route::get('/test', 'MainController@test');


Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );

Route::get('/', 'MainController@index');
Route::get('/info', 'MainController@info')->name("info");
Route::get('/service', 'MainController@service')->name("service");
Route::post('/save_telegram', 'MainController@save_telegram')->name("save_telegram");
Route::get('/kladr', 'MainController@kladr');
// Route::get('/get_user_data', 'MainController@get_user_data');
Route::get('/get_receiver_data/{rid}', 'MainController@get_receiver_data');
Route::get('/get_template_data/{tid}', 'MainController@get_template_data');


Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@index')->name('save_user');

Route::get('/home/templates', 'HomeController@templates')->name('templates');
Route::post('/home/templates', 'HomeController@templates')->name('save_template');
Route::get('/home/templates/get_templates', 'HomeController@get_templates');
Route::delete('/home/templates/del_template', 'HomeController@del_template');

Route::get('/home/saved_receivers', 'HomeController@saved_receivers')->name('saved_receivers');
Route::post('/home/saved_receivers', 'HomeController@saved_receivers')->name('save_receiver');
Route::get('/home/saved_receivers/get_receivers', 'HomeController@get_receivers');
Route::delete('/home/saved_receivers/del_receiver', 'HomeController@del_receiver');
