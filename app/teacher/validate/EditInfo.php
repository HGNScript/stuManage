<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/12
 * Time: 18:25
 */

namespace app\teacher\validate;


class EditInfo extends BaseValidate {
    protected $rule = [
        'classtch_name' => 'require',
        'classtch_phone' => 'require',
        'classtch_email' => 'require',
    ];

    protected $message = [
        'classtch_name.require' => '姓名不能为空',
        'classtch_phone.require' => '联系电话不能为空',
        'classtch_email.require' => '邮箱地址不能为空',
    ];
}