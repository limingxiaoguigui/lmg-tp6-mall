<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/8/15
 */

namespace app\admin\exception;

use think\exception\Handle;
use think\Response;
use Throwable;

class  Http extends Handle
{
    
    public $httpStatus = 500;
    
    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param  \think\Request  $request
     * @param  Throwable  $e
     * @return Response
     */
    public function render($request, Throwable $e) : Response
    {
        
        if (method_exists($e, 'getStatusCode')) {
            $httpStatus = $e -> getStatusCode();
        } else {
            $httpStatus = $this -> httpStatus;
        }
        
        // 其他错误交给系统处理
        return show(config('status.error'), $e -> getMessage(), [], $httpStatus);
    }
    
}
