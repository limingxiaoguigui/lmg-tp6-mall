<?php
/**
 * PhpStorm
 * @user LMG
 * @date 2020/8/30
 */


namespace app\admin\validate;


use think\Validate;

class Category extends Validate
{
    
    /**
     * 规则
     * @var string[]
     */
    protected $rule = [
        'name'=>'require',
        'pid'=>'require',
    ];
    
    /**
     * 消息
     * @var string[]
     */
    protected $message = [
        'name'=>'分类名称必须',
        'pid'=>'父类ID必须'
    ];
}