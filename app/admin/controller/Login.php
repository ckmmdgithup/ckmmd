<?php
namespace app\admin\controller;


use think\Exception;
use think\exception\ValidateException;
use think\Request;
use think\facade\View;
use app\admin\validate\Login  as LoginValidate;
use app\admin\business\Login  as LoginBusiness;
use think\facade\Session;

class Login extends AdminBaseController
{
    public function index(){
        return View::fetch();
    }
    public function login(Request $request){
        //return 'hello word!';

        if (!$request->isPost()){
            return show(config('status.error'),'错误的请求',null);
        }
        $username = $request->param('username','','trim');
        $password = $request->param('password','','trim');
        $captcha  = $request->param('captcha','','trim');
        $data = [
            'username'=>$username,
            'password'=>$password,
            'captcha' =>$captcha
        ];
        try {
            validate(LoginValidate::class)->check($data);
        }catch (ValidateException $validateException){
            return show(config('status.error'),$validateException->getError(),null);
        }

        try {
            $login_business = new LoginBusiness();
            if ($login_business->login($data,$request)==true){
                return show(config('status.success'),'登陆成功',null);
            };
        }catch (Exception $exception){
            return show(config('status.error'),$exception->getMessage(),null);
        }
    }
    public function loginOut(){
        Session::delete(config('admin.admin_session'));
        return redirect('/admin/login');
    }


}
