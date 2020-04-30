<?php

namespace app\http\controller;


use think\facade\View;


class AboutCk extends HttpBaseController
{

    public function index(){
        return View::fetch();
    }

}