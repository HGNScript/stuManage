<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/12
 * Time: 18:25
 */

namespace app\admin\validate;


class EditInfo extends BaseValidate {
    protected $rule = [
        'admin_number'  =>  'require',
        'admin_name' => 'require',
        'admin_phone' => 'require',
        'admin_email' => 'require',
    ];

    protected $message = [
        'admin_number.require' => '工号不能为空',
        'admin_name.require' => '姓名不能为空',
        'admin_phone.require' => '联系电话不能为空',
        'admin_email.require' => '邮箱地址不能为空',
    ];
}