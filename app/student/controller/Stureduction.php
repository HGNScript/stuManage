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
        $reduction = (new Reduction)->getReduction($stu_id);
        $reduction['stu_identity'] = str_split(trim($reduction['stu_identity']));

        $this->assign('stuinfo', $reduction);
        return $this->fetch();
    }

    public function reduction(){
        if (request()->isAjax()) {
            $data = input('post.');

            // $validate = (new \app\student\validate\Reduction())->goCheck();
            //     if (is_object($validate)) {
            //         return json($validate);
            // }

            $reduction_flag = input('get.reduction_flag');
            $stu_id = session('student.stu_id');
            $data['stu_id'] = $stu_id;
            $data['reduction_flag'] = $reduction_flag;

            $res = (new Reduction())->submitReduction($data);

            if ($res) {
                return json($res = ['valid' => 1, 'msg' => '提交成功']);
            } else {
                return json($res = ['valid' => 0, 'msg' => '提交成功']);
            }
        }
    }
}