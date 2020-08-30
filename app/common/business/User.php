<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/27
 */


namespace app\common\business;

use app\common\lib\Str;
use app\common\lib\Time;
use app\common\model\mysql\User as UserModel;


class User
{
    
    public $userObj = null;
    
    public function __construct()
    {
        
        $this -> userObj = new UserModel();
    }
    
    /**
     * 登录
     *
     * @param $data
     * @return array|bool
     * @user LMG
     * @date 2020/8/30
     */
    public function login($data)
    {
        
        //判断验证码
        $redisCode = cache(config('redis.code_pre').$data[ 'phone_number' ]);
        if (empty($redisCode) || $redisCode != $data[ 'code' ]) {
            throw  new \think\Exception('不存在该验证码', -1009);
        }
        //判断是否有用户记录
        $user = $this -> userObj -> getUserByPhoneNumber($data[ 'phone_number' ]);
        if ( ! $user) {
            $username = '手机用户-'.$data[ 'phone_number' ];
            $userData = [
                'username'     => $username,
                'phone_number' => $data[ 'phone_number' ],
                'type'         => $data[ 'type' ],
                'status'       => config('status.mysql.table_normal')
            ];
            //防止数据库信息泄露
            try {
                //新增
                $this -> userObj -> save($userData);
                $userId = $this -> userObj -> id;
            } catch (\Exception $e) {
                throw new \think\Exception('数据库内部异常！');
            }
        } else {
            //更新表数据
            $userId = $user -> id;
            $username = $user -> username;
        }
        $token = Str ::getLoginToken($data[ 'phone_number' ]);
        $redisData = [
            "id"       => $userId,
            "username" => $username,
        ];
        $res = cache(config('redis.token_pre').$token, $redisData, Time ::userLoginExpiresTime($data[ 'type' ]));
        
        return $res ? ['token' => $token, 'username' => $username] : false;
    }
    
    /**
     * 获取用户信息
     *
     * @param $id
     * @user LMG
     * @date 2020/8/28
     * @return array
     */
    public function getNormalUserById($id)
    {
        
        $user = $this -> userObj -> getUserById($id);
        if ( ! $user || $user -> status != config('status.mysql.table_normal')) {
            return [];
        }
        
        return $user -> toArray();
    }
    
    /**
     * 根据用户名获取用户信息
     *
     * @param $username
     * @return array
     * @user LMG
     * @date 2020/8/30
     */
    public function getNormalUserByUsername($username)
    {
        
        $user = $this -> userObj -> getUserByUsername($username);
        if ( ! $user || $user -> status != config('status.mysql.table_normal')) {
            return [];
        }
        
        return $user -> toArray();
    }
    
    /**
     * 个人中心信息修改
     *
     * @param $id
     * @param $data
     * @return bool
     * @user LMG
     * @date 2020/8/30
     */
    public function update($id, $data)
    {
        
        $user = $this -> getNormalUserById($id);
        if ( ! $user) {
            throw new \think\Exception('不存在该用户！');
        }
        //检查用户名不存在
        $userResult = $this -> getNormalUserByUsername($data[ 'username' ]);
        if ($userResult && $userResult[ 'id' ] != $id) {
            throw new \think\Exception('该用户已经存在请重新设置！');
        }
        
        return $this -> userObj -> updateById($id, $data);
    }
}