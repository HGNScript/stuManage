<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/15
 * Time: 20:08
 */

namespace app\teacher\controller;

use app\admin\model\Classinfo as ClasssinfoModel;
use app\admin\model\Classlist;
use app\student\model\student;

class Classinfo extends BaseController {
    public function index() {
        if (request()->isAjax()) {
            $data = input('post.');
            $class_id = input('get.class_id');
            $stuInfo = (new ClasssinfoModel())->getStu($data , $class_id);

            return json($stuInfo);

        }
        $id = input('get.class_id');
        $class = Classlist::get($id);
        $this->assign('class_id',$id);
        $this->assign('class',$class);
        return $this->fetch();
    }

    public function stuInfo() {
        $stu_id = input('get.stu_id');
        $stuInfo = (new ClasssinfoModel)->getStuInfo($stu_id);
        $stuInfo = $stuInfo->toArray();
        $this->assign('stu_imgurl', $stuInfo['stu_imgurl']);

        foreach ($stuInfo as $key => $v) {
            if (!$v) {
                $stuInfo[$key] = '<span class="layui-badge">还未填写</span>';
            }
        }
        $this->assign('stuInfo', $stuInfo);
        return $this->fetch();
    }

    public function stuinfoNotice(){
        $stu_infoflag = 0;
        $stu_id = input('post.stu_id');

        $stuinfo = \app\student\model\student::get($stu_id);

        $res = (new \app\student\model\student())->save(['stu_infoflag' => $stu_infoflag], ['stu_id' => $stu_id]);

        if ($res) {
            $paramsArr = ["已驳回"];
            $res = (new \app\teacher\model\BaseModel())->sms($stuinfo['stu_phone'], $paramsArr);
            return $res;

        } else {
            return json($res = ['valid' => 0, 'msg' => '服务器出现错误']);
        }
    }

    public function dbClickEdit(){
        $stu_id = input('get.stu_id');
        $name = input('post.name');
        $val = input('post.val');

        $res = (new \app\student\model\student())->dbClickEdit($stu_id, $name, $val);

        if ($res) {
            return json($res = ['valid' => 1, 'msg' => '编辑学生信息成功']);
        } else {
            return json($res = ['valid' => 0, 'msg' => '编辑学生信息错误']);
        }


    }



}