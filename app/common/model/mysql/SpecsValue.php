<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/9/5
 */


namespace app\common\model\mysql;


use think\Model;

class SpecsValue extends Model
{
    
    /**
     * 自动写入时间
     *
     * @var bool
     */
    protected $autoWriteTimestamp = true;
    
    /**
     * 规格属性数据
     *
     * @param $specsId
     * @param  string  $field
     * @user LMG
     * @date 2020/9/5
     */
    public function getNormalBySpecsId($specsId, $field = '*')
    {
        
        $where = [
            'specs_id' => $specsId,
            'status'   => config('status.mysql.table_normal')
        ];
        
        $res = $this -> where($where)
                     -> field($field)
                     -> select();
        
        return $res;
    }
    
}