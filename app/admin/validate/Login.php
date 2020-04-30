<?php

namespace app\admin\validate;

use think\Validate;

class Login extends Validate
{
    protected $rule = [
        'username'=>'require|max:50',
        'password'=>'require|max:255',
        'captcha' =>'require|checkCaptcha'
    ];
    protected $message = [
        'username.require'=>'用户名不能为空!',
        'username.max'=>'用户名过长',
        'password.require'=>'密码不能为空!',
        'password.max'=>'密码过长!',
        'captcha.require' =>'请输验证码!',
    ];

    public function checkCaptcha($value, $rules,$data=[])
    {
        if (!captcha_check($value)){

            return '验证码错误!!';
        }
        return true;

    }


}
