<?php

namespace app\admin\controller;

use app\admin\validate\Article as ArticleValidate;
use app\admin\business\Article as ArticleBusiness;
use think\App;
use think\Exception;
use think\exception\ValidateException;
use think\facade\Cookie;
use think\facade\Session;
use think\facade\View;
use think\Request;

class Article extends AdminBaseController
{

    protected $article_business;
    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->article_business = new ArticleBusiness();
    }

    public function index(Request $request){
        $uname = $request->param('uname','','');
        try {
            $article_list = $this->article_business->getArticleByUname($uname);
        }catch (Exception $exception){
            abort('404','页面异常');

        }
        //halt($article_list);exit();
        View::assign([
            'article_list'=>$article_list,
        ]);
        return View::fetch();
    }
    public function sreach(Request $request){
        $data = $request->param();
        try {
            $article_list = $this->article_business->sreach($data);
            if ($article_list){
                $view = view('sreach',[
                    'article_list'=>$article_list,
                ]);
                return $view;
            }
        }catch (Exception $exception){
            return 0;

        }
    }
    public function add(Request $request){
        if ($request->isPost()){
            $data = $request->param();
            //halt($data);exit();
            try {
                validate(ArticleValidate::class)->scene('add')->check($data);
            }catch (ValidateException $validateException){
                return show(config('status.error'),$validateException->getError(),null);
            }
            try {
                if ($this->article_business->add($data)==true) {
                    return show(config('status.success'),'保存成功',null);
                }

            }catch (Exception $exception) {
                return show(config('status.error'),$exception->getMessage(),null);
            }

        }else{
            return View::fetch();
        }
    }
    public function edit(Request $request){
        if ($request->isPost()){
            $data = $request->param();
            //halt($data);exit();
            try {
                validate(ArticleValidate::class)->scene('add')->check($data);
            }catch (ValidateException $validateException){
                return show(config('status.error'),$validateException->getError(),null);
            }
            try {

                if ($this->article_business->update($data)==true) {
                    return show(config('status.success'),'修改成功',null);
                }

            }catch (Exception $exception) {
                return show(config('status.error'),$exception->getMessage(),null);
            }
        }else{
            $article_id = $request->param('id','','intval');

            if (empty($article_id)) abort(404,'页面异常!!');
            try {
                $article = $this->article_business->getArticleById($article_id);
                //halt($article);exit();
                if ($article){
                    View::assign([
                        'article'=>$article,
                    ]);
                    return View::fetch();
                }
            }catch (\Exception $exception){
                abort(404,'页面异常!!!');
            }
        }

    }
    public function status(Request $request){
        if ($request->isPost()){
            $status = $request->param('status','','intval');
            $id = $request->param('id','','intval');

            if ($status === null || $id === null){
                return show(config('status.error'),'参数不能为空',null);
            }
            try {
                $update_data = [
                    'id'=>$id,
                    'status'=>$status,
                ];
                //halt($update_data);exit();
                if ($this->article_business->articleStatusUpdate($update_data)==true) {
                    return show(config('status.success'),'修改成功',null);
                }
            }catch (\Exception $exception){
                return show(config('status.error'),$exception->getMessage(),null);
            }
        }else{
            abort(404,'页面异常!!!');
        }
    }
    public function hot(Request $request){
        if ($request->isPost()){
            $is_hot = $request->param('is_hot','','intval');
            $id = $request->param('id','','intval');

            if ($is_hot === null || $id === null){
                return show(config('status.error'),'参数不能为空',null);
            }
            try {
                $update_data = [
                    'id'=>$id,
                    'is_hot'=>$is_hot,
                ];
                //halt($update_data);exit();
                if ($this->article_business->articleHotUpdate($update_data)==true) {
                    return show(config('status.success'),'修改成功',null);
                }
            }catch (\Exception $exception){
                return show(config('status.error'),$exception->getMessage(),null);
            }
        }else{
            abort(404,'页面异常!!!');
        }
    }


}

































