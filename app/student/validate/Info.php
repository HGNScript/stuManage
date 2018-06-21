<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/30
 * Time: 17:08
 */

namespace app\student\validate;


class Info extends BaseValidate {
    protected $rule = [
        'stu_imgurl' => 'require',
        'stu_studystyle'  =>  'require|chs',
        'stu_name' => 'require|chs',
        'stu_number' => 'require|number',
        'stu_identity' => 'require|number',
        'stu_sex' => 'require',
        'stu_birthday' => 'require',
        'stu_nation' => 'require|chs',
        'stu_phone' => 'require|number|length:6,12',
        'stu_politicalstatus' => 'require',
        'stu_hukouaddress' => 'require',
        'stu_hokoustyle' => 'require',
        'stu_specialty' => 'require|chs',
        'stu_graduation' => 'require|chs',
        'stu_enrollmentquarter' => 'require',
        'stu_grade' => 'require|number',
        'class_name' => 'require',
        'stu_professionallevel' => 'require|chs',
        'stu_Preschooleducation' => 'require|chs',
        'stu_schoolsystem' => 'require|chs',
        'stu_familycontact' => 'require|chs',
        'stu_familyphone' => 'require|number',
        'stu_totalannualincomefamily' => 'require|number',
        'stu_percapitaincomefamily' => 'require|number',

        'stu_familydifficulties' => 'require|chs',
        'stu_sourceincome' => 'require|chs',
        'stu_postalcode' => 'require|number',
        'stu_differentcountries' => 'require|chs',
        'stu_certificatestyle' => 'require|chs',
        'stu_hukouaddresstow' => 'require',
        'stu_totalentrancescore' => 'require',

        'stu_nameofschoolrunningpoint' => 'require|chs',
        'stu_classstudents' => 'require|chs',
        'stu_hukouquyu' => 'require|chs',
//        'stu_hukouaddressf' => 'require|chs',
        'stu_state' => 'require|chs',



        'stu_health' => 'require|chs',

        'stu_guangzhouHukou' => 'chs',
        'stu_guangzhouprimaryschool' => 'chs',
        'stu_sourceprovince' => 'chs',
        'stu_shengyuancity' => 'chs',


        'family_name1' => 'require|chs',
        'family_sex1' => 'require|chs',
        'family_age1' => 'require|number',
        'family_relationship1' => 'require|chs',
        'family_work1' => 'require|chsAlphaNum',

        'family_name2' => 'chs',
        'family_sex2' => 'chs',
        'family_age2' => 'number',
        'family_relationship2' => 'chs',
        'family_work2' => 'chsAlphaNum',

        'family_name3' => 'chs',
        'family_sex3' => 'chs',
        'family_age3' => 'number',
        'family_relationship3' => 'chs',
        'family_work3' => 'chsAlphaNum',

        'family_name4' => 'chs',
        'family_sex4' => 'chs',
        'family_age4' => 'number',
        'family_relationship4' => 'chs',
        'family_work4' => 'chsAlphaNum',


        'stu_graduateFromSchool' => 'require|chsAlphaNum',
        

    ];



    protected  $message = [
        'stu_imgurl.require' => '"图片"不能为空',

        'stu_studystyle.require'  =>  '"学习形式"不能为空',
        'stu_name.require' => '"姓名"不能为空',
        'stu_number.require' => '"学号"不能为空',
        'stu_identity.require' => '"身份证号码"不能为空',
        'stu_sex.require' => '"性别"不能为空',
        'stu_birthday.require' => '"出生日期"不能为空',
        'stu_nation.require' => '"民族"不能为空',
        'stu_phone.require' => '"联系电话"不能为空',
        'stu_politicalstatus.require' => '"政治面貌"不能为空',
        'stu_hukouaddress.require' => '"户口所在地"不能为空',
        'stu_hokoustyle.require' => '"户口性质"不能为空',
        'stu_specialty.require' => '"学习专业名称"不能为空',
        'stu_graduation.require' => '"毕业学校"不能为空',
        'stu_enrollmentquarter.require' => '"招生季度"不能为空',
        'class_name.require' => '"班级"不能为空',
        'stu_professionallevel.require' => '"专业级别"不能为空',
        'stu_Preschooleducation.require' => '"入学前文化程度"不能为空',
        'stu_schoolsystem.require' => '"学制"不能为空',
        'stu_familycontact.require' => '"家庭联系人"不能为空',
        'stu_familyphone.require' => '"家庭联系电话"不能为空',
        'stu_totalannualincomefamily.require' => '"家庭年总收入"不能为空',
        'stu_percapitaincomefamily.require' => '"家庭人均收入"不能为空',
        'stu_100thousand.require' => '"是否10万以下民族"不能为空',
        'stu_familydifficulties.require' => '"是否家庭困难"不能为空',
        'stu_familylow.require' => '"是否低保"不能为空',
        'stu_sourceincome.require' => '"收入来源"不能为空',
        'stu_postalcode.require' => '"邮政编码"不能为空',
        'stu_differentcountries.require' => '"国别"不能为空',
        'stu_certificatestyle.require' => '"证件类型"不能为空',
        'stu_hukouaddresstow.require' => '"户口地址"不能为空',
        'stu_retiredsoldier.require' => '"是否退役士兵"不能为空',
        'stu_totalentrancescore.require' => '"入学总分"不能为空',

        'stu_nameofschoolrunningpoint.require' => '"办学点名称"不能为空',
        'stu_classstudents.require' => '"学生类别"不能为空',
        'stu_hukouquyu.require' => '"户口区域"不能为空',
//        'stu_hukouaddressf.require' => '"户籍所在地"不能为空',
        'stu_state.require' => '"学生状态"不能为空',

        'stu_health.require' => '"健康状况"不能为空',

        'stu_studystyle.chs' => '"学习形式"只能为中文',
        'stu_name.chs' => '"名称"只能为中文',
        'stu_number.number' => '"学号"只能为数字',
        'stu_identity.number' => '"身份证"只能为数字',
        'stu_nation.chs' => '"民族"只能为中文',
        'stu_phone.number' => '"联系电话"只能为数字',
        'stu_phone.length' => '"联系电话"长度为6~12',
        'stu_hukouaddress.chsAlpha' => '"户口所在地"不能为数字',
        'stu_specialty.chs' => '"专业名称"只能为中文',
        'stu_graduation.chs' => '"毕业学校"只能为中文',

        'stu_professionallevel.chs' => '"专业级别"只能为中文',
        'stu_Preschooleducation.chs' => '"入学前文化程度"只能为中文',



        'stu_schoolsystem.chs' => '"学制"只能为中文',
        'stu_familycontact.chs' => '"家庭联系人"只能为中文',

        'stu_familyphone.number' => '"家庭联系电话"只能为数字',
        'stu_totalannualincomefamily.number' => '"家庭年总收入"只能为数字',
        'stu_percapitaincomefamily.number' => '"家庭人均收入"只能为数字',

        'stu_familydifficulties.chs' => '"是否家庭困难"只能为中文',
        'stu_sourceincome.chs' => '"收入来源"只能为中文',
        'stu_postalcode.number' => '"邮政编码"只能为数字',
        'stu_differentcountries.chs' => '"国别"只能为中文',
        'stu_certificatestyle.chs' => '"证件类型"只能为中文',
        'stu_retiredsoldier.chs' => '"是否退役士兵"只能为中文',
        'stu_totalentrancescore.number' => '"入学总分"只能为数字',
        'stu_nameofschoolrunningpoint.chs' => '"办学点名称"只能为中文',
        'stu_classstudents.chs' => '"学生类别"只能为中文',
        'stu_hukouquyu.chs' => '"户口区域"只能为中文',
//        'stu_hukouaddressf.chs' => '"户籍所在地"只能为中文',
        'stu_state.chs' => '"学生状态"只能为中文',



        
        'stu_health.chs' => '健康状况只能为中文',
        'stu_guangzhouHukou.chs' => '广州市户口地区只能为中文',
        'stu_guangzhouprimaryschool.chs' => '原毕业学校只能为中文',
        'stu_sourceprovince.chs' => '原毕业学校只能为中文',

        'stu_grade.number' => '"招生年份"只能为数字',
        'stu_grade.require' => '"招生年份"不能为空',


        'family_name1.require' => '家庭成员至少需填写户主信息',
        'family_name1.chs' => '家庭成员名称只能为中文',

        'family_sex1.require' => '家庭成员性别不能为空',
        'family_sex1.chs' => '家庭成员性别只能为中文',

        'family_age1.require' => '家庭成员年龄不能为空',
        'family_age1.number' => '年龄只能为数字',

        'family_relationship1.require' => '家庭成员与本人关系不能为空',
        'family_relationship1.chs' => '家庭成员与本人关系只能为中文',

        'family_work1.require' => '家庭成员工作或学校单位不能为空',
        'family_work1.chsAlphaNum' => '家庭成员工作或学校单位只能为汉字、字母和数字',


        'family_name2.chs' => '家庭成员名称只能为中文',

        'family_sex2.chs' => '家庭成员性别只能为中文',

        'family_age2.number' => '年龄只能为数字',

        'family_relationship2.chs' => '家庭成员与本人关系只能为中文',

        'family_work2.chsAlphaNum' => '家庭成员工作或学校单位只能为汉字、字母和数字',


        'family_name3.chs' => '家庭成员名称只能为中文',

        'family_sex3.chs' => '家庭成员性别只能为中文',

        'family_age3.number' => '年龄只能为数字',

        'family_relationship3.chs' => '家庭成员与本人关系只能为中文',

        'family_work3.chsAlphaNum' => '家庭成员工作或学校单位只能为汉字、字母和数字',



        'family_name4.chs' => '家庭成员名称只能为中文',

        'family_sex4.chs' => '家庭成员性别只能为中文',

        'family_age4.number' => '年龄只能为数字',

        'family_relationship4.chs' => '家庭成员与本人关系只能为中文',

        'family_work4.chsAlphaNum' => '家庭成员工作或学校单位只能为汉字、字母和数字',



        'stu_graduateFromSchool.chsAlphaNum' => '"何时毕业于何学校"只能是汉字、字母和数字',
        'stu_graduateFromSchool.require' => '"何时毕业于何学校"不能为空',










    ];
}