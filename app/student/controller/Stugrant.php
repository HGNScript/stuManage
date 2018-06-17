<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/22
 * Time: 11:17
 */

namespace app\student\controller;


use app\student\model\grant;
use app\student\model\student;

class Stugrant extends BaseController {
    public function index(){
        $stu_id = session('student.stu_id');
        $stuinfo = student::get($stu_id);
        $grantdata = grant::where('stu_id', $stu_id)->find();

        $grantdata['stu_identity'] = str_split($grantdata['stu_identity']);

        if ($grantdata) {
            $this->assign('stuinfo', $grantdata);
        } else {
            $stuinfo['grant_startTime'] = null;
            $stuinfo['grant_endTime'] = null;
            $stuinfo['grant_jg'] = null;
            $stuinfo['family_name1'] = null;
            $stuinfo['grant_school'] = null;
            $stuinfo['grant_examination'] = null;
            $stuinfo['grant_graduateFromSchool'] = null;
            $stuinfo['grant_familyAddesPhone'] = null;
            $stuinfo['grant_grade'] = null;
            $stuinfo['grant_flag'] = null;
            $this->assign('stuinfo', $stuinfo);
        }
        return $this->fetch();
    }

    public function grant(){
        if (request()->isAjax()) {
            $data = input('post.');

            $validate = (new \app\student\validate\Grant())->goCheck();
                if (is_object($validate)) {
                    return json($validate);
            }
            $grant_flag = input('get.grant_flag');
            $stu_id = session('student.stu_id');
            $data['stu_id'] = $stu_id;
            $data['grant_flag'] = $grant_flag;

            $res = (new grant())->submitGrant($data);

            if ($res) {
                return json($res = ['valid' => 1, 'msg' => '提交成功']);
            } else {
                return json($res = ['valid' => 0, 'msg' => '提交失败']);
            }
        }
    }
}