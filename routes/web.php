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

Route::get('/center','RegController@center'); //个人中心
Route::get('/getAccessToken','RegController@getAccessToken'); //获取accesstoken接口

//关于access_token
Route::prefix('/user')->middleware('token')->group(function(){
    Route::get('/test','Access\TokenController@test');//access_token接口测试
    Route::get('/test1','Access\TokenController@test1');//access_token接口测试
});

