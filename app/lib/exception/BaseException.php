<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/10
 * Time: 21:53
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception {
//    HTTP 状态吗 404, 200
    public $code = 400;

//    错误的具体信息
    public $msg = '参数错误';

//    自定义的错误码
    public $errorCode = 10000;

    public function __construct($params = []) {
        if (!is_array($params)) {
//            throw new Exception('参数必须是数组');
            return;
        }
        //array_key_exists 检查键名是否存在于数组中
        if (array_key_exists('code',$params)) {
            $this->code = $params['code'];
        }
        if (array_key_exists('msg',$params)) {
            $this->msg = $params['msg'];
        }
        if (array_key_exists('errorCode',$params)) {
            $this->errorCode = $params['errorCode'];
        }
    }
}