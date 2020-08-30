<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/23
 */


namespace app\admin\controller;

use app\BaseController;

class AdminBase extends BaseController
{
    
    public $adminUser = null;
    
    /**
     * 初始化
     *
     * @user LMG
     * @date 2020/8/23
     */
    public function initialize()
    {
        parent ::initialize();
        //如果未登录，直接跳转到登录页 ---切换至中间件Auth中
//        if (empty($this -> isLogin())) {
//             redirect(url('login/index'), 302)->send();
//        }
    }
    
    /**
     * 判断是否已经登录
     *
     * @return bool
     * @user LMG
     * @date 2020/8/23
     */
    public function isLogin()
    {
        
        $this -> adminUser = session((config('admin.session_admin_user')));
        if (empty($this -> adminUser)) {
            return false;
        }
        
        return true;
    }
}