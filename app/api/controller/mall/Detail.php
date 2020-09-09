<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/9/8
 */


namespace app\api\controller\mall;


use app\api\controller\ApiBase;
use app\common\business\Goods as GoodsBus;
use app\common\lib\Show;

class Detail extends ApiBase
{
    
    public function index()
    {
        
        $id = input('param.id', 0, 'intval');
        if ( ! $id) {
            return Show ::error();
        }
        $result = (new GoodsBus()) -> getGoodsDetailBySkuId($id);
        if ( ! $result) {
            return Show ::error();
        }
        
        return Show ::success($result);
    }
}