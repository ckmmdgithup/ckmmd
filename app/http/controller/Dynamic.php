<?php

namespace app\http\controller;

use app\common\model\mysql\Dynamic as DynamicModel;
use think\App;
use think\Exception;
use think\facade\View;


class Dynamic extends HttpBaseController
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
        View::assign([
            'dynamic_list'=>$dynamic_list,
        ]);
        return View::fetch();
    }

}