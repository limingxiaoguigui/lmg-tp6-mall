<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/25
 */

use think\facade\Route;

//发送短信
Route ::rule('smscode', 'sms/code', 'post');
//登录
Route ::rule('login', 'login/index', 'post');
//获取用户信息
Route ::resource('user', 'User');
Route ::rule('lists', 'mall.lists/index');
Route ::rule('subcategory/:id', 'category/sub');
Route ::rule('detail/:id', 'mall.detail/index');