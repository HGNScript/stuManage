<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/6/3
 * Time: 15:33
 */

namespace app\student\validate;


class Psd extends BaseValidate {
    protected $rule = [
        'stu_numBer'  =>  'require',
        'newtch_psw' => 'require',
        'newtch_psws' => 'require',
        'stu_phone' => 'require|number',
        'validate' => 'require',
    ];
    protected  $message = [
        'stu_numBer.require' => '学号不能为空',
        'newtch_psw.require' => '新密码不能为空',
        'newtch_psws.require' => '请再次输入新密码',
        'stu_phone.require' => '联系电话不能为空',
        'stu_phone.number' => '联系电话只能为数字',
        'validate.require' => '验证码不能为空',
    ];
}