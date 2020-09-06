<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/9/4
 */


namespace app\admin\controller;

use app\common\business\Goods as GoodsBus;
use think\console\command\make\Model;
use think\response\View;

class Goods extends AdminBase
{
    
    /**
     * 列表页面
     *
     * @return View
     * @user LMG
     * @date 2020/9/4
     */
    public function index()
    {
        
        $data = [];
        $title=input('param.title','','trim');
        $time=input('param.time','','trim');
        if(!empty($title)){
            $data['title']=$title;
        }
        if(!empty($time)){
            $data['create_time']=explode('-', $time);
        }
        $goods = (new GoodsBus()) -> getLists($data, 5);
        
        return view('', ['goods' => $goods]);
    }
    
    /**
     * 新增页面
     *
     * @return View
     * @user LMG
     * @date 2020/9/4
     */
    public function add()
    {
        
        return view();
    }
    
    /**
     * 商品新增成功
     *
     * @return mixed
     * @user LMG
     * @date 2020/9/6
     */
    public function save()
    {
        
        if ( ! $this -> request -> isPost()) {
            return show(config('status.error'), '参数不合法！');
        }
        //todo 验证数据
        $data = input('param.');
        $check = $this -> request -> checkToken('__token__');
        if ( ! $check) {
            return show(config('status.error'), '非法请求！');
        }
        //数据处理
        $data[ 'category_path_id' ] = $data[ 'category_id' ];
        $result = explode(',', $data[ 'category_path_id' ]);
        $data[ 'category_id' ] = end($result);
        $res = (new GoodsBus()) -> insertData($data);
        if ( ! $res) {
            return show(config('status.error'), '商品新增失败！');
        }
        
        return show(config('status.success'), '商品新增成功！');
    }
}