<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/21
 * Time: 14:32
 */

namespace app\student\controller;


use app\student\model\Leave;
use think\Db;
use app\student\model\student;
use think\Session;

class Stuleave extends BaseController {

    public function index() {
        $leave = Db::table('leave')->where('leave_flag', 0)->find();
        $this->assign('leave', $leave);
        $stu_id = Session::get('student.stu_id');

        $leave = Db::table('leave')->where('leave_flag', 0)->where('stu_id', $stu_id)->find();

        if (sizeof($leave) == 0) {
            $this->assign('leave', null);
        }else {
            $this->assign('leave', $leave);
        }

        $stuinfo = (new student())->getStuInfo($stu_id);

        $this->assign('stuinfo', $stuinfo);
        return $this->fetch();
    }

    public function submit(){
        $info = input('post.');

        $Leave = (new \app\student\validate\Leave())->goCheck();
        if (is_object($Leave)) {
            return json($Leave);
        }

        $leave_flag = input('get.leave_flag');
        $stu_id = session('student.stu_id');
        $res = (new Leave())->editAndAddLeave($info, $stu_id, $leave_flag);
        if ($res) {
            return json($res = ['valid' => 1, 'msg' => '保存成功']);
        } else {
            return json($res = ['valid' => 0, 'msg' => '保存失败']);
        }
    }


}