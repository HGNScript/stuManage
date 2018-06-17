<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/15
 * Time: 20:08
 */

namespace app\admin\controller;

use app\admin\model\Classinfo as ClasssinfoModel;
use app\admin\validate\AddClassstu;
use app\admin\model\Classlist;

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

    public function excelAddStu() {
        //import('phpexcel.PHPExcel', EXTEND_PATH);//方法二
        vendor("PHPExcel.PHPExcel"); //方法一
        $objPHPExcel = new \PHPExcel();

        //获取表单上传文件
        $file = request()->file('excel');
        $info = $file->validate(['size'=>80000,'ext'=>'xlsx,xls,csv'])->move(ROOT_PATH . 'public' . DS . 'excel');
        $class_id = input('get.class_id');
        $res = (new ClasssinfoModel())->excelAddStu($info, $class_id);
        return json($res);
    }


    public function addAndEditStu(){
        if (request()->isAjax()) {
            $data = input('post.');
            $class_id = input('get.class_id');
            $stu_id = input('get.stu_id');
            $validate = (new AddClassstu())->goCheck();
            if ($validate) {
                if (is_object($validate)) {
                    return json($validate);
                }
            }
            $res = (new ClasssinfoModel)->addAndEditClassStu($data, $stu_id, $class_id);
            return json($res);
        }
    }
    /**
     * 添加页面
     */
    public function addClassStu(){
        $class_id = input('get.class_id');
        $this->assign('class_id', $class_id);
        return $this->fetch();
    }

    public function editClassStu() {
        $class_id = input('get.class_id');
        $stu_id = input('get.stu_id');
        $oldClassStu = (new ClasssinfoModel)->getOldClassStu($stu_id);

        $this->assign('class_id', $class_id);
        $this->assign('stu_id', $stu_id);
        $this->assign('oldClassStu', $oldClassStu);
        return $this->fetch();
    }

    public function delClassStu() {
        $stu_id = input('post.');
        $ClasssinfoModel = new ClasssinfoModel;
        $res = ClasssinfoModel::destroy($stu_id);
        if ($res) {
            return json($res = ['valid' => 1, 'msg' => '删除成功']);
        }
    }


    public function stuInfo() {
        $stu_id = input('get.stu_id');
        $stuInfo = (new ClasssinfoModel)->getStuInfo($stu_id);
        $stuInfo = $stuInfo->toArray();
        $this->assign('stu_imgurl', $stuInfo['stu_imgurl']);

        $stu_infoflag = (new ClasssinfoModel)->getStuInfoFlag($stu_id);

        if (!$stu_infoflag) {
            $this->assign('stuInfo', null);
            $this->assign('stuHead', $stuInfo);
            return $this->fetch();
        } else {
            // foreach ($stuInfo as $key => $v) {
            //     if (!$v) {
            //         $stuInfo[$key] = '<span class="layui-badge">还未填写</span>';
            //     }
            // }
            $this->assign('stuInfo', $stuInfo);
            return $this->fetch();
        }
    }
}