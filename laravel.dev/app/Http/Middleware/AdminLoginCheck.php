<?php

namespace App\Http\Middleware;

use Closure;

class AdminLoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * handle 方法会自动的执行
     */
    public function handle($request, Closure $next)
    {   
        // 做一下登录检测的的处理，检测session里面是否存在登录标识
        // 如果不存在则我们重定向到登录路由
        if( session('id') <= 0 ){
            return redirect('admin/login');
        }
        // $request 简单的理解是 http请求里面的一些资源信息 url get参数 cookie
        return $next($request);
    }
}
