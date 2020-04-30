<?php

namespace app\admin\validate;

use think\Validate;

class AboutCk extends Validate
{
    protected $rule = [
        'webmaster'=>'require|max:50',
        'qq'=>'require|min:5|max:10',
        'git'=>'require|max:50',
        'email'=>'require|max:50',
        'brief'=>'require|max:500',
    ];
    protected $message = [
        'webmaster.require'=>'站长不能为空!',
        'webmaster.max'=>'站长名称过长!',
        'qq.require'=>'QQ不能为空!',
        'qq.min'=>'QQ',
        'git.require'=>'git不能为空!',
        'git.max'=>'git过长!',
        'email.require'=>'email不能为空!',
        'email.max'=>'email过长!',
        'brief.require'=>'brief不能为空!',
        'brief.max'=>'brief过长!',

    ];

    protected $scene = [
        'add' =>['webmaster','qq','git','email','brief'],
    ];


}
