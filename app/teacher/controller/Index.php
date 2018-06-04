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
        $classtch_id = Session::get('teacher.tch_id');
        $classlist = classModel::where('classtch_id', $classtch_id)->select();
        $this->assign('classlist', $classlist);

        $this->notice();
        return $this->fetch();
    }

    public function editInfo() {
        $classtch_id = Session::get('teacher.tch_id');
    	$classtch = tch::where('classtch_id', $classtch_id)->find();
    	$this->assign('classtch', $classtch);

        if (request()->isAjax()) {
            $classtch_id = Session::get('teacher.tch_id');
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
                Session::set('teacher.tch_name',$data['classtch_name']);
                return 0;
            }
        }

        return $this->fetch();
    }

    public function editPsd (){
        if (request()->isAjax()) {
            $data = input('post.');
            $classtch_id = Session::get('teacher.tch_id');

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
        session('teacher.tch_id', null);
        session('teacher.tch_name', null);
        $this->redirect('Login');
    }

    public function notice() {
        $leaveNotice = (new \app\teacher\model\Leave())->where('leave_flag', 1)->select();
        $grantNotice = (new \app\teacher\model\Grant())->where('grant_flag', 1)->select();
        $reductionNotice = (new \app\teacher\model\reduction())->where('reduction_flag', 1)->select();

        return json(['leaveNotice' => sizeof($leaveNotice), 'grantNotice' => sizeof($grantNotice), 'reductionNotice' => sizeof($reductionNotice)]);
    }



}