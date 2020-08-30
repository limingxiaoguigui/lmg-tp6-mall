<?php
/**
 * 该文件主要是存放业务状态码的相关配置
 *
 * @user LMG
 * @date 2020/8/13
 */

return [
    'success'              => 1,
    'error'                => 0,
    'not_login'            => -1,
    'user_is_register'     => -2,
    'action_not_found'     => -3,
    'controller_not_found' => -4,
    //mysql相关的配置
    'mysql'=>[
        'table_normal'=>1,//正常
        'table_pedding'=>0,//待审
        'table_delete'=>99,//删除
    ]
];