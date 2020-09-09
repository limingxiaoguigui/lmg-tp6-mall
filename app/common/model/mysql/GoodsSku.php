<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/9/6
 */


namespace app\common\model\mysql;


use think\Model;

class GoodsSku extends Model
{
    
    /**
     * 一对一查询
     *
     * @user LMG
     * @date 2020/9/8
     */
    public function goods()
    {
        
        return $this -> hasOne(Goods::class, 'id', 'goods_id');
    }
    
    /**
     * 获取sku数据
     *
     * @user LMG
     * @date 2020/9/8
     */
    public function getNormalByGoodsId($goodsId = 0)
    {
        
        $where = [
            "goods_id" => $goodsId,
            'status'   => config("status.mysql.table_normal")
        ];
        
        return $this -> where($where)
                     -> select();
    }
}