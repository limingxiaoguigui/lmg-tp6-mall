<?php
/**
 * PhpStorm
 * @user LMG
 * @date 2020/8/26
 */


namespace app\api\exception;


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
        if($e instanceof \think\Exception){
           return  show($e->getCode(),$e->getMessage());
        }
        if ($e instanceof \think\exception\HttpResponseException) {
            return parent::render($request, $e);
        }
        if (method_exists($e, 'getStatusCode')) {
            $httpStatus = $e -> getStatusCode();
        } else {
            $httpStatus = $this -> httpStatus;
        }
        
        // 其他错误交给系统处理
        return show(config('status.error'), $e -> getMessage(), [], $httpStatus);
    }
    
}
