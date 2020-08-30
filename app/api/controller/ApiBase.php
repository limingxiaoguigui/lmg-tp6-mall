<?php
/**
 * PhpStorm
 * @user LMG
 * @date 2020/8/28
 */


namespace app\api\controller;


use app\BaseController;
use think\exception\HttpResponseException;

/**
 * 不需要登录的继承
 * @package app\api\controller
 */
class ApiBase extends BaseController
{
    
    /**
     * 初始化
     * @user LMG
     * @date 2020/8/28
     */
    public function initialize()
    {
    
        parent ::initialize(); // TODO: Change the autogenerated stub
    }
    
    /**
     * 发送消息
     * @param  mixed  ...$args
     * @user LMG
     * @date 2020/8/28
     */
    public function showData(...$args)
    {
        
        throw new  HttpResponseException(show(...$args));
    }
}