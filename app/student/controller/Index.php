<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/18
 * Time: 12:31
 */

namespace app\student\controller;


use app\student\controller\BaseController;
use app\student\model\student;
use app\student\validate\EditPsd;
use think\Session;

class Index extends BaseController {

    public function index() {
        $stu_id = session('student.stu_id');
        $stuinfo = (new student())->getStuInfo($stu_id);

        $this->assign('info_falg', $stuinfo['stu_infoflag']);
        return $this->fetch();
    }

    public function editPsd() {
        if (request()->isAjax()) {
            $data = input('post.');
            $stu_id = Session::get('student.stu_id');

            $validate = (new EditPsd())->goCheck();
            if ($validate) {
                if (is_object($validate)) {
                    return json($validate);
                }
            }

            $res =  (new student())->editPsd($data, $stu_id);
            if ($res['valid'] == 0 ) {
                return new ParameterException([
                    'msg' => $res['msg']
                ]);
            } else{
                return 0;
            }
        }
        return $this->fetch();
    }

    public function out(){
        session('student.stu_id', null);
        session('student.student_name', null);
        $this->redirect('stuLogin');
    }
}