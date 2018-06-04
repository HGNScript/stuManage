<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/11
 * Time: 12:44
 */

namespace app\student\validate;



class Login extends BaseValidate {
    protected $rule = [
        'number'  =>  'require',
        'password' => 'require',
    ];
    protected  $message = [
        'number.require' => '账号不能为空',
        'password.require' => '密码不能为空',
    ];
}