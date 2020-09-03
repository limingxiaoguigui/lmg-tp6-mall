<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/30
 */


namespace app\common\business;

use app\common\model\mysql\Category as CategoryModel;

class Category
{
    
    public $model = null;
    
    public function __construct()
    {
        
        $this -> model = new CategoryModel();
    }
    
    /**
     * 新增
     *
     * @param $data
     * @return mixed
     * @user LMG
     * @date 2020/8/30
     */
    public function add($data)
    {
        
        $data[ 'status' ] = config('status.mysql.table_normal');
        $name = $data[ 'name' ];
        //根据用户名启用数据库中查询是否存在这条记录
        try {
            $this -> model -> save($data);
        } catch (\Exception $e) {
            throw new \think\Exception('服务内部异常');
        }
        
        return $this -> model -> id;
    }
    
    /**
     * 获取分类数据
     *
     * @return array
     * @user LMG
     * @date 2020/8/30
     */
    public function getNormalCategories()
    {
        
        $field = 'id,name,pid';
        $categories = $this -> model -> getNormalCategories($field);
        if (empty($categories)) {
            $categories = [];
        } else {
            $categories = $categories -> toArray();
        }
        
        return $categories;
    }
     /**
     * 获取分类数据
     *
     * @return array
     * @user LMG
     * @date 2020/8/30
     */
    public function getNormalAllCategories()
    {
        
        $field = 'id as category_id,name,pid';
        $categories = $this -> model -> getNormalCategories($field);
        if (empty($categories)) {
            $categories = [];
        } else {
            $categories = $categories -> toArray();
        }
        
        return $categories;
    }
    
    /**
     * 获取列表数据
     *
     * @user LMG
     * @date 2020/8/30
     */
    public function getList($data, $num)
    {
        
        $list = $this -> model -> getList($data, $num);
        if ( ! $list) {
            return [];
        }
        $result = $list -> toArray();
        $result[ 'render' ] = $list -> render();
        // 第一步拿到列表中的id,第二步：in mysql 求count 第三步填充到列表中
        $pids = array_column($result[ 'data' ], 'id');
        if ($pids) {
            $idCountResult = $this -> model -> getChildCountInPids(['pid' => $pids]);
            $idCountResult = $idCountResult -> toArray();
            $idCounts =[];
            foreach ($idCountResult as $countResult){
                $idCounts[$countResult['pid']]=$countResult['count'];
            }
        }
        if ($result[ 'data' ]) {
            foreach ($result[ 'data' ] as $k => $value) {
                $result[ 'data' ][ $k ][ 'childCount' ] = isset($idCounts[ $value[ 'id' ] ]) ? $idCounts[ $value[ 'id' ] ] :0;
            }
        }
        return $result;
    }
    
    /**
     * 通过Id获取数据
     * @param $id
     * @return array
     * @user LMG
     * @date 2020/9/1
     */
    public function getById($id)
    {
        
        $result = $this -> model -> find($id);
        if (  empty($result)) {
            return [];
        }
        $result = $result -> toArray();
        
        return $result;
    }
    
    /**
     * 排序
     * @param $id
     * @param $listorder
     * @return bool
     * @user LMG
     * @date 2020/9/1
     */
    public function listorder($id, $listorder)
    {
        
        //查询id这条数据是否存在
        $res = $this -> getById($id);
        if ( ! $res) {
            throw new \think\Exception('不存在该条记录！');
        }
        $data = [
            'listorder' => $listorder
        ];
        try {
            $res = $this -> model -> updateById($id, $data);
        } catch (\Exception $e) {
            return false;
        }
        
        return $res;
    }
    
    /**
     * 改变状态
     * @param $id
     * @param $status
     * @return bool
     * @user LMG
     * @date 2020/9/2
     */
    public function status($id,$status){
        //判断是否存在
        $res=$this->getById($id);
        if(!$res){
            throw new \think\Exception('不存在该条记录!');
        }
        if($res['status']==$status){
            throw new \think\Exception('状态修改前和修改后一样没有任何意义！');
        }
        $data = [
            'status'=>intval($status)
        ];
        try {
            $res=$this->model->updateById($id, $data);
        }catch (\Exception $e){
            // todo 写入日志
            return false;
        }
        return $res;
    }
    
}