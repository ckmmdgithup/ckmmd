<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;


Route::group('',function (){
    Route::get('/','index');

})->prefix('Index/');

Route::group('',function (){
    Route::get('/article/list/:cate?','index');
    Route::post('/article/more_article','moreArticle');
    Route::get('/article/detailed/:url','detailed');
})->prefix('Article/')->ext('html');

Route::group('',function (){
    Route::get('/dynamic/list','index');
})->prefix('Dynamic/')->ext('html');

Route::group('',function (){
    Route::get('/about_ck/index','index');
})->prefix('AboutCk/')->ext('html');
