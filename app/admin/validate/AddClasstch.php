<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/12
 * Time: 13:48
 */

namespace app\admin\validate;


class AddClasstch extends BaseValidate {
    protected $rule = [
        'classtch_number'  =>  'require|length:4,10',
        'classtch_name'  =>  'require',
        'classtch_phone'  =>  'require|length:9,12',
        'classtch_email'  =>  'require|email',
    ];
    protected  $message = [
        'classtch_number.require' => '工号不能为空',
        'classtch_number.length'=>'工号必须在4~10个字符之间',
        'classtch_name.require' => '名称不能为空',
        'classtch_phone.length'=>'联系电话必须在9~12个字符之间',
        'classtch_phone.require' => '联系电话不能为空',
        'classtch_email.require' => '邮箱地址不能为空',
        'classtch_email.email'=>'邮箱格式错误',
    ];
}