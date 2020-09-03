<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/30
 */


namespace app\admin\controller;


use app\common\business\Category as CategoryBus;
use app\common\lib\Status as StatusLib;

class Category extends AdminBase
{
    
    /**
     * 列表
     *
     * @user LMG
     * @date 2020/8/30
     */
    public function index()
    {
        
        $pid = input('param.pid', 0, 'intval');
        $data = [
            'pid' => $pid
        ];
        try {
            $categories = (new CategoryBus()) -> getList($data, 5);
        } catch (\Exception $e) {
            $categories = [];
        }
        
        return view('', ['categories' => $categories,'pid'=>$pid]);
    }
    
    /**
     * 添加分类页面
     *
     * @user LMG
     * @date 2020/8/30
     */
    public function add()
    {
        
        try {
            $categories = (new CategoryBus()) -> getNormalCategories();
        } catch (\Exception $e) {
            $categories = [];
        }
        
        return view('', ['categories' => json_encode($categories)]);
    }
    
    /**
     * 新增逻辑
     *
     * @user LMG
     * @date 2020/8/30
     */
    public function save()
    {
        
        $pid = input('param.pid', 0, 'intval');
        $name = input('param.name', 0, 'trim');
        //参数校验
        $data = [
            'pid'  => $pid,
            'name' => $name
        ];
        $validate = new \app\admin\validate\Category();
        if ( ! $validate -> check($data)) {
            return show(config('status.error'), $validate -> getError());
        }
        try {
            $result = (new CategoryBus()) -> add($data);
        } catch (\Exception $e) {
            return show(config('status.error'), $e -> getMessage());
        }
        if ($result) {
            return show(config('status.success'), '新增成功！');
        }
        
        return show(config('status.error'), '新增失败');
    }
    
    /**
     * 分类排序
     *
     * @return mixed
     * @user LMG
     * @date 2020/9/1
     */
    public function listorder()
    {
        
        $id = input('param.id', 0, 'intval');
        $listorder = input('param.listorder', 0, 'intval');
        if ( ! $id) {
            return show(config('status.error'), '参数错误！');
        }
        try {
            $res = (new CategoryBus()) -> listorder($id, $listorder);
        } catch (\Exception $e) {
            return show(config('status.error'), $e -> getMessage());
        }
        if ($res) {
            return show(config('status.success'), '排序成功！');
        } else {
            return show(config('status.error'), '排序失败！');
        }
    }
    
    /**
     * 改变状态
     *
     * @return mixed
     * @user LMG
     * @date 2020/9/2
     */
    public function status()
    {
        
        $status = input('param.status', 0, 'intval');
        $id = input('param.id', 0, 'intval');
        //todo 验证逻辑
        if ( ! $id || ! in_array($status, StatusLib ::getTableStatus())) {
            return show(config('status.error'), '参数错误！');
        }
        try {
            $res = (new CategoryBus()) -> status($id, $status);
        } catch (\Exception $e) {
            return show(config('status.error'), $e -> getMessage());
        }
        if ($res) {
            return show(config('status.success'), '转态更新成功！');
        } else {
            return show(config('status.error'), '状态更新失败！');
        }
    }
}