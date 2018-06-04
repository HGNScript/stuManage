<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/30
 * Time: 20:50
 */

namespace app\student\validate;


class Grant extends BaseValidate {
    protected $rule = [
        'grant_school' => 'require|chs',
        'grant_startTime' => 'require|number',
        'grant_endTime' => 'require|number',
        'stu_name' => 'require|chs',
        'stu_sex' => 'require|chs',
        'stu_birthday' => 'require|date',
        'grant_jg' => 'require|chs',
        'stu_nation' => 'require|chs',
        'stu_politicalstatus' => 'require|chs',
        'stu_number' => 'require|number',
        'stu_identity' => 'require|alphaDash',
        'stu_hukouaddress' => 'require|chs',
        'grant_examination' => 'require|number',
        'grant_graduateFromSchool' => 'require|chs',

        'family_name1' => 'require|chs',
        'family_sex1' => 'require|chs',
        'family_age1' => 'require|number',
        'family_relationship1' => 'require|chs',
        'family_work1' => 'require|chs',

        'family_name2' => 'require|chs',
        'family_sex2' => 'require|chs',
        'family_age2' => 'require|number',
        'family_relationship2' => 'require|chs',
        'family_work2' => 'require|chs',

        'family_name3' => 'require|chs',
        'family_sex3' => 'require|chs',
        'family_age3' => 'require|number',
        'family_relationship3' => 'require|chs',
        'family_work3' => 'require|chs',

        'family_name4' => 'require|chs',
        'family_sex4' => 'require|chs',
        'family_age4' => 'require|number',
        'family_relationship4' => 'require|chs',
        'family_work4' => 'require|chs',

        'grant_familyAddesPhone' => 'require|chsAlphaNum',
        'stu_postalcode' => 'require|number',
        'grant_contacts' => 'require|chs',
        'stu_phone' => 'require|number',
        'stu_specialty' => 'require|chs',
        'grant_grade' => 'require|number',

    ];
    protected  $message = [
        'grant_school.require' => '"学校名称"不能为空',
        'grant_school.chs' => '"学校名称"只能为中文',

        'grant_startTime.require' => '"学年"不能为空',
        'grant_startTime.number' => '学年"只能为数字',

        'grant_endTime.require' => '"学年"不能为空',
        'grant_endTime.number' => '学年"只能为数字',

        'stu_name.require' => '"姓名"不能为空',
        'stu_name.chs' => '"姓名"只能为中文',

        'stu_sex.require' => '"性别"不能为空',
        'stu_sex.chs' => '"性别"只能为中文',

        'stu_birthday.require' => '"出生年月"不能为空',
        'stu_birthday.date' => '"出生年月"不是有效的日期',

        'grant_jg.require' => '"籍贯"不能为空',
        'grant_jg.chs' => '"籍贯"只能为中文',

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

        'grant_examination.require' => '"中考准考证号"不能为空',
        'grant_examination.number' => '"中考准考证号"只能为数字',

        'grant_graduateFromSchool.require' => '"何时毕业于何学校"不能为空',
        'grant_graduateFromSchool.chs' => '"何时毕业于何学校"只能为中文',

        'family_name1.require' => '家庭成员(1)名称不能为空',
        'family_name1.chs' => '家庭成员(1)名称只能为中文',

        'family_sex1.require' => '家庭成员(1)性别不能为空',
        'family_sex1.chs' => '家庭成员(1)性别只能为中文',

        'family_age1.require' => '家庭成员(1)年龄不能为空',
        'family_age1.number' => '年龄只能为数字',

        'family_relationship1.require' => '家庭成员(1)与本人关系不能为空',
        'family_relationship1.chs' => '家庭成员(1)与本人关系只能为中文',

        'family_work1.require' => '家庭成员(1)工作或学校单位不能为空',
        'family_work1.chs' => '家庭成员(1)工作或学校单位只能为中文',




        'family_name2.require' => '"家庭成员(2)名称"不能为空',
        'family_name2.chs' => '"家庭成员(2)名称"只能为中文',

        'family_sex2.require' => '"家庭成员(2)性别"不能为空',
        'family_sex2.chs' => '"家庭成员(2)性别"只能为中文',

        'family_age2.require' => '"家庭成员(2)年龄"不能为空',
        'family_age2.number' => '"年龄"只能为数字',

        'family_relationship2.require' => '"家庭成员(2)与本人关系"不能为空',
        'family_relationship2.chs' => '"家庭成员(2)与本人关系"只能为中文',

        'family_work2.require' => '"家庭成员(2)工作或学校单位"不能为空',
        'family_work2.chs' => '"家庭成员(2)工作或学校单位"只能为中文',



        'family_name3require' => '"家庭成员(3)名称"不能为空',
        'family_name3.chs' => '"家庭成员(3)名称"只能为中文',

        'family_sex3.require' => '"家庭成员(3)性别"不能为空',
        'family_sex3.chs' => '"家庭成员(3)性别"只能为中文',

        'family_age3.require' => '"家庭成员(3)年龄"不能为空',
        'family_age3.number' => '"年龄"只能为数字',

        'family_relationship3.require' => '家庭成员(3)与本人关系不能为空',
        'family_relationship3.chs' => '家庭成员(3)与本人关系只能为中文',

        'family_work3.require' => '"家庭成员(3)工作或学校单位"不能为空',
        'family_work3.chs' => '"家庭成员(3)工作或学校单位"只能为中文',





        'family_name4.require' => '"家庭成员(4)名称"不能为空',
        'family_name4.chs' => '"家庭成员(4)名称"只能为中文',

        'family_sex4.require' => '"家庭成员(4)性别"不能为空',
        'family_sex4.chs' => '"家庭成员(4)性别"只能为中文',

        'family_age4.require' => '"家庭成员(4)年龄"不能为空',
        'family_age4.number' => '"年龄"只能为数字',

        'family_relationship4.require' => '"家庭成员(4)与本人关系"不能为空',
        'family_relationship4.chs' => '"家庭成员(4)与本人关系"只能为中文',

        'family_work4.require' => '"家庭成员(4)工作或学校单位"不能为空',
        'family_work4.chs' => '"家庭成员(4)工作或学校单位"只能为中文',

        'grant_familyAddesPhone.require' => '"家庭地址及固定电话"不能为空',
        'grant_familyAddesPhone.chsAlphaNum' => '"家庭地址及固定电话"只能为中文和数字',

        'stu_postalcode.require' => '"邮政编码"不能为空',
        'stu_postalcode.number' => '"邮政编码"只能为数字',

        'grant_contacts.require' => '"联系人"不能为空',
        'grant_contacts.chs' => '"联系人"只能为中文',

        'stu_phone.require' => '"联系手机(电话)"不能为空',
        'stu_phone.number' => '"联系手机(电话)"只能为数字',

        'stu_specialty.require' => '"就读专业"不能为空',
        'stu_specialty.chs' => '"就读专业"只能为中文',

        'grant_grade.require' => '"年级"不能为空',
        'grant_grade.number' => '"年级"只能为数字',
    ];
}