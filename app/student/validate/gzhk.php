<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/6/18
 * Time: 9:56
 */

namespace app\student\validate;


class gzhk extends BaseValidate
{
    protected $rule = [
        'stu_guangzhouprimaryschool' => 'require|chsAlphaNum',
    ];

    protected $message = [
        'stu_guangzhouprimaryschool.require' => '"原毕业学校（广州市就填写）"不能为空',
        'stu_guangzhouprimaryschool.chsAlphaNum' => '"原毕业学校（广州市就填写）"只能为汉字、字母和数字',
    ];
}