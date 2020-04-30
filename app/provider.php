<?php
use app\ExceptionHandle;
use app\Request;

// 容器Provider定义文件
return [
    'think\Request'          => Request::class,
    'think\exception\Handle' => ExceptionHandle::class,
    //'think\exception\Handle' => E::class,
    'think\Paginator' => 'app\common\orm\paginator\driver\Pagination',
];
