<?php
/**
 * PhpStorm
 * @user LMG
 * @date 2020/9/5
 */


namespace app\common\business;


class BusBase
{
     /**
     * 新增规格属性值
     *
     * @param $data
     * @return bool|mixed
     * @user LMG
     * @date 2020/9/5
     */
    public function add($data)
    {
        
        $data[ 'status' ] = config('status.mysql.table_normal');
        //todo 根据name查询$name是否存在，
        try {
            $this -> model -> save($data);
        } catch (\Exception $e) {
            // todo 记录日志
            return 0;
        }
        
        return $this -> model -> id;
    }
}