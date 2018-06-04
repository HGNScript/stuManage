<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/11
 * Time: 12:44
 */

namespace app\teacher\validate;



class Login extends BaseValidate {
    protected $rule = [
        'classtch_number'  =>  'require',
        'classtch_password' => 'require',
    ];
    protected  $message = [
        'classtch_number.require' => '账号不能为空',
        'classtch_password.require' => '密码不能为空',
    ];
}