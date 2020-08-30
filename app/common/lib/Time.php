<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/28
 */


namespace app\common\lib;


class Time
{
    
    /**
     * 过期时间
     * @param  int  $type
     * @return float|int
     * @user LMG
     * @date 2020/8/28
     */
    public static function userLoginExpiresTime($type = 2)
    {
        
        $type = ! in_array($type, [1, 2]) ? 2 : $type;
        if ($type == 1) {
            $day = $type * 7;
        } elseif ($type == 2) {
            $day = $type * 30;
        }
        
        return $day * 24 * 3600;
    }
}