<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/28
 */


namespace app\api\controller;

use app\common\business\User as UserBus;

class User extends AuthBase
{
    
    /**
     * 获取信息
     *
     * @user LMG
     * @date 2020/8/28
     */
    public function index()
    {
        
        $user = (new UserBus()) -> getNormalUserById($this -> userId);
        $resultUser = [
            'id'       => $this -> userId,
            'username' => $user[ 'username' ],
            'sex'      => $user[ 'sex' ]
        ];
        
        return show(config('status.success'), 'OK', $resultUser);
    }
    
    /**
     * 个人中心修改
     * @return mixed
     * @user LMG
     * @date 2020/8/30
     */
    public function update()
    {
        
        $username = input('param.username', '', 'trim');
        $sex = input('param.sex', 0, 'intval');
        $data = [
            'username' => $username,
            'sex'      => $sex
        ];
        $validate = (new \app\api\validate\User()) -> scene('update_user');
        if ( ! $validate -> check($data)) {
            return show(config('status.error'), $validate -> getError());
        }
        $userBusObj = new UserBus();
        $user = $userBusObj -> update($this -> userId, $data);
        if ( ! $user) {
            return show(config('status.error'), '更新失败！');
        }
        
        return show(1, 'ok');
    }
}