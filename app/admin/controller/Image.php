<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/9/5
 */


namespace app\admin\controller;


use think\facade\Filesystem;

class Image extends AdminBase
{
    
    /**
     * 上传图片
     * @return mixed
     * @user LMG
     * @date 2020/9/5
     */
    public function upload()
    {
        
        if ( ! $this -> request -> isPost()) {
            return show(config('status.error', '请求不合法！'));
        }
        $file = $this -> request -> file('file');
        //todo 上传类型需要判断 文件大小限制 长宽限制
        $filename = Filesystem ::disk('public')
                               -> putFile('upload/image', $file);
        if ( ! $filename) {
            return show(config('status.error'), '上传图片失败');
        }
        //图片地址
        $imageUrl[ 'image' ] = '/upload/'.$filename;
        
        return show(config('status.success'), '图片上传成功！', $imageUrl);
    }
    
}