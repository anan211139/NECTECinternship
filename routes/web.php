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
Route::get('/Laravel', 'Pagecontroller@getLaravelpage');
Route::get('/logout', 'logoutcontroller@logout');
Route::get('/connectchild/{id}','Pagecontroller@addchild');
Route::get('/addchild','Pagecontroller@addchildpage');
Route::get('/user', 'Pagecontroller@gethome');
Route::get('/choose', 'Pagecontroller@getchoosepage'); //subset of /user
Route::get('/step','Pagecontroller@getsteppage'); //subset of /user
Route::get('/userpage','Pagecontroller@getuserpage'); //subset of /user


Route::post('/loginsubmit', 'checklogin@pslogin');
Route::post('/loginsubmitinaddchild', 'checklogin@pslogininaddchild');
Route::post('/regissubmit', 'regisController@process');
Route::post('/regissubmitinaddchild', 'regisController@processinaddchild');
Route::post('/addchildsubmit','addchildcontroller@addchild');


Route::resource('Line','LineController');  //call path ที่กำหนด

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
