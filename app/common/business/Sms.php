<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/25
 */

declare(strict_types = 1);

namespace app\common\business;

use app\common\lib\Num;
use app\common\lib\sms\AliSms;
use app\common\lib\ClassArr;


class Sms
{
    
    /**
     * 发送验证码
     *
     * @param  string  $phoneNumber
     * @param  int  $len
     * @param  string  $type
     * @return bool
     * @user LMG
     * @date 2020/8/26
     */
    public static function sendCode(string $phoneNumber,int $len,string $type='ali') : bool
    {
    
        //验证码
        $code = Num ::getCode($len);
        $classStats = ClassArr ::smsClassStat();
        $classObj = ClassArr ::initClass($type, $classStats);
        $sms = $classObj ::sendCode($phoneNumber, $code);
        if($sms){
            //将验证码存至redis中
            cache(config('redis.code_pre').$phoneNumber,$code,config('redis.code_expire'));
        
        }
        return $sms;
    }
}