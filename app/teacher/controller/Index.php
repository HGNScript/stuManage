<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/24
 * Time: 11:09
 */

namespace app\teacher\controller;


use app\teacher\model\classModel;
use app\teacher\model\tch;
use app\teacher\validate\EditInfo;
use app\teacher\validate\EditPsd;
use think\Session;

class Index extends BaseController {
    public function index(){
        $classtch_id = Session::get('teacher.classtch_id');
        $classlist = classModel::where('classtch_id', $classtch_id)->select();
        $this->assign('classlist', $classlist);

        $this->notice();

        return $this->fetch();
    }

    public function editInfo() {
        $classtch_id = Session::get('teacher.classtch_id');
    	$classtch = tch::where('classtch_id', $classtch_id)->find();
    	$this->assign('classtch', $classtch);

        if (request()->isAjax()) {
            $classtch_id = Session::get('teacher.classtch_id');
            $data = input('post.');
            $validate = (new EditInfo())->goCheck();
            if ($validate) {
                if (is_object($validate)) {
                    return json($validate);
                }
            }

            $res =  (new tch())->editInfo($data, $classtch_id);
            if (!$res) {
                return new ParameterException([
                    'msg' => '信息修改失败'
                ]);
            } else{
                Session::set('teacher.classtch_name',$data['classtch_name']);
                return 0;
            }
        }

        return $this->fetch();
    }

    public function editPsd (){
        if (request()->isAjax()) {
            $data = input('post.');
            $classtch_id = Session::get('teacher.classtch_id');

            $validate = (new EditPsd())->goCheck();
            if ($validate) {
                if (is_object($validate)) {
                    return json($validate);
                }
            }

            $res =  (new tch())->editPsd($data, $classtch_id);
            if ($res['valid'] === 0) {
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
        session('teacher.classtch_id', null);
        session('teacher.classtch_name', null);
        $this->redirect('/tchLogin');
    }

    public function notice() {
        $classtch_id = Session::get('teacher.classtch_id');
        $admin_id = Session::get('admin.admin_id');
        $admin_authority = Session::get('admin.admin_authority');

        $notice_flag = input('get.notice_flag');

        $notice = (new tch())->notice($classtch_id, $admin_authority, $notice_flag);

        return json($notice);
    }

    public function classNotice() {
        $class_id = input('get.class_id');
        $leave_flag_top = input('get.leave_flag_top');

        $notice = (new tch())->classNotice($class_id, $leave_flag_top);

        return json($notice);
    }

    public function show() {
        return $this->fetch();
    }



}