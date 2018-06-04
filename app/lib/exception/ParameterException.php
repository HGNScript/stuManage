<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/11
 * Time: 13:05
 */

namespace app\lib\exception;


class ParameterException extends BaseException {
    public $code = 404;
    public $msg = '参数错误';
    public $errorCode = 40000;
}