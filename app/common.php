<?php
// 应用公共文件

/**
 * 通用化API数据格式化输出
 * @param $status
 * @param  string  $message
 * @param  array  $data
 * @param  int  $httpStatus
 * @return mixed
 * @user LMG
 * @date 2020/8/13
 */
function show($status, $message = 'error', $data = [], $httpStatus = 200)
{
    
    $result = [
        'status' => $status, 'message' => $message, "result" => $data
    ];
    
    return json($result, $httpStatus);
}