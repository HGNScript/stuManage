<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/11
 * Time: 12:44
 */

namespace app\admin\validate;


use think\Validate;

class Login extends BaseValidate {
    protected $rule = [
        'admin_number'  =>  'require',
        'admin_password' => 'require',
    ];
    protected  $message = [
        'admin_number.require' => '账号不能为空',
        'admin_password.require' => '密码不能为空',
    ];
}