<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/30
 * Time: 16:30
 */

namespace app\student\validate;


class Leave extends BaseValidate {
    protected $rule = [
        'leave_name' => 'require|chsAlpha',
        'leave_sex' => 'require',
        'leave_number' => 'require|number',
        'leave_className' => 'require|chs',
        'leave_category' => 'require',
        'leave_content' => 'require',
        'leave_startTime' => 'require|date',
        'leave_endTime' => 'require|date',
        'leave_phone' => 'require|number',
        'leave_parentPhone' => 'require|number',
    ];
    protected  $message = [
        'leave_name.require' => '"姓名"不能为空',
        'leave_sex.require' => '"性别"不能为空',
        'leave_number.require' => '"学号"不能为空',
        'leave_className.require' => '"班级"名称不能为空',
        'leave_category.require' => '"请假"类别',
        'leave_content.require' => '"请假原因"不能为空',
        'leave_startTime.require' => '"请假时间"不能为空',
        'leave_endTime.require' => '"请假结束时间"不能为空',
        'leave_phone.require' => '"联系电话"不能为空',
        'leave_parentPhone.require' => '"家长电话"不能为空',


        'leave_name.chsAlpha' => '"姓名"只能为汉字或字母',
        'leave_number.number' => '"学号"只能为数字',
        'leave_className.chs' => '"班级名称"只能为汉字',
        'leave_startTime.date' => '"请假时间"不是有效的日期',
        'leave_endTime.date' => '"请假结束时间"不是有效的日期',
        'leave_phone.number' => '"联系电话"只能为数字',
        'leave_parentPhone.number' => '"家长电话"只能为数字',
    ];
}