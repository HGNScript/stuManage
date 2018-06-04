<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/24
 * Time: 8:26
 */

namespace app\student\controller;


use app\student\model\Reduction;
use app\student\model\student;

class Stureduction extends BaseController {

    public function index(){
        $stu_id = session('student.stu_id');
        $stuinfo = student::get($stu_id);
        $reductionData = Reduction::where('stu_id', $stu_id)->find();

        if ($reductionData) {
            $this->assign('stuinfo', $reductionData);
        } else {
            $stuinfo['reduction_startTime'] = null;
            $stuinfo['reduction_endTime'] = null;
            $stuinfo['reduction_jg'] = null;
            $stuinfo['family_name1'] = null;
            $stuinfo['reduction_school'] = null;
            $stuinfo['reduction_examination'] = null;
            $stuinfo['reduction_graduateFromSchool'] = null;
            $stuinfo['reduction_familyAddesPhone'] = null;
            $stuinfo['reduction_grade'] = null;
            $stuinfo['reduction_flag'] = null;
            $this->assign('stuinfo', $stuinfo);
        }
        return $this->fetch();
    }

    public function reduction(){
        if (request()->isAjax()) {
            $data = input('post.');

            $validate = (new \app\student\validate\Reduction())->goCheck();
                if (is_object($validate)) {
                    return json($validate);
            }

            $reduction_flag = input('get.reduction_flag');
            $stu_id = session('student.stu_id');
            $data['stu_id'] = $stu_id;
            $data['reduction_flag'] = $reduction_flag;

            $res = (new Reduction())->submitReduction($data);

            if ($res) {
                return json($res = ['valid' => 1, 'msg' => '保存成功']);
            } else {
                return json($res = ['valid' => 0, 'msg' => '保存失败']);
            }
        }
    }
}