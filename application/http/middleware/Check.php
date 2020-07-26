<?php

namespace app\http\middleware;
use think\facade\Session;
class Check
{
    public function handle($request, \Closure $next)
    {
        if ($request->controller() != "Login") {
            if(!Session::get('name')){
                return redirect(url('admin/login/index'));
            }
        };
        $request->controller();
        return $next($request);
    }
}
