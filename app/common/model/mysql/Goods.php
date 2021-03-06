<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/9/6
 */


namespace app\common\model\mysql;

class Goods extends BaseModel
{
    
    /**
     * 按标题搜索
     *
     * @param $query
     * @param $value
     * @user LMG
     * @date 2020/9/6
     */
    public function searchTitleArr($query, $value)
    {
        
        $query -> where('title', 'like', '%'.$value.'%');
    }
    
    /**
     * 时间搜索器
     *
     * @param $query
     * @param $value
     * @user LMG
     * @date 2020/9/6
     */
    public function searchCreateTimeArr($query, $value)
    {
        
        $query -> whereBeTweenTime('create_time', $value[ 0 ], $value[ 1 ]);
    }
    
    /**
     * 获取列表数据
     *
     * @param $data
     * @param  int  $num
     * @user LMG
     * @date 2020/9/6
     */
    public function getLists($likeKeys, $data, $num = 10)
    {
        
        $order = [
            "listorder" => 'desc',
            "id"        => "desc"
        ];
        if ( ! empty($likeKeys)) {
            //搜索器
            $res = $this -> withSearch($likeKeys, $data);
        } else {
            $res = $this;
        }
        $list = $res -> whereIn('status', [0, 1])
                     -> order($order)
                     -> paginate($num);
        
        return $list;
    }
    
    /**
     * 获取大图推荐
     *
     * @user LMG
     * @date 2020/9/7
     */
    public function getNormalGoodsByCondition($where, $field, $limit = 5)
    {
        
        $order = [
            "listorder" => 'desc',
            "id"        => "desc"
        ];
        $where[ 'status' ] = config('status.success');
        $result = $this -> where($where)
                        -> order($order)
                        -> field($field)
                        -> limit($limit)
                        -> select();
        
        return $result;
    }
    
    /**
     * 获取图片
     *
     * @param $value
     * @return string
     * @user LMG
     * @date 2020/9/7
     */
    public function getImageAttr($value)
    {
        
        return request() -> domain().$value;
    }
    
    /**
     * 轮播图
     *
     * @param $value
     * @user LMG
     * @date 2020/9/8
     */
    public function getCarouselImageAttr($value)
    {
        
        if ( ! empty($value)) {
            $value = explode(',', $value);
            $value = array_map(function ($v){
                
                return request() -> domain().$v;
            }, $value);
        }
        
        return $value;
    }
    
    /**
     * 获取某分类下的商品
     *
     * @param $categoryId
     * @user LMG
     * @date 2020/9/8
     */
    public function getNormalGoodsFindInSetCategoryId($categoryId, $field)
    {
        
        $order = [
            "listorder" => 'desc',
            "id"        => "desc"
        ];
        $result = $this -> whereFindInSet('category_path_id', $categoryId)
                        -> where('status', '=', config('status.success'))
                        -> order($order)
                        -> field($field)
                        -> limit(10)
                        -> select();
        
        return $result;
    }
    
    /**
     * 获取商品的列表数据
     *
     * @param $data
     * @param  int  $num
     * @param  bool  $field
     * @param $order
     * @user LMG
     * @date 2020/9/8
     */
    public function getNormalLists($data, $num = 10, $field = true, $order)
    {
        
        $res = $this;
        if (isset($data[ 'category_path_id' ])) {
            $res = $this -> whereFindInSet('category_path_id', $data[ 'category_path_id' ]);
        }
        $list = $res -> where('status', '=', config('status.success'))
                     -> order($order)
                     -> field($field)
                     -> paginate($num);
        
        return $list;
    }
}