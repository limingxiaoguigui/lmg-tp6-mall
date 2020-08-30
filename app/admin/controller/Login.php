<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/17
 */


namespace app\admin\controller;

use app\common\model\mysql\AdminUser;

class Login extends AdminBase
{
    
    /**
     * 初始化
     * @user LMG
     * @date 2020/8/23
     */
    public function initialize()
    {
         
         //如果已登录，直接跳转到后台首页
        if ($this -> isLogin()) {
            redirect(url('index/index')) -> send();
        }
    }
    
    /**
     * 登录页
     *
     * @user LMG
     * @date 2020/8/23
     */
    public function index()
    {
        
        return view();
    }
    
    /**
     * 登录校验
     *
     * @user LMG
     * @date 2020/8/23
     */
    public function check()
    {
    
        if ( ! $this -> request -> isPost()) {
            return show(config('status.error'), '请求方式错误！');
        }
        //参数校验 1、原生 2、tp6验证机制
        $username = $this -> request -> param('username', '', 'trim');
        $password = $this -> request -> param('password', '', 'trim');
        $captcha = $this -> request -> param('captcha', '', 'trim');
        $data = ['username' => $username, 'password' => $password, 'captcha' => $captcha];
        //验证器
        $validate = new \app\admin\validate\AdminUser();
        if (!$validate -> check($data)) {
            return show(config('status.error'),$validate->getError());
        }
        //        if (empty($username) || empty($password) || empty($captcha)) {
        //            return show(config('status.error'), '参数不能为空！');
        //        }
//        // 需要校验验证码
//        if ( ! captcha_check($captcha)) {
//            return show(config('status.error'), '验证码不正确！');
//        }
        try {
            $result = \app\admin\business\AdminUser ::login($data);
        } catch (\Exception $e) {
            return show(config('status.error'), $e -> getMessage());
        }
        if ($result) {
            return show(config('status.success'), '登陆成功！');
        } else {
            return show(config('status.error'), '登陆失败！');
        }
       
    }
}