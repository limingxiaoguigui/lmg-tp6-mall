<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/9/7
 */


namespace app\api\controller;


use app\common\business\Goods as GoodsBus;
use app\common\lib\Show;

class Index extends ApiBase
{
    
    /**
     * 获取大图推荐
     *
     * @user LMG
     * @date 2020/9/7
     */
    public function getRotationChart()
    {
        
        $result = (new GoodsBus()) -> getRotationChart();
        
        return Show ::success($result);
    }
    
    /**
     * 获取分类推荐商品
     * @return mixed
     * @user LMG
     * @date 2020/9/8
     */
    public function categoryGoodsRecommend()
    {
        
        $categoryIds = [
            4,
            6
        ];
        $result = (new GoodsBus()) -> categoryGoodsRecommend($categoryIds);
        
        return Show ::success($result);
    }
}