<?php
return [

//    // 异常页面的模板文件
//    'exception_tmpl'   => \think\facade\App::getAppPath() . '/view/error/404.html',

    // 错误显示信息,非调试模式有效
    'error_message'    => '服务器异常',
    // 显示错误信息
    'show_error_msg'   => true,
    'http_exception_template'    =>  [
        // 定义404错误的模板文件地址
        404 =>  \think\facade\App::getAppPath() . '/view/error/404.html',
    ]
];