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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', 'Weixin\WxController@view')->middleware('CheckLogin');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/weixin/menu', 'Weixin\WxController@createMenu');
Route::post('/weixin/docreate', 'Weixin\WxController@doCreate');


//调用api测试接口
Route::get('/weixin/api', 'Weixin\WxController@test');

Route::get('/login', 'Weixin\WxController@login');


Route::post('/user/login', 'User\UserController@login');
Route::get('/wish', 'User\UserController@wish');
