<?php

namespace app\http\controller;

use think\Exception;
use think\facade\Session;
use think\facade\View;

class Index extends HttpBaseController
{
    public function index(){

        return View::fetch();
    }
}