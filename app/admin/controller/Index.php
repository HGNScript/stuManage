<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/10
 * Time: 19:40
 */

namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\model\Grade;
use app\admin\validate\AddGrade;
use app\admin\validate\EditInfo;
use app\admin\validate\EditPsd;
use app\lib\exception\ParameterException;
use think\Session;

class Index  extends BaseController {
    public function index() {
        $grade = (new Grade)->getGrade();
        $this->assign('grade', $grade);
        return $this->fetch();
    }

    public function addGrade() {
        if (request()->isAjax()) {
            $data = input('post.');
            $validate = (new AddGrade())->goCheck();
            if ($validate) {
                if (is_object($validate)) {
                    return json($validate);
                }
            }

            $res = (new Grade())->addGrade($data);
            if (!$res) {
                return new ParameterException([
                    'msg' => '该年级已存在'
                ]);
            } else{
                return 0;
            }
        }
        return $this->fetch();

    }

    public function delGrade () {
        if (request()->isAjax()) {
            $grade = input('get.grade');
            $password = input('post.password');

            $res = (new Grade())->delGrade($grade, $password);
            if (!$res) {
                return new ParameterException([
                    'msg' => '管理员密码错误'
                ]);
            } else {
                return 0;
            }
        }
    }

    public function editInfo() {
        if (request()->isAjax()) {
            $data = input('post.');
            $admin_id = Session::get('admin.admin_id');

            $validate = (new EditInfo())->goCheck();
            if ($validate) {
                if (is_object($validate)) {
                    return json($validate);
                }
            }

            $res =  (new Admin())->editInfo($data, $admin_id);
            if (!$res) {
                return new ParameterException([
                    'msg' => '信息修改失败'
                ]);
            } else{
                Session::set('admin.admin_name',$data['admin_name']);
                return 0;
            }
        }
        $admin_id = Session::get('admin.admin_id');
        $adminInfo =  (new Admin())->getAdminInfo($admin_id);
        $this->assign('adminInfo', $adminInfo);

        return $this->fetch();
    }

    public function editPsd() {
        if (request()->isAjax()) {
            $data = input('post.');
            $admin_id = Session::get('admin.admin_id');

            $validate = (new EditPsd())->goCheck();
            if ($validate) {
                if (is_object($validate)) {
                    return json($validate);
                }
            }

            $res =  (new Admin())->editPsd($data, $admin_id);
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
        session('admin.admin_id', null);
        session('admin.admin_name', null);
        session('admin.admin_authority', null);
        $this->redirect('Login');
    }
}