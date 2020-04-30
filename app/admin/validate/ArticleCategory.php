<?php

namespace app\admin\validate;

use think\Validate;

class ArticleCategory extends Validate
{
    protected $rule = [
        'name'=>'require|max:50',
        'uname'=>'require|max:250',
        'id'=>'require',
        'pid'=>'require',
        'path'=>'require',
        'title'=>'require',
    ];
    protected $message = [
        'name.require'=>'用户名不能为空!',
        'name.max'=>'用户名过长',
        'uname.require'=>'用户名不能为空!',
        'uname.max'=>'用户名过长',
        'id.require'=>'必须的',
        'pid.require'=>'必须的',
        'path.require'=>'必须的',
        'title.require'=>'必须的',

    ];

    protected $scene = [
        'add' =>['name'],
        'edit'=>['name','uname','id','pid','path','title'],
    ];


}
