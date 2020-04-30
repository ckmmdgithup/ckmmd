<?php

namespace app\admin\validate;

use think\Validate;

class Setting extends Validate
{
    protected $rule = [
        'domain'=>'require|max:50',
        'server'=>'require |max:50',
        'web_case'=>'require|max:50',
        'information'=>'require|max:500',
        'logo'=>'require'
    ];
    protected $message = [
        'domain.require'=>'域名不能为空!',
        'domain.max'=>'域名名称过长!',
        'server.require'=>'请问使用的是什么服务器呢!',
        'server.max'=>'服务器名称太长了,可以尝试使用简称!',
        'web_case.require'=>'备案号不能为空!',
        'web_case.max'=>'备案号太长了!',
        'information.require'=>'information不能为空!',
        'information.max'=>'information名称过长!',
        'logo.require'=>'logo是一定要有的!',
    ];

    protected $scene = [
        'update' =>['domain','server','web_case','information','logo'],
    ];


}
