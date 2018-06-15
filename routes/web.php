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
Route::get('/', 'Pagecontroller');
// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/home', 'Pagecontroller@gethome');
// Route::get('/home', function () {
//     return view('home');
// });
Route::get('/content', 'Pagecontroller');
// Route::get('/content', function () {
//     return view('content');
// });
Route::get('/login', 'Pagecontroller');
// Route::get('/login', function () {
//     return view('login');
// });
Route::get('/regis', 'Pagecontroller');
// Route::get('/regis', function () {
//     return view('regis');
// });
Route::post('/home/submit', 'MessageController@submit');

Route::resource('Line','LineController');  //call path ที่กำหนด
