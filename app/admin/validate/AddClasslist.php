<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/12
 * Time: 13:48
 */

namespace app\admin\validate;


class AddClasslist extends BaseValidate {
    protected $rule = [
        'class_grade'  =>  'require',
        'class_name'  =>  'require',
        'class_specialty'  =>  'require',
        'classtch_id'  =>  'require',
    ];
    protected  $message = [
        'class_grade.require' => '年级不能为空',
        'class_name.require'=>'班级名称不能为空',
        'class_specialty.require' => '专业名称不能为空',
        'classtch_id.require'=>'辅导员不能为空',
    ];
}