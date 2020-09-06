<?php
/**
 * PhpStorm
 * @user LMG
 * @date 2020/9/3
 */


namespace app\common\lib;


class Arr
{
    
    /**
     * 分类树、支持无限极分类
     * @param $data
     * @return array
     * @user LMG
     * @date 2020/9/3
     */
    public static function getTree($data)
    {
        
        $items = [];
        foreach ($data as $v) {
            $items[ $v[ 'category_id' ] ] = $v;
        }
        $tree = [];
        foreach ($items as $id => $item) {
            if (isset($items[ $item[ 'pid' ] ])) {
                $items[ $item[ 'pid' ] ][ 'list' ][] =& $items[ $id ];
            } else {
                $tree[] =& $items[ $id ];
            }
        }
        
        return $tree;
    }
    
    /**
     * 截取分类数据
     * @param $data
     * @param  int  $firstCount
     * @param  int  $secondCount
     * @param  int  $threeCount
     * @return array
     * @user LMG
     * @date 2020/9/3
     */
    public static function sliceTreeArr($data, $firstCount = 5, $secondCount = 3, $threeCount = 5)
    {
        
        $data = array_slice($data, 0, $firstCount);
        foreach ($data as $k => $v) {
            if ( ! empty($v[ 'list' ])) {
                $data[ $k ][ 'list' ] = array_slice($v[ 'list' ], 0, $secondCount);
                foreach ($data[ $k ][ 'list' ] as $kk => $vv) {
                    if ( ! empty($vv[ 'list' ])) {
                        $data[ $k ][ 'list' ][ $kk ][ 'list' ] = array_slice($vv[ 'list' ], 0, $threeCount);
                    }
                }
            }
        }
        return $data;
    }
    
    /**
     * 获取分类默认数据
     *
     * @param $num
     * @user LMG
     * @date 2020/9/6
     */
    public static function getPaginateDefaultData($num)
    {
        
        $result = [
            'total'        => 0,
            'per_page'     => $num,
            'current_page' => 1,
            'last_page'    => 0,
            'data'         => [],
        ];
        
        return $result;
    }
}