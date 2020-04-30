<?php

namespace app\admin\validate;

use think\Validate;

class Article extends Validate
{
    protected $rule = [
        'title'=>'require|max:50',
        'thumbnail'=>'require',
        'content'=>'require|max:10000',
    ];
    protected $message = [
        'title.require'=>'标题不能为空!',
        'title.max'=>'标题过长',
        'thumbnail.require'=>'请添加一张缩略图!',
        'content.max'=>'内容过长',
        'content.require'=>'请写一些内容',

    ];

    protected $scene = [
        'add' =>['title','thumbnail','content'],
    ];


}
