<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/6/18
 * Time: 9:56
 */

namespace app\student\validate;


class DormFlag extends BaseValidate
{
    protected $rule = [
        'stu_dormnumber' => 'require|alphaDash',
    ];

    protected $message = [
        'stu_dormnumber.require' => '"宿舍号"不能为空',
        'stu_dormnumber.alphaDash' => '"宿舍号"不能为中文',
    ];
}