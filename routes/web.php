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


//注册
Route::get('/reg','RegController@register'); //注册视图
Route::post('/regdo','RegController@regdo'); //注册的编辑

Route::get('/login','RegController@login');//登录
Route::post('/logindo','RegController@logindo');//登录编辑
