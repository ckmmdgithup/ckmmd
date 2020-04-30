<?php

namespace app\admin\controller;

use app\admin\validate\Setting as SettingValidate;
use app\common\model\mysql\Setting as SettingModel;
use think\App;
use think\Exception;
use think\exception\ValidateException;
use think\facade\Cookie;
use think\facade\View;
use think\Request;

class Setting extends AdminBaseController
{
    protected $setting_model;
    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->setting_model = new SettingModel();
    }

    public function index(){
        $web_information = $this->setting_model->getWebInformation();
        if (!$web_information){
            abort('404','信息丢失了');
        }
        Cookie::set('web_information',$web_information,600);
        View::assign([
            'web_information'=>$web_information,
        ]);
        return View::fetch();
    }
    public function update(Request $request){

        if (!$request->isPost()){
            return show(config('status.error'),'请求方式错误',null);
        }
        $data = $request->param();
        try {
            validate(SettingValidate::class)->scene('update')->check($data);
        }catch (ValidateException $validateException){
            return show(config('status.error'),$validateException->getError(),null);
        }
        try {
            $data['update_time']=time();
            if ($this->setting_model->updateSetting($data)) {
                Cookie::delete('web_information');
                return show(config('status.success'),'更新成功',null);
            }

        }catch (Exception $exception) {
            return show(config('status.error'),$exception->getMessage(),null);
        }

    }

}