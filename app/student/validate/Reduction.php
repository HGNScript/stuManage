<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/30
 * Time: 16:30
 */

namespace app\student\validate;


class Reduction extends BaseValidate {
    protected $rule = [
        'reduction_school' => 'require|chs',
        'reduction_startTime' => 'require|number',
        'reduction_endTime' => 'require|number',
        'stu_name' => 'require|chs',
        'stu_sex' => 'require|chs',
        'stu_birthday' => 'require|date',
        'reduction_jg' => 'require|chs',
        'stu_nation' => 'require|chs',
        'stu_politicalstatus' => 'require|chs',
        'stu_number' => 'require|number',
        'stu_identity' => 'require|alphaDash',
        'stu_hukouaddress' => 'require|chs',
        'reduction_examination' => 'require|number',
        'reduction_graduateFromSchool' => 'require',

        'family_name1' => 'require|chs',
        'family_sex1' => 'require|chs',
        'family_age1' => 'require|number',
        'family_relationship1' => 'require|chs',
        'family_work1' => 'require|chs',

        'reduction_familyAddesPhone' => 'require|chsAlphaNum',
        'stu_postalcode' => 'require|number',
        'reduction_contacts' => 'require|chs',
        'stu_phone' => 'require|number',
        'stu_specialty' => 'require|chs',
        'reduction_grade' => 'require|number',

    ];
    protected  $message = [
        'reduction_school.require' => '"学校名称"不能为空',
        'reduction_school.chs' => '"学校名称"只能为中文',

        'reduction_startTime.require' => '"学年"不能为空',
        'reduction_startTime.number' => '学年"只能为数字',

        'reduction_endTime.require' => '"学年"不能为空',
        'reduction_endTime.number' => '学年"只能为数字',

        'stu_name.require' => '"姓名"不能为空',
        'stu_name.chs' => '"姓名"只能为中文',

        'stu_sex.require' => '"性别"不能为空',
        'stu_sex.chs' => '"性别"只能为中文',

        'stu_birthday.require' => '"出生年月"不能为空',
        'stu_birthday.date' => '"出生年月"不是有效的日期',

        'reduction_jg.require' => '"籍贯"不能为空',
        'reduction_jg.chs' => '"籍贯"只能为中文',

        'stu_nation.require' => '"民族"不能为空',
        'stu_nation.chs' => '"民族"只能为中文',

        'stu_politicalstatus.require' => '"政治面目"不能为空',
        'stu_politicalstatus.chs' => '"政治面目"只能为中文',

        'stu_number.require' => '"学号"不能为空',
        'stu_number.number' => '"学号"不只能为数字',

        'stu_identity.require' => '"身份证号"不能为空',
        'stu_identity.alphaDash' => '"身份证号"不能为中文',

        'stu_hukouaddress.require' => '"户口所在地"不能为空',
        'stu_hukouaddress.chs' => '"户口所在地"只能为中文',

        'reduction_examination.require' => '"中考准考证号"不能为空',
        'reduction_examination.number' => '"中考准考证号"只能为数字',

        'reduction_graduateFromSchool.require' => '"何时毕业于何学校"不能为空',

        'family_name1.require' => '家庭成员至少需填写户主信息',
        'family_name1.chs' => '家庭成员名称只能为中文',

        'family_sex1.require' => '家庭成员性别不能为空',
        'family_sex1.chs' => '家庭成员性别只能为中文',

        'family_age1.require' => '家庭成员年龄不能为空',
        'family_age1.number' => '年龄只能为数字',

        'family_relationship1.require' => '家庭成员与本人关系不能为空',
        'family_relationship1.chs' => '家庭成员与本人关系只能为中文',

        'family_work1.require' => '家庭成员工作或学校单位不能为空',
        'family_work1.chs' => '家庭成员工作或学校单位只能为中文',


        'reduction_familyAddesPhone.require' => '"家庭地址及固定电话"不能为空',
        'reduction_familyAddesPhone.chsAlphaNum' => '"家庭地址及固定电话"只能为中文和数字',

        'stu_postalcode.require' => '"邮政编码"不能为空',
        'stu_postalcode.number' => '"邮政编码"只能为数字',

        'reduction_contacts.require' => '"联系人"不能为空',
        'reduction_contacts.chs' => '"联系人"只能为中文',

        'stu_phone.require' => '"联系手机(电话)"不能为空',
        'stu_phone.number' => '"联系手机(电话)"只能为数字',

        'stu_specialty.require' => '"就读专业"不能为空',
        'stu_specialty.chs' => '"就读专业"只能为中文',

        'reduction_grade.require' => '"年级"不能为空',
        'reduction_grade.number' => '"年级"只能为数字',
    ];
}