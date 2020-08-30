<?php
/**
 * PhpStorm
 * @user LMG
 * @date 2020/8/27
 */


namespace app\common\lib;


class ClassArr
{
    
    /**
     * 类库映射
     * @return string[]
     * @user LMG
     * @date 2020/8/27
     */
    public static function smsClassStat()
    {
        
        return [
            'ali'   => "app\common\lib\sms\AliSms",
            'baidu' => 'app\common\lib\sms\BaiduSms',
        ];
    }
    
    /**
     * 上传类库
     * @user LMG
     * @date 2020/8/27
     */
    public static function uploadClassStat(){
    return [
        'text'=>'xxx',
        'image'=>'xxx',
    ];
    }
    public static function initClass($type,$class,$params=[],$needInstance =false){
        //如果我们工厂莫斯调用的方法是静态的，直接返回类库AliSms
        //如果不是静态的，返回对象;
        if(!array_key_exists($type, $class)){
            return false;
        }
        $className=$class[$type];
        // new ReflectionClass('A')   建立A反射类
        // -> newInstanceArgs($args)  实例化A对象
        return $needInstance == true ?(new \ReflectionClass($className))->newInstanceArgs($params):$className;
    }
}