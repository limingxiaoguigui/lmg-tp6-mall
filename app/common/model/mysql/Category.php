<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/30
 */


namespace app\common\model\mysql;

use think\Collection;
use think\Model;

class Category extends Model
{
    
    /**
     * 自动写入时间
     *
     * @var bool
     */
    protected $autoWriteTimestamp = true;
    
    /**
     * 获取分类数据
     *
     * @param $field
     * @return Collection
     * @user LMG
     * @date 2020/8/30
     */
    public function getNormalCategories($field)
    {
        
        $where = [
            "status" => config('status.mysql.table_normal')
        ];
        $order = [
            "listorder" => 'desc',
            "id"        => "desc"
        ];
        
        return $this -> where($where)
                     -> field($field)
                     -> order($order)
                     -> select();
    }
    
    /**
     * 获取列表数据
     *
     * @user LMG
     * @date 2020/8/30
     */
    public function getList($where, $num = 10)
    {
        
        $order = [
            'listorder' => 'desc',
            'id'        => 'desc'
        ];
        
        return $this -> where('status', '<>', config('status.mysql.table_delete'))
                     -> where($where)
                     -> order($order)
                     -> paginate($num);
    }
    
    /**
     * 通过id更新数据
     *
     * @param $id
     * @param $data
     * @return bool
     * @user LMG
     * @date 2020/9/1
     */
    public function updateById($id, $data)
    {
        
        $data[ 'update_time' ] = time();
        
        return $this -> where(['id' => $id])
                     -> save($data);
    }
    
    /**
     * 获取子栏目个数
     *
     * @param $condition
     * @return mixed
     * @user LMG
     * @date 2020/9/2
     */
    public function getChildCountInPids($condition)
    {
        
        $where[] = ['pid', 'in', $condition[ 'pid' ]];
        $where[] = ['status', '<>', config('status.mysql.table_delete')];
        $res = $this -> where($where)
                     -> field(["pid", "count(*) as count"])
                     -> group('pid')
                     -> select();
        
        return $res;
    }
    
    /**
     * 通过父分类获取子分类
     *
     * @param  int  $pid
     * @param $field
     * @user LMG
     * @date 2020/9/5
     */
    public function getNormalByPid($pid = 0, $field)
    {
        
        $where = [
            'pid'    => $pid,
            'status' => config('status.mysql.table_normal')
        ];
        $order = [
            'listorder' => 'desc',
            'id'        => 'desc'
        ];
        $res = $this -> where($where)
                     -> field($field)
                     -> order($order)
                     -> select();
        
        return $res;
    }
}