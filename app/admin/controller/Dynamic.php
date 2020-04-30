<?php

namespace app\admin\controller;

use app\common\model\mysql\Dynamic as DynamicModel;
use app\admin\validate\Dynamic as DynamicValidate;
use think\App;
use think\Exception;
use think\exception\ValidateException;
use think\facade\Session;
use think\facade\View;
use think\Request;

class Dynamic extends AdminBaseController
{


    protected $dynamic_model;
    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->dynamic_model = new DynamicModel();
    }
    public function index(){

        try {
            $dynamic_list = $this->dynamic_model->getDynamic();
        }catch (Exception $exception){
            abort('404','页面异常');

        }
        //halt($dynamic_list);exit();
        View::assign([
            'dynamic_list'=>$dynamic_list,
        ]);
        return View::fetch();
    }
    public function add(Request $request){

        if (!$request->isPost()){
            return show(config('status.error'),'错误的请求方式!',null);
        }else{
            $data = $request->param();
            //halt($data);exit();
            try {
                validate(DynamicValidate::class)->scene('add')->check($data);
            }catch (ValidateException $validateException){
                return show(config('status.error'),$validateException->getError(),null);
            }
            try {

                if ($this->dynamic_model->saveDynamic($data)) {
                    return show(config('status.success'),'保存成功',null);
                }

            }catch (Exception $exception) {
                return show(config('status.error'),$exception->getMessage(),null);
            }

        }

    }
    public function del(Request $request){

        if (!$request->isPost()){
            return show(config('status.error'),'错误的请求方式!',null);
        }else{
            $id = $request->param('id','','intval');
            //halt($data);exit();
            try {

                if ($this->dynamic_model->delDynamicById($id)) {
                    return show(config('status.success'),'删除成功',null);
                }

            }catch (Exception $exception) {
                return show(config('status.error'),$exception->getMessage(),null);
            }

        }

    }

}