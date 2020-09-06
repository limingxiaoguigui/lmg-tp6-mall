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
    
}