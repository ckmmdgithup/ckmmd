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
    Route::get('login','index')->middleware(\app\admin\middleware\Login::class);
    Route::post('login','login');
    Route::get('login_out','loginOut')->middleware(\app\admin\middleware\Admin::class);
})->prefix('Login/');
Route::group('',function (){
    Route::get('index','index');
    Route::get('welcome','welcome');
    Route::get('user_info','userInfo');

})->prefix('Index/')
   ->middleware(\app\admin\middleware\Admin::class);

Route::group('',function (){
    Route::get('article_category/list','index');
    Route::post('article_category/add','add');
    Route::get('article_category/edit/:id','edit');
    Route::post('article_category/edit','edit');
    Route::post('article_category/status','status');
    //Route::post('article_category/son_list','sonList');


})->prefix('ArticleCategory/')
   ->middleware(\app\admin\middleware\Admin::class);
Route::group('',function (){
    Route::get('article/list/:uname?','index');
    Route::get('article/add','add');
    Route::post('article/add','add');
    Route::get('article/edit/:id','edit');
    Route::post('article/edit','edit');

    Route::post('article/status','status');
    Route::post('article/hot','hot');
    Route::post('article/carousel','carousel');
    Route::post('article/sreach','sreach');


})->prefix('Article/')
   ->middleware(\app\admin\middleware\Admin::class);
Route::group('',function (){
    Route::post('upload/article_thumbnail','articleThumbnail');
    Route::post('upload/article_content_image','articleContentImage');
    Route::post('upload/dynamic_img','dynamicImg');
    Route::post('upload/about_ck_img','aboutCkImg');
    Route::post('upload/logo','logo');
    Route::post('upload/carousel','carousel');

})->prefix('Upload/')
   ->middleware(\app\admin\middleware\Admin::class);


Route::group('',function (){
    Route::get('dynamic/list','index');
    Route::post('dynamic/add','add');
    Route::post('dynamic/del','del');
})->prefix('Dynamic/')
    ->middleware(\app\admin\middleware\Admin::class);

Route::group('',function (){
    Route::get('about_ck/index','index');
    Route::post('about_ck/update','update');
})->prefix('AboutCk/')
   ->middleware(\app\admin\middleware\Admin::class);
Route::group('',function (){
    Route::get('setting/index','index');
    Route::post('setting/update','update');
})->prefix('Setting/')
   ->middleware(\app\admin\middleware\Admin::class);

Route::group('',function (){
    Route::get('carousel/list','index');
    Route::get('carousel/add','add');
    Route::post('carousel/add','add');
    Route::post('carousel/del','del');
    Route::post('carousel/sort','sort');
})->prefix('Carousel/')
    ->middleware(\app\admin\middleware\Admin::class);