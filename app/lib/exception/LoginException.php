<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/10
 * Time: 22:09
 */

namespace app\lib\exception;


class LoginException extends BaseException {
    public $code = 404;
    public $msg = '账号或密码错误';
    public $errorCode = 40000;
}