<?php
namespace app\admin\controller;

use think\App;
use think\Exception;
use think\facade\Cookie;
use think\facade\View;
use think\Request;
use app\admin\validate\ArticleCategory as ArticleCategoryValidate;
use app\admin\business\ArticleCategory as ArticleCategoryBusiness;
use think\exception\ValidateException;

use app\common\model\mysql\ArticleCategory as CateModel;
class ArticleCategory extends AdminBaseController
{

    protected $article_category_business = null;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->article_category_business = new ArticleCategoryBusiness();

    }

    public function index(){
        //$cate = (new CateModel());
        //halt($cate->article()->where(['cate_uname'=>'php'])->update(['cate_uname'=>'phpw']));exit();
        return View::fetch();
    }
    public function add(Request $request){


        if (!$request->isPost()){

            return show(config('status.error'),'错误的请求方式',null);
        }
        $name = $request->param('name','','trim');
        $data = [
            'name' => $name
        ];
        try {
            validate(ArticleCategoryValidate::class)->scene('add')->check($data);
        }catch (ValidateException $validateException){
            return show(config('status.error'),$validateException->getError(),null);
        }
        try {
            $article_category_business = new ArticleCategoryBusiness();
            if ($article_category_business->add($data) == true) return show(config('status.success'),'添加成功',null);

        }catch (Exception $exception){
            return show(config('status.error'),$exception->getMessage(),null);
        }
    }
    public function edit(Request $request){

        if ($request->isPost()){

            $data = $request->param();
            try {
                validate(ArticleCategoryValidate::class)->scene('edit')->check($data);
            }catch (ValidateException $validateException){
                return show(config('status.error'),$validateException->getError(),null);
            }
            try {
                if ($data['pid']==0){
                    $data['path'] = '' ;
                }
                $update_data = [
                    'id'=>$data['id'],
                    'name'=>$data['name'],
                    'uname'=>$data['uname'],
                    'pid'=>$data['pid'],
                    'has_son'=>$data['has_son'],
                    'path'=>$data['path'].$data['pid'].',',
                    'update_time'=>time(),
                    'title'=>$data['title'],
                    'status'=>config('status.mysql.normal'),
                    'keywords'=>$data['keywords'],
                    'description'=>$data['description']
                ];
                if ($this->article_category_business->ArticleCategoryUpdate($update_data)==true) {
                    //Cookie::delete('article_category_source_data');
                    //halt($res);
                    return show(config('status.success'),'修改成功',null);
                }

            }catch (Exception $exception){
                return show(config('status.error'),$exception->getMessage(),null);
            }

        }else{
            $article_category_id = $request->param('id','','intval');

            if (empty($article_category_id)) abort(404,'页面异常!!');
            try {
                $article_category = $this->article_category_business->getArticleCategoryById($article_category_id);

                if ($article_category){
                    View::assign([
                        'article_category'=>$article_category,
                    ]);
                    //Cookie::set('article_category_source_data',$article_category,600);
                    return View::fetch();
                }
            }catch (\Exception $exception){
                abort(404,'页面异常!!!');
            }
        }
    }
    public function status(Request $request){
        if ($request->isPost()){
            //halt($request->param());exit();
            $status = $request->param('status','','intval');
            $id = $request->param('id','','intval');
            $path = $request->param('path');
            $has_son = $request->param('has_son');
            $uname = $request->param('uname');

            if ($status === null || $id === null){
                return show(config('status.error'),'参数不能为空',null);
            }
            try {
                $update_data = [
                    'id'=>$id,
                    'status'=>$status,
                    'path'=>$path,
                    'has_son'=>$has_son,
                    'uname'=>$uname
                ];
                if ($this->article_category_business->ArticleCategoryStatusUpdate($update_data)==true) {

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
































