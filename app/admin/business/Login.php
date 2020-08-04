<?php
namespace app\admin\business;

use think\Exception;
use app\common\model\mysql\User as UserModel;
use think\facade\Session;

class Login
{//

    public function login($data,$request){
        $user_model = new UserModel();
        $user = $user_model->getUserByUsername($data['username']);
        if (empty($user)||$user->password!=md5($data['password'])||$user->status!= config('status.mysql.normal')){
            throw new Exception('用户名或密错误',config('status.break'));
        }
        $update_data = [
            'last_login_time' => time(),
            'last_login_ip'=>$request->ip(),
            'operate_user'=>$data['username']
        ];
        $result = $user_model->upDateById($user->id,$update_data);
        if (!$result){
            throw new Exception('登录失败!',config('status.break'));
        }
        Session::set(config('admin.admin_session'),$user);
        return true;
    }
}