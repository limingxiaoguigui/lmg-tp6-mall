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
use app\common\business\SpecsValue as SpecsValueBus;
use think\facade\Cache;

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
        
        $likeKeys = [];
        if ( ! empty($data)) {
            $likeKeys = array_keys($data);
        }
        try {
            $list = $this -> model -> getLists($likeKeys, $data, $num);
            $result = $list -> toArray();
        } catch (\Exception $e) {
            $result = \app\common\lib\Arr ::getPaginateDefaultData($num);
        }
        
        return $result;
    }
    
    /**
     * 获取大图推荐
     *
     * @user LMG
     * @date 2020/9/7
     */
    public function getRotationChart()
    {
        
        $data = [
            'is_index_recommend' => 1
        ];
        $field = 'sku_id as id,title,big_image as image';
        try {
            $result = $this -> model -> getNormalGoodsByCondition($data, $field);
            $result = $result -> toArray();
        } catch (\Exception $e) {
            return [];
        }
        
        return $result;
    }
    
    /**
     * 获取分类推荐商品
     *
     * @return mixed
     * @user LMG
     * @date 2020/9/8
     */
    public function categoryGoodsRecommend($categoryIds)
    {
        
        if ( ! $categoryIds) {
            return [];
        }
        // todo 获取栏目
        $result = [];
        foreach ($categoryIds as $key => $categoryId) {
            $result[ $key ][ 'categorys' ] = [];
        }
        foreach ($categoryIds as $key => $categoryId) {
            $result[ $key ][ 'goods' ] = $this -> getNormalGoodsFindInSetCategoryId($categoryId);
        }
        
        return $result;
    }
    
    /**
     * 获取某分类下的商品
     *
     * @param $categoryId
     * @user LMG
     * @date 2020/9/8
     */
    public function getNormalGoodsFindInSetCategoryId($categoryId)
    {
        
        $field = "sku_id as id ,title,price,recommend_image as image";
        try {
            $result = $this -> model -> getNormalGoodsFindInSetCategoryId($categoryId, $field);
            $result = $result -> toArray();
        } catch (\Exception $e) {
            $result = [];
        }
        
        return $result;
    }
    
    /**
     * 获取列表数据
     *
     * @user LMG
     * @date 2020/9/8
     * @param $data
     * @param  int  $num
     * @param $order
     * @return array
     */
    public function getNormalLists($data, $num = 5, $order)
    {
        
        try {
            $field = "sku_id as id, title, recommend_image as image,price";
            $list = $this -> model -> getNormalLists($data, $num, $field, $order);
            $res = $list -> toArray();
            $result = [
                "total_page_num" => isset($res[ 'last_page' ]) ? $res[ 'last_page' ] : 0,
                'count'          => isset($res[ 'total' ]) ? $res[ 'total' ] : 0,
                'page'           => isset($res[ 'current_page' ]) ? $res[ 'current_page' ] : 0,
                'page_size'      => $num,
                'list'           => isset($res[ 'data' ]) ? $res[ 'data' ] : [],
            ];
        } catch (\Exception $e) {
            $result = [];
        }
        
        return $result;
    }
    
    /**
     * 获取商品详情信息
     *
     * @user LMG
     * @date 2020/9/8
     */
    public function getGoodsDetailBySkuId($skuId)
    {
    
        $GoodsSkuBus = new GoodsSkuBus();
        $goodsSku = $GoodsSkuBus -> getNormalSkuAndGoods($skuId);
        if(!$goodsSku){
            return [];
        }
        if(empty($goodsSku['goods'])){
            return [];
        }
        $goods = $goodsSku[ 'goods' ];
        $skus = $GoodsSkuBus -> getSkusByGoodsId($goods[ 'id' ]);
        if(!$skus){
            return [];
        }
        $flagValue ='';
        foreach ($skus as $sv){
            if($sv['id']==$skuId){
                $flagValue=$sv['specs_value_ids'];
            }
        }
        $gids=array_column($skus, 'id','specs_value_ids');
        if ($goods[ 'goods_specs_type' ] == 1) {
            $sku = [];
        } else {
            $sku = (new SpecsValueBus()) -> dealGoodsSkus($gids, $flagValue);
        }
        $result =[
            'title'=>$goods['title'],
            'price'=>$goodsSku['price'],
            'sales_count'=>0,
            'stock'=>$goodsSku['stock'],
            'gids'=>$gids,
            'image'=>$goods['carousel_image'],
            'sku'=>$sku,
            'detail'=>[
                'd1'=>[
                    '商品编码'=>$goodsSku['id'],
                    '上架时间'=>$goods['create_time'],
                ],
                'd2'=>preg_replace('/(<img.+?src=")(.*?)/','$1'.request()->domain().'$2', $goods['description'])
            ]
        ];
        //记录数据到redis作为商品pv统计
        Cache::inc('mall_pv_'.$goods['id']);
        return $result;
    }
}