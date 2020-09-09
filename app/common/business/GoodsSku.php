<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/9/6
 */


namespace app\common\business;

use app\common\model\mysql\GoodsSku as GoodsSkuModel;

class GoodsSku extends BusBase
{
    
    public $model = null;
    
    public function __construct()
    {
        
        $this -> model = new GoodsSkuModel();
    }
    
    /**
     * 属性新增
     *
     * @param $data
     * @return bool
     * @user LMG
     * @date 2020/9/6
     */
    public function saveAll($data)
    {
        
        if ( ! $data[ 'skus' ]) {
            return false;
        }
        $insertData = [];
        foreach ($data[ 'skus' ] as $value) {
            $insertData[] = [
                'goods_id'        => $data[ 'goods_id' ],
                'specs_value_ids' => $value[ 'propvalnames' ][ 'propvalids' ],
                'price'           => $value[ 'propvalnames' ][ 'skuSellPrice' ],
                'cost_price'      => $value[ 'propvalnames' ][ 'skuMarketPrice' ],
                'stock'           => $value[ 'propvalnames' ][ 'skuStock' ]
            ];
        }
        try {
            $result = $this -> model -> saveAll($insertData);
            
            return $result -> toArray();
        } catch (\Exception $e) {
            //todo 记录日志
            return false;
        }
        
        return true;
    }
    
    /**
     * 获取sku关联数据
     *
     * @user LMG
     * @date 2020/9/8
     */
    public function getNormalSkuAndGoods($id)
    {
        
        try {
            $result = $this -> model -> with('goods')
                                     -> find($id);
        } catch (\Exception $e) {
            return [];
        }
        if ( ! $result) {
            return [];
        }
        $result = $result -> toArray();
        if ($result[ 'status' ] != config('status.mysql.table_normal')) {
            return [];
        }
  
        return $result;
    }
    
    /**
     * 获取sku数据
     *
     * @param  int  $goodsId
     * @user LMG
     * @date 2020/9/8
     */
    public function getSkusByGoodsId($goodsId = 0)
    {
        
        if ( ! $goodsId) {
            return [];
        }
        try {
            $skus = $this -> model -> getNormalByGoodsId($goodsId);
            $skus = $skus -> toArray();
        } catch (\Exception $e) {
            $skus = [];
        }
        
        return $skus;
    }
}