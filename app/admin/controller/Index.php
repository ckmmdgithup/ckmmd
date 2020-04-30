<?php

namespace app\admin\controller;

use think\facade\Session;
use think\facade\View;
use app\common\model\mysql\Dynamic as DynamicModel;
use app\common\model\mysql\Article as ArticleModel;
use think\Request;
use think\Model;
use think\App;


class Index extends AdminBaseController
{
    public function index(){

        return View::fetch();
    }
    public function welcome(){
        $dynamic_num = (new DynamicModel())->count();
        $article_num = (new ArticleModel())->getAllArticleList()->count();

        $sys_info = [
            'ip'=>'127.0.0.1',//服务器ip地址
            'os' => $_SERVER["SERVER_SOFTWARE"], //获取服务器标识的字串
            'version' => PHP_VERSION, //获取PHP服务器版本
            'time' => date("Y-m-d H:i:s", time()), //获取服务器时间
            'pc' => $_SERVER['SERVER_NAME'], //当前主机名
            'osname' => php_uname(), //获取系统类型及版本号
            'language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'], //获取服务器语言
            'port' => $_SERVER['SERVER_PORT'], //获取服务器Web端口
            'max_upload' => ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled", //最大上传
            'max_ex_time' => ini_get("max_execution_time")."秒", //脚本最大执行时间
            'mysql_version' => $this->_mysql_version(),
        ];
        //halt($sys_info);exit();
        View::assign([
            'article_num'=>$article_num,
            'dynamic_num'=>$dynamic_num,
            'sys_info'=>$sys_info
        ]);

        return View::fetch();
    }
    public function userInfo(){

        return View::fetch();

    }
    private function _mysql_version()
    {
        $Model = (new DynamicModel());
        $version = $Model->query("select version() as ver");
        return $version[0]['ver'];
    }

}