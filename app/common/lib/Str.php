<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/28
 */


namespace app\common\lib;


class Str
{
    
    /**
     * 生成一个token
     *
     * @param $string
     * @return string
     * @user LMG
     * @date 2020/8/28
     */
    public static function getLoginToken($string)
    {
        
        //生成token
        $str = md5(uniqid(md5(microtime(true)), true));//生成一个不重复的字符串
        $token = sha1($str.$string);//加密
        
        return $token;
    }
}