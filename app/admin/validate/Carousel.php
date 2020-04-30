<?php

namespace app\admin\validate;

use think\Validate;

class Carousel extends Validate
{
    protected $rule = [
        'img'=>'require',
        'url'=>'require',
        'title'=>'require',
    ];
    protected $message = [
        'img.require'=>'请添加一张滚动图!',
        'url.require'=>'请选择一片文章!',
        'title.require'=>'请选择一片文章!',
    ];

    protected $scene = [
        'add' =>['img','url','title'],
    ];


}
