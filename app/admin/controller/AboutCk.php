<?php

namespace app\admin\controller;

use app\admin\validate\AboutCk as AboutCkValidate;
use app\common\model\mysql\AboutCk as AboutCkModel;
use think\App;
use think\Exception;
use think\exception\ValidateException;
use think\facade\Cookie;
use think\facade\View;
use think\Request;

class AboutCk extends AdminBaseController
{
    protected $about_ck_model;
    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->about_ck_model = new AboutCkModel();
    }

    public function index(){
        $ck_information = $this->about_ck_model->getCkInformation();
        if (!$ck_information){
            abort('404','信息丢失了');
        }

        View::assign([
            'ck_information'=>$ck_information,
        ]);
        Cookie::set('ck_information',$ck_information,600);
        return View::fetch();
    }
    public function update(Request $request){

        if (!$request->isPost()){
            return show(config('status.error'),'请求方式错误',null);
        }
        $data = $request->param();
        try {
            validate(AboutCkValidate::class)->scene('update')->check($data);
        }catch (ValidateException $validateException){
            return show(config('status.error'),$validateException->getError(),null);
        }
        //halt($data);exit();
        try {

            $data['update_time']=time();
            if ($this->about_ck_model->updateAboutCk($data)) {
                Cookie::delete('ck_information');
                return show(config('status.success'),'更新成功',null);
            }

        }catch (Exception $exception) {
            return show(config('status.error'),$exception->getMessage(),null);
        }

    }

}