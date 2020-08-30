<?php
/**
 * PhpStorm
 * @user LMG
 * @date 2020/8/26
 */

declare(strict_types=1);
namespace app\common\lib\sms;


interface SmsBase
{
    public static function sendCode(string $phone,int $code);
}