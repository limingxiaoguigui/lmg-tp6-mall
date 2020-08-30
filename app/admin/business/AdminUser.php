<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/25
 */


namespace app\admin\business;

use app\common\model\mysql\AdminUser as AdminUserModel;
use think\Exception;

class AdminUser
{
    
    /**
     * 登录
     *
     * @param $data
     * @return mixed
     * @user LMG
     * @date 2020/8/25
     */
    public static function login($data)
    {
        
        try {
            //获取用户数据
            $AdminUserModel = new AdminUserModel();
            //获取用户信息
            $admin_user = self ::getAdminUserByUsername($data[ 'username' ]);
            if (empty($admin_user)) {
                throw new Exception('用户不存在!');
            }
            //判断密码是否正确
            if ($admin_user[ 'password' ] != md5($data[ 'password' ].'-lmg-tp6-mall')) {
                throw new Exception('密码错误!');
            }
            //更新记录信息
            $updateData = [
                'last_login_time' => time(),
                'last_login_ip'   => request() -> ip(),
                'update_time'     => time()
            ];
            $res = $AdminUserModel -> updateById($admin_user[ 'id' ], $updateData);
            if (empty($res)) {
                throw new Exception('登陆失败!');
            }
        } catch (Exception $e) {
            throw new Exception('内部异常，登陆失败！');
        }
        //记录session
        session(config('admin.session_admin_user'), $admin_user);
        return true;
    }
    
    /**
     * 通过用户名获取用户信息
     *
     * @param $username
     * @user LMG
     * @date 2020/8/25
     * @return array|bool
     */
    public static function getAdminUserByUsername($username)
    {
        
        //获取用户数据
        $AdminUserModel = new AdminUserModel();
        $admin_user = $AdminUserModel -> getAdminUserByUsername($username);
        if (empty($admin_user) || $admin_user -> status != config('status.mysql.table_normal')) {
            return false;
        }
        $admin_user = $admin_user -> toArray();
        
        return $admin_user;
    }
}