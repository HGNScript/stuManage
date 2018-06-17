<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/6/17
 * Time: 21:28
 */

namespace app\student\validate;


class Retiredsoldier extends BaseValidate
{
    protected $rule = [
        'stu_originaltroops' => 'require|chs',
        'stu_originalmilitaryrank' => 'require|chs',
        'stu_enlist' => 'require|chs',
        'stu_enlisttime' => 'require',
        'stu_demobilizedtime' => 'require',
        'stu_demobilizedstyle' => 'require|chs',



    ];
    protected  $message = [
        'stu_originaltroops.require' => '"原部队"不能为空',
        'stu_originaltroops.chs' => '"原部队"只能为中文',

        'stu_originalmilitaryrank.require' => '"原军衔"不能为空',
        'stu_originalmilitaryrank.chs' => '"原军衔"只能为中文',

        'stu_enlist.require' => '"入伍地"不能为空',
        'stu_enlist.chs' => '"入伍地"只能为中文',

        'stu_enlisttime.require' => '"入伍时间"不能为空',
        'stu_demobilizedtime.require' => '"退伍时间"不能为空',


        'stu_demobilizedstyle.require' => '"退伍方式"不能为空',
        'stu_demobilizedstyle.chs' => '"退伍方式"只能为中文',

    ];
}