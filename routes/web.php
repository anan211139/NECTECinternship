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
Route::get('/', 'Pagecontroller@gethome');
Route::get('/getLaravelpage', 'Pagecontroller@getLaravelpage');
Route::post('/loginsubmit', 'checklogin@pslogin');
Route::post('/regissubmit', 'regisController@psregis');
// Route::post('/home/submit', 'MessageController@submit');


Route::resource('Line','LineController');  //call path ที่กำหนด

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
