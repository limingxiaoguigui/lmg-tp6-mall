<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/25
 */


namespace app\admin\validate;

use think\Validate;

class AdminUser extends Validate
{
    
    /**
     * 规则
     *
     * @var string[]
     */
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
        'captcha'  => 'require|checkCaptcha'
    ];
    
    /**
     * 提示消息
     *
     * @var string[]
     */
    protected $message = [
        'username' => '用户名不能为空',
        'password' => '密码不能为空',
        'captcha'  => '验证码不能为空',
    ];
    
    /**
     * 自定义验证方法
     *
     * @param $value
     * @param $rule
     * @param  array  $data
     * @user LMG
     * @date 2020/8/25
     * @return bool|string
     */
    protected function checkCaptcha($value, $rule, $data = [])
    {
        
        if ( ! captcha_check($value)) {
            return '您输入的验证码不正确！';
        }
        
        return true;
    }
    
}