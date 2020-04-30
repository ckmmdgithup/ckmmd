<?php

namespace app\admin\controller;


use think\facade\Filesystem;
use think\Request;

class Upload extends AdminBaseController
{
    public function articleThumbnail(Request $request){

        if (!$request->isPost()){
            return show(config('status.error'),'非法的请求');
        }
        $article_thumbnail = $request->file('thumbnail');
        $article_thumbnail_url = Filesystem::disk('upload')->putFile( 'article', $article_thumbnail);
        if (!$article_thumbnail_url){
            return show(config('status.error'),'上传失败');
        }
        $article_thumbnail_url = '/upload/'.$article_thumbnail_url;

        return show(config('status.success'),'上传成功',$article_thumbnail_url);
    }
    public function articleContentImage(Request $request){
        if (!$request->isPost()){
            return build(-1,'上传失败',[]);
        }
        $article_img = $request->file('file');
        $article_img_url = Filesystem::disk('upload')->putFile( 'article', $article_img);
        if (!$article_img_url){
            return build(-1,'上传失败',[]);
        }
        $article_img_url = '/upload/'.$article_img_url;
        return build(0,'上传成功',['src'=>$article_img_url]);
    }


    public function dynamicImg(Request $request){

        if (!$request->isPost()){
            return show(config('status.error'),'非法的请求');
        }
        $img = $request->file('img');
        $img_url = Filesystem::disk('upload')->putFile( 'dynamic', $img);
        if (!$img_url){
            return show(config('status.error'),'上传失败');
        }
        $img_url = '/upload/'.$img_url;

        return show(config('status.success'),'上传成功',$img_url);
    }



    public function logo(Request $request){

        if (!$request->isPost()) {
            return show(config('status.error'),'非法的请求');
        }
        $img = $request->file('logo');
        $img_url = Filesystem::disk('upload')->putFile( 'logo', $img);
        if (!$img_url){
            return show(config('status.error'),'上传失败');
        }
        $img_url = '/upload/'.$img_url;

        return show(config('status.success'),'上传成功',$img_url);
    }
    public function aboutCkImg(Request $request){

        if (!$request->isPost()) {
            return show(config('status.error'),'非法的请求',null);
        }
        $img = $request->file('img');
        $img_url = Filesystem::disk('upload')->putFile( 'aboutck', $img);
        if (!$img_url){
            return show(config('status.error'),'上传失败');
        }
        $img_url = '/upload/'.$img_url;

        return show(config('status.success'),'上传成功',$img_url);
    }
    public function carousel(Request $request){

        if (!$request->isPost()) {
            return show(config('status.error'),'非法的请求');
        }
        $img = $request->file('img');
        $img_url = Filesystem::disk('upload')->putFile( 'carousel', $img);
        if (!$img_url){
            return show(config('status.error'),'上传失败');
        }
        $img_url = '/upload/'.$img_url;

        return show(config('status.success'),'上传成功',$img_url);
    }






}























