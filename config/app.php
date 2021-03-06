<?php
// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [
    // 应用地址
    'app_host'         => env('app.host', ''),
    // 应用的命名空间
    'app_namespace'    => '',
    // 是否启用路由
    'with_route'       => true,
    // 是否启用事件
    'with_event'       => true,
    // 默认应用
    'default_app'      => 'http',
    // 默认时区
    'default_timezone' => 'Asia/Shanghai',

    // 应用映射（自动多应用模式有效）
    'app_map'          => [],
    // 域名绑定（自动多应用模式有效）
    'domain_bind'      => [],
    // 禁止URL访问的应用列表（自动多应用模式有效）
    'deny_app_list'    => [],

//    // 异常页面的模板文件
//    'exception_tmpl'   => \think\facade\App::getAppPath() . '/view/error/404.html',

    // 错误显示信息,非调试模式有效
    'error_message'    => '服务器异常',
    // 显示错误信息
    'show_error_msg'   => true,
    'http_exception_template'    =>  [
        // 定义404错误的模板文件地址
        404 =>  \think\facade\App::getAppPath() . '/view/error/404.html',
    ],
    //分页数量
    'page_num'=>10,

];
