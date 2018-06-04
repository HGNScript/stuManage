<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/16
 * Time: 15:15
 */

namespace app\admin\validate;


class AddClassstu extends BaseValidate {
    protected $rule = [
        'stu_number'  =>  'require',
        'stu_name'  =>  'require',
    ];
    protected  $message = [
        'stu_number.require' => '学号不能为空',
        'stu_name.require'=>'学生名称不能为空',
    ];
}