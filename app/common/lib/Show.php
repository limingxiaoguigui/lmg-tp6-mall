<?php
/**
 * PhpStorm
 *
 * @user LMG
 * @date 2020/9/7
 */


namespace app\common\lib;


class Show
{
    
    /**
     * 成功返回
     *
     * @param  array  $data
     * @param  string  $message
     * @return mixed
     * @user LMG
     * @date 2020/9/7
     */
    public static function success($data = [], $message = 'OK')
    {
        
        $result = [
            'status'  => config('status.success'),
            'message' => $message,
            'result'  => $data
        ];
        
        return json($result);
    }
    
    /**
     * 返回失败
     *
     * @param  array  $data
     * @param  string  $message
     * @param  int  $status
     * @return mixed
     * @user LMG
     * @date 2020/9/7
     */
    public static function error($data = [], $message = 'error', $status = 0)
    {
        
        $result = [
            'status'  => $status,
            'message' => $message,
            'result'  => $data
        ];
        
        return json($result);
    }
}