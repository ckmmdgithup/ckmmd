<?php

namespace app\admin\validate;

use think\Validate;

class Dynamic extends Validate
{
    protected $rule = [
        'img'=>'require',
        'content'=>'require|max:150',
    ];
    protected $message = [
        'img.require'=>'请添加一张缩略图!',
        'content.max'=>'内容过长',
        'content.require'=>'请写一些内容',
    ];

    protected $scene = [
        'add' =>['img','content'],
    ];


}
