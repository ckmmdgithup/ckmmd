<?php

namespace app\admin\middleware;

use Closure;
use think\facade\Session;

class Login
{


    public function handle($request,Closure $closure){

        $admin_session = Session::get(config('admin.admin_session'));
        if ($admin_session){
            return redirect('/admin/index');
        }
        return $closure($request);

    }
}