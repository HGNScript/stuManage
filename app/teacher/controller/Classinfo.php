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
use app\admin\model\Classlist as classListModel;

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
        $stuInfo = (new \app\student\model\grant)->getGrant($stu_id);
        // $stuInfo = $stuInfo->toArray();
        $this->assign('stu_imgurl', $stuInfo['stu_imgurl']);

        $stu_infoflag = (new ClasssinfoModel)->getStuInfoFlag($stu_id);

        if (!$stu_infoflag) {
            $this->assign('stuInfo', null);
            $this->assign('stuHead', $stuInfo);
            return $this->fetch();
        } else {
            foreach ($stuInfo as $key => $v) {
                if (!$v) {
                    // $stuInfo[$key] = '<span class="layui-badge">还未填写</span>';
                }
            }
            $this->assign('stuInfo', $stuInfo);
            return $this->fetch();
        }

        
    }

    public function stuinfoNotice(){
        $stu_infoflag = 0;
        $stu_id = input('post.stu_id');
        $noticeFlag = input('get.noticeFlag');

        $stuinfo = \app\student\model\student::get($stu_id);

        $res = (new \app\student\model\student())->save(['stu_infoflag' => $stu_infoflag], ['stu_id' => $stu_id]);



        if ($res || $res == 0) {

            if ($noticeFlag == 'infoBug') {
                $paramsArr = [];
                $res = (new \app\teacher\model\BaseModel())->sms($stuinfo['stu_phone'], $paramsArr, 140118);
                return $res;

            } else {
                $paramsArr = [];
                $res = (new \app\teacher\model\BaseModel())->sms($stuinfo['stu_phone'], $paramsArr, 140123);
                return $res;
            }
           

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

     public function export() {

        $class_id = input('get.class_id');

        $class_name = Classlist::get($class_id);

        vendor("PHPExcel.PHPExcel");

        $objPHPExcel = new \PHPExcel();

        $objPHPExcel->getProperties();

        $stuData = (new \app\admin\model\Classinfo())->getExportData($class_id);

        (new classListModel)->export($objPHPExcel, $stuData, $class_name);

    }



}