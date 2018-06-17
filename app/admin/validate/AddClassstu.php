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
        'stu_number'  =>  'require|number',
        'stu_name'  =>  'require|chs',
        'stu_sex'  =>  'require|chs',
        'stu_identity'  =>  'require',
        'stu_dormnumber'  =>  'require|chsDash',
    ];
    protected  $message = [
        'stu_number.require' => '学号不能为空',
        'stu_name.require'=>'学生名称不能为空',
        'stu_sex.require'=>'性别不能为空',
        'stu_identity.require'=>'身份证号码名称不能为空',
        'stu_dormnumber.require'=>'宿舍号不能为空',

        'stu_name.chs'=>'学生名称只能为中文',
        'stu_sex.chs'=>'学生性别只能为中文',
        'stu_number.number'=>'学号只能数字',
        'stu_dormnumber.chsDash'=>'宿舍号只能数字只能是汉字、字母、数字和下划线_及破折号-',

    ];
}