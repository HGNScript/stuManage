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
        'stu_name' => 'require|chsAlpha',
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
        'stu_enrolmentyear' => 'require|number',
        'stu_enrollmentquarter' => 'require',
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
        'stu_hukouaddresstow' => 'require|chs',
        'stu_totalentrancescore' => 'require',
        'stu_dormnumber' => 'require|alphaDash',
        'stu_nameofschoolrunningpoint' => 'require|chs',
        'stu_classstudents' => 'require|chs',
        'stu_hukouquyu' => 'require|chs',
        'stu_hukouaddressf' => 'require|chs',
        'stu_state' => 'require|chs',
        'stu_originaltroops' => 'chs',
        'stu_originalmilitaryrank' => 'chs',
        'stu_enlist' => 'chs',
        'stu_demobilizedstyle' => 'chs',
        'stu_health' => 'chs',
        'stu_guangzhouHukou' => 'chs',
        'stu_guangzhouprimaryschool' => 'chs',
        'stu_sourceprovince' => 'chs',
        'stu_shengyuancity' => 'chs',
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
        'stu_enrolmentyear.require' => '"招生年份"不能为空',
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
        'stu_dormnumber.require' => '"宿舍号"不能为空',
        'stu_nameofschoolrunningpoint.require' => '"办学点名称"不能为空',
        'stu_classstudents.require' => '"学生类别"不能为空',
        'stu_hukouquyu.require' => '"户口区域"不能为空',
        'stu_hukouaddressf.require' => '"户籍所在地"不能为空',
        'stu_state.require' => '"学生状态"不能为空',

        'stu_health.require' => '"健康状况"不能为空',

        'stu_studystyle.chs' => '"学习形式"只能为中文',
        'stu_name.chsAlpha' => '"名称"只能为中文或字母',
        'stu_number.number' => '"学号"只能为数字',
        'stu_identity.number' => '"身份证"只能为数字',
        'stu_nation.chs' => '"民族"只能为中文',
        'stu_phone.number' => '"联系电话"只能为数字',
        'stu_phone.length' => '"联系电话"长度为6~12',
        'stu_hukouaddress.chsAlpha' => '"户口所在地"不能为数字',
        'stu_specialty.chs' => '"专业名称"只能为中文',
        'stu_graduation.chs' => '"毕业学校"只能为中文',
        'stu_enrolmentyear.number' => '"招生年份"只能为数字',

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
        'stu_hukouaddresstow.chs' => '"户口地址"只能为中文',
        'stu_retiredsoldier.chs' => '"是否退役士兵"只能为中文',
        'stu_totalentrancescore.number' => '"入学总分"只能为数字',
        'stu_dormnumber.alphaDash' => '"宿舍号"不能为中文',
        'stu_nameofschoolrunningpoint.chs' => '"办学点名称"只能为中文',
        'stu_classstudents.chs' => '"学生类别"只能为中文',
        'stu_hukouquyu.chs' => '"户口区域"只能为中文',
        'stu_hukouaddressf.chs' => '"户籍所在地"只能为中文',
        'stu_state.chs' => '"学生状态"只能为中文',

        'stu_originaltroops.chs' => '原部队只能为中文',
        'stu_originalmilitaryrank.chs' => '原军衔只能为中文',
        'stu_enlist.chs' => '入伍地只能为中文',
        'stu_demobilizedstyle.chs' => '退役方式只能为中文',
        'stu_health.chs' => '健康状况只能为中文',
        'stu_guangzhouHukou.chs' => '广州市户口地区只能为中文',
        'stu_guangzhouprimaryschool.chs' => '原毕业学校只能为中文',
        'stu_sourceprovince.chs' => '原毕业学校只能为中文',




    ];
}