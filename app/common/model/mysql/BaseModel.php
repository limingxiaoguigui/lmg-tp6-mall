<?php
/**
 * PhpStorm
 * @user LMG
 * @date 2020/9/6
 */


namespace app\common\model\mysql;

use think\Model;
class BaseModel extends Model
{
    protected $autoWriteTimestamp =true;
    
    /**
     * 通过主键更新数据
     *
     * @param $id
     * @param $data
     * @return bool
     * @user LMG
     * @date 2020/9/6
     */
    public function updateById($id, $data)
    {
        
        $data[ 'update_time' ] = time();
        
        return $this -> where(['id' => $id])
                     -> save($data);
    }
}