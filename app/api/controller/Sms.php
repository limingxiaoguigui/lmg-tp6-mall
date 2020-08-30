<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/25
 */

declare(strict_types = 1);

namespace app\api\controller;


use app\BaseController;
use app\common\business\Sms as SmsBus;

class Sms extends BaseController
{
    
    /**
     * 发送验证码
     *
     * @return object
     * @user LMG
     * @date 2020/8/25
     */
    public function code() : object
    {
        
        $phoneNumber = input('param.phone_number', '', 'trim');
        $data = [
            'phone_number' => $phoneNumber,
        ];
        try {
            validate(\app\api\validate\User::class)
                -> scene('send_code')
                -> check($data);
        } catch (\think\exception\ValidateException $e) {
            return show(config('status.error'), $e -> getError());
        }
        //调用business层的数据
        if (SmsBus ::sendCode($phoneNumber,6,"ali")) {
            return show(config('status.success'), '发送验证码成功！');
        }
        
        return show(config('status.error'), '发送验证码失败！');
    }
}