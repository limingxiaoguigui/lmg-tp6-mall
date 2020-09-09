<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/9/5
 */


namespace app\common\business;

use app\common\model\mysql\SpecsValue as SpecsValueModel;

class SpecsValue extends BusBase
{
    
    /**
     * 模型
     *
     * @var
     */
    public $model = null;
    
    /**
     * 构造
     */
    public function __construct()
    {
        
        $this -> model = new SpecsValueModel();
    }
    
    /**
     * 根据属性id获取数据
     *
     * @user LMG
     * @date 2020/9/5
     * @param $specsId
     * @return array
     */
    public function getBySpecsId($specsId)
    {
        
        try {
            $result = $this -> model -> getNormalBySpecsId($specsId, 'id,name');
        } catch (\Exception $e) {
            return [];
        }
        
        $result = $result -> toArray();
        
        return $result;
    }
    
    /**
     * 处理商品规格属性
     * @user LMG
     * @date 2020/9/9
     */
    public function dealGoodsSkus($gids,$flagValue){
        $specsValueKeys =array_keys($gids);
        foreach ($specsValueKeys as $specsValueKey){
            $specsValueKey =explode(',', $specsValueKey);
            foreach ($specsValueKey as $k=>$v){
                $new[$k][]=$v;
                $specsValueIds[]=$v;
            }
        }
        $specsValueIds=array_unique($specsValueIds);
        $specsValues=$this->getNormalInIds($specsValueIds);
        $flagValue=explode(',', $flagValue);
        foreach ($new as $key=>$newValue){
            $newValue =array_unique($newValue);
            $list =[];
            foreach ($newValue as $vv){
                $list[]=[
                    'id'=>$vv,
                    'name'=>$specsValues[$vv]['name'],
                    'flag'=>in_array($vv, $flagValue)
                ];
            }
            $result[$key]=[
                'name'=>$specsValues[$newValue[0]]["specs_name"],
                'list'=>$list
            ];
        }
        return $result;
    }
    
    /**
     * 规格属性
     * @param $ids
     * @user LMG
     * @date 2020/9/9
     */
    public function getNormalInIds($ids){
        if(!$ids){
            return [];
        }
        try {
            $result=$this->model->getNormalInIds($ids);
        }catch (\Exception $e){
            return [];
        }
        $result=$result->toArray();
        if(!$result){
            return [];
        }
        $specsNames=config('specs');
        $specsNamesArrs=array_column($specsNames, 'name','id');
        foreach ($result as $resultValue) {
            $res[ $resultValue[ 'id' ] ] = [
                'name'       => $resultValue[ 'name' ],
                'specs_name' => $specsNamesArrs[ $resultValue[ 'specs_id' ] ] ?? '',
            ];
        }
        return $res;
    }
    
}