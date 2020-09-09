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
    
    /**
     * 分类列表
     * @return mixed
     * @user LMG
     * @date 2020/9/8
     */
    public function search(){
        $result =[
            "name"=>'我是一级分类',
            "focus_ids"=>[1,11],
            "list" => [
                [
                    ['id' => 1, "name" => '二级分类1'],
                    ['id' => 2, "name" => '二级分类2'],
                    ['id' => 3, "name" => '二级分类3'],
                    ['id' => 4, "name" => '二级分类4'],
                    ['id' => 5, "name" => '二级分类5'],
                ],
                [
                    ['id' => 11, "name" => '二级分类11'],
                    ['id' => 12, "name" => '二级分类12'],
                    ['id' => 13, "name" => '二级分类13'],
                    ['id' => 14, "name" => '二级分类14'],
                    ['id' => 15, "name" => '二级分类15'],
                ]
            ]
        ];
        return show(config("status.success"),"ok",$result);
    }
    
    /**
     * 获取子分类
     * @return mixed
     * @user LMG
     * @date 2020/9/8
     */
    public function sub()
    {
        
        $result = [
            ['id' => 21, "name" => '三级分类1'],
            ['id' => 22, "name" => '三级分类2'],
            ['id' => 23, "name" => '三级分类3'],
            ['id' => 24, "name" => '三级分类4'],
            ['id' => 25, "name" => '三级分类5'],
        ];
        
        return show(config("status.success"), "ok", $result);
    }
    
}