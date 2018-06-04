<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/12
 * Time: 13:48
 */

namespace app\admin\validate;


class AddGrade extends BaseValidate {
    protected $rule = [
        'grade_name'  =>  'require',
    ];
    protected  $message = [
        'grade_name.require' => '年级名称不能为空',
    ];
}