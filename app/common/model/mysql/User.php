<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/28
 */


namespace app\common\model\mysql;


use think\Model;

class User extends Model
{
    
    /**
     * 自动写入时间
     *
     * @var bool
     */
    protected $autoWriteTimestamp = true;
    
    /**
     * 通过手机获取用户信息
     *
     * @param $phoneNumber
     * @return array|bool|Model|null
     * @user LMG
     * @date 2020/8/28\
     */
    public function getUserByPhoneNumber($phoneNumber)
    {
        
        if (empty($phoneNumber)) {
            return false;
        }
        $where = [
            "phone_number" => $phoneNumber,
        ];
        
        return $this -> where($where)
                     -> find();
    }
    
    /**
     * 根据用户名获取用户信息
     *
     * @param $username
     * @return array|bool|Model|null
     * @user LMG
     * @date 2020/8/30
     */
    public function getUserByUsername($username)
    {
        
        if (empty($username)) {
            return false;
        }
        $where = [
            "username" => $username,
        ];
        
        return $this -> where($where)
                     -> find();
    }
    
    /**
     * 根据id更新数据
     *
     * @param $id
     * @param $data
     * @user LMG
     * @date 2020/8/23
     * @return bool
     */
    public function updateById($id, $data)
    {
        
        $id = intval($id);
        if (empty($id) || empty($data) || ! is_array($data)) {
            return false;
        }
        $where = [
            'id' => $id,
        ];
        
        return $this -> where($where)
                     -> save($data);
    }
    
    /**
     * 根据id获取用户信息
     *
     * @param $id
     * @return bool|Model
     * @user LMG
     * @date 2020/8/28
     */
    public function getUserById($id)
    {
        
        $id = intval($id);
        if ( ! $id) {
            return false;
        }
        
        return $this -> find($id);
    }
}