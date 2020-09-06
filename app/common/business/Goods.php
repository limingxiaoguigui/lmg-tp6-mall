<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/9/6
 */


namespace app\common\business;

use app\common\model\mysql\Goods as GoodsModel;
use app\common\business\GoodsSku as GoodsSkuBus;

class Goods extends BusBase
{
    
    public $model = null;
    
    public function __construct()
    {
        
        $this -> model = new GoodsModel();
    }
    
    /**
     * 新增商品
     *
     * @param $data
     * @return bool|int|mixed
     * @user LMG
     * @date 2020/9/6
     */
    public function insertData($data)
    {
        
        //开启一个事物
        $this -> model -> startTrans();
        try {
            $goodsId = $this -> add($data);
            if ( ! $goodsId) {
                return $goodsId;
            }
            // 执行数据插入到sku表中
            //如果是统一规格
            if ($data[ 'goods_specs_type' ] == 1) {
                $goodsSkuData = [
                    'goods_id' => $goodsId
                ];
                
                //todo
                return true;
            } elseif ($data[ 'goods_specs_type' ] == 2) {
                $goodsSkuBusObj = new GoodsSkuBus();
                $data[ 'goods_id' ] = $goodsId;
                $res = $goodsSkuBusObj -> saveAll($data);
                //如果不为空
                if ( ! empty($res)) {
                    //总库存
                    $stock = array_sum(array_column($res, 'stock'));
                    $goodsUpdateData = [
                        'price'      => $res[ 0 ][ 'price' ],
                        'cost_price' => $res[ 0 ][ 'cost_price' ],
                        'stock'      => $stock,
                        'sku_id'     => $res[ 0 ][ 'id' ]
                    ];
                    //执行完毕后更新主表数据
                    $goodsRes = $this -> model -> updateById($goodsId, $goodsUpdateData);
                    if ( ! $goodsRes) {
                        throw new \think\Exception('insertData:goods主表更新失败');
                    }
                } else {
                    throw  new \think\Exception('sku表新增失败！');
                }
            }
            //事物提交
            $this -> model -> commit();
            
            return true;
        } catch (\Exception $e) {
            //事物回滚
            $this -> model -> rollback();
            
            return false;
        }
        
        return true;
    }
    
    /**
     * 获取分页数据
     *
     * @param $data
     * @param  int  $num
     * @user LMG
     * @date 2020/9/6
     */
    public function getLists($data, $num = 5)
    {
        $likeKeys =[];
        if(!empty($data)){
            $likeKeys=array_keys($data);
        }
        try {
            $list = $this -> model -> getLists($likeKeys,$data, $num);
            $result = $list -> toArray();
        } catch (\Exception $e) {
           $result =\app\common\lib\Arr::getPaginateDefaultData($num);
        }
        
        return $result;
    }
}