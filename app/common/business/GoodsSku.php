<?php
/**
 * PhpStorm
 * @user LMG
 * @date 2020/9/6
 */


namespace app\common\business;

use app\common\model\mysql\GoodsSku as GoodsSkuModel;

class GoodsSku  extends BusBase
{
    public $model =null;
    public function __construct()
    {
        $this->model = new GoodsSkuModel();
    }
    
    /**
     * 属性新增
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
         $insertData=[];
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
            return $result->toArray();
        } catch (\Exception $e) {
            //todo 记录日志
            return false;
        }
        
        return true;
    }
}