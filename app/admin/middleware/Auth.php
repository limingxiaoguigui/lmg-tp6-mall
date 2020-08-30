<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/15
 */


namespace app\admin\middleware;


class Auth
{
    
    /**
     * 中间件
     * @param $request
     * @param  \Closure  $next
     * @return mixed
     * @user LMG
     * @date 2020/8/25
     */
    public function handle($request, \Closure $next)
    {
        //前置中间件
        if (empty(session(config('admin.session_admin_user'))) && !preg_match("/login/", $request -> pathinfo())) {
            return redirect(url('login/index'));
        }
    
        return $next($request);
        
//        //后置中间件
//        if (empty(session(config('admin.session_admin_user'))) && $request -> controller() != 'Login') {
//            return redirect(url('login/index'));
//        }
//        $response = $next($request);
//        return $response;
    }
}