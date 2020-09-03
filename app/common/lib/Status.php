<?php
/**
 * PhpStorm
 * @user LMG
 * @date 2020/9/2
 */


namespace app\common\lib;


class Status
{
    
    /**
     * 获取表字段状态的类库
     * @return array
     * @user LMG
     * @date 2020/9/2
     */
    public static function getTableStatus()
    {
        
        $mysqlStatus = config('status.mysql');
        
        return array_values($mysqlStatus);
    }
}