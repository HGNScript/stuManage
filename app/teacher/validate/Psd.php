<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/6/3
 * Time: 15:33
 */

namespace app\teacher\validate;


class Psd extends BaseValidate {
    protected $rule = [
        'tch_numBer'  =>  'require',
        'newtch_psw' => 'require',
        'newtch_psws' => 'require',
        'tch_phone' => 'require|number',
        'validate' => 'require',
    ];
    protected  $message = [
        'tch_numBer.require' => '工号不能为空',
        'newtch_psw.require' => '新密码不能为空',
        'newtch_psws.require' => '请再次输入新密码',
        'tch_phone.require' => '联系电话不能为空',
        'tch_phone.number' => '联系电话只能为数字',
        'validate.require' => '验证码不能为空',
    ];
}