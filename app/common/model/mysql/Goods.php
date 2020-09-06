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
}