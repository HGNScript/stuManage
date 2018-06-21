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
        $grantdata = (new grant)->getGrant($stu_id);
        $grantdata['stu_identity'] = str_split($grantdata['stu_identity']);

        $this->assign('stuinfo', $grantdata);
        return $this->fetch();
    }

    public function grant(){
        if (request()->isAjax()) {
            $data = input('post.');

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