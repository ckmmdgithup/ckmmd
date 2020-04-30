<?php

namespace app\admin\controller;

use app\admin\validate\Carousel as CarouselValidate;
use app\common\model\mysql\Carousel as CarouselModel;
use app\admin\business\Article as ArticleBusiness;
use think\App;
use think\Exception;
use think\exception\ValidateException;
use think\facade\View;
use think\Request;

class Carousel extends AdminBaseController
{


    protected $carousel_model;
    protected $article_business;
    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->article_business = new ArticleBusiness();
        $this->carousel_model = new CarouselModel();
    }
    public function index(){
        try {
            $carousel_list = $this->carousel_model->getCarousel();
            View::assign([
                'carousel_list'=>$carousel_list,
            ]);
            return View::fetch();
        }catch (Exception $exception){
            abort(404);
        }

    }
    public function add(Request $request){

        if ($request->isPost()){
            $data = $request->param();
            //halt($data);exit();
            try {
                validate(CarouselValidate::class)->scene('add')->check($data);
            }catch (ValidateException $validateException){
                return show(config('status.error'),$validateException->getError(),null);
            }
            try {

                if ($this->carousel_model->saveCarousel($data)) {
                    return show(config('status.success'),'保存成功',null);
                }

            }catch (Exception $exception) {
                return show(config('status.error'),$exception->getMessage(),null);
            }

        }else{
            $article_list = $this->article_business->getArticleByUname();
            View::assign([
                'article_list'=>$article_list,
            ]);
            return View::fetch();
        }

    }
    public function del(Request $request){

        if (!$request->isPost()){
            return show(config('status.error'),'错误的请求方式!',null);
        }else{
            $id = $request->param('id','','intval');
            try {

                if ($this->carousel_model->delCarouselById($id)) {
                    return show(config('status.success'),'删除成功',null);
                }

            }catch (Exception $exception) {
                return show(config('status.error'),$exception->getMessage(),null);
            }

        }

    }
    public function sort(Request $request){
        if (!$request->isPost()){
            return show(config('status.error'),'错误的请求方式!',null);
        }else{
            $id = $request->param('id','','intval');
            $sort = $request->param('sort','','intval');
            try {

                if ($this->carousel_model->sortCarouselById($id,$sort)) {
                    return show(config('status.success'),'修改成功',null);
                }

            }catch (Exception $exception) {
                return show(config('status.error'),$exception->getMessage(),null);
            }

        }
    }

}