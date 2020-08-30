<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/24
 */


namespace app\admin\controller;


class Logout extends AdminBase
{
    
    /**
     * 退出登录
     * @user LMG
     * @date 2020/8/24
     */
    public function index()
    {
        //清除session
        session(config('admin.session_admin_user'), null);
        redirect(url('login/index'))->send();
    }
}