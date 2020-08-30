<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/23
 */


namespace app\common\model\mysql;

use think\Model;

class AdminUser extends Model
{
    
    /**
     * 通过用户名获取用户信息
     *
     * @param $username
     * @user LMG
     * @date 2020/8/23
     */
    public function getAdminUserByUsername($username)
    {
        
        if (empty($username)) {
            return false;
        }
        $where = [
            "username" => trim($username),
        ];
        $result = $this -> where($where)
                        -> find();
        
        return $result;
    }
    
    /**
     * 根据id更新数据
     *
     * @param $id
     * @param $data
     * @user LMG
     * @date 2020/8/23
     */
    public function updateById($id, $data)
    {
        
        $id = intval($id);
        if (empty($id) || empty($data) || !is_array($data)) {
            return false;
        }
        $where = [
            'id' => $id,
        ];
        
        return $this -> where($where)
                     -> save($data);
    }
    
}