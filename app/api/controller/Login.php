<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/27
 */


namespace app\api\controller;


use app\BaseController;

class Login extends BaseController
{
    
    /**
     * 前端登录
     *
     * @return mixed
     * @user LMG
     * @date 2020/8/27
     */
    public function index()
    {
        
        if ( ! $this -> request -> isPost()) {
            return show(config('status.error'), '非法请求！');
        }
        //参数校验 1、原生 2、tp6验证机制
        $phone_number = $this -> request -> param('phone_number', '', 'trim');
        $code = $this -> request -> param('code', '', 'intval');
        $type = $this -> request -> param('type', '', 'intval');
        $data = ['phone_number' => $phone_number, 'code' => $code, 'type' => $type];
        //验证器
        $validate = new \app\api\validate\User();
        if ( ! $validate -> scene('login')
                         -> check($data)) {
            return show(config('status.error'), $validate -> getError());
        }
        try {
            $result = (new \app\common\business\User()) -> login($data);
        } catch (\Exception $e) {
            return show($e -> getCode(), $e -> getMessage());
        }
        if ($result) {
            return show(config('status.success'), '登陆成功！', $result);
        }
        
        return show(config('status.error'), '登陆失败！');
    }
    
}