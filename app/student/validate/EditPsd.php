<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/12
 * Time: 16:23
 */

namespace app\student\validate;


class EditPsd extends BaseValidate {
    protected $rule = [
        'oldtch_psw'  =>  'require',
        'newtch_psw' => 'require',
        'newtch_psws' => 'require',
    ];
    protected  $message = [
        'oldtch_psw.require' => '旧密码不能为空',
        'newtch_psw.require' => '新密码密码不能为空',
        'newtch_psws.require' => '请再次输入新密码',
    ];
}