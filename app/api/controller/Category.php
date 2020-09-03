<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/9/3
 */


namespace app\api\controller;

use  app\common\business\Category as CategoryBus;
use  app\common\lib\Arr;

class Category extends ApiBase
{
    
    /**
     * 获取分类数据
     *
     * @return mixed
     * @user LMG
     * @date 2020/9/3
     */
    public function index()
    {
        
        //获取所有分类的内容
        try {
            $categoryBusObj = new CategoryBus();
            $categories = $categoryBusObj -> getNormalAllCategories();
        } catch (\Exception $e) {
            // todo 日志记录
            return show(config('status.success'), '内部异常');
        }
        if ( ! $categories) {
            return show(config('status.success'), '数据为空！');
        }
        $result = Arr ::getTree($categories);
        $result = Arr ::sliceTreeArr($result);
        
        return show(config('status.success'), 'ok', $result);
    }
    
}