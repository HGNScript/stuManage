<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/14
 * Time: 10:35
 */

namespace app\admin\controller;

use app\admin\model\Classlist as classListModel;
use app\admin\model\Classtch as ClasstchModel;
use app\admin\validate\AddClasslist;
use app\student\model\student;

class Classlist extends BaseController {
    public function index() {
        if (request()->isAjax()) {
            $data = input('post.');

            $classtch = (new ClasstchModel())->gettch($data['staffRoom']);


            $classlist = (new classListModel())->getClass($data, $classtch);
            return json($classlist);

        }
        $staffRoom = input('get.staffRoom');
        $grade = input('get.grade');
        $this->assign('staffRoom',$staffRoom);
        $this->assign('grade',$grade);
        return $this->fetch();
    }

    public function excelAddClasslist() {
        //import('phpexcel.PHPExcel', EXTEND_PATH);//方法二
        vendor("PHPExcel.PHPExcel"); //方法一
        $objPHPExcel = new \PHPExcel();

        //获取表单上传文件
        $file = request()->file('excel');
        $info = $file->validate(['size'=>80000,'ext'=>'xlsx,xls,csv'])->move(ROOT_PATH . 'public' . DS . 'excel');
        $staffRoom = input('get.staffRoom');
        $grade = input('get.grade');
        $res = (new classListModel())->excelAddClasslist($file , $info, $staffRoom, $grade);
        return json($res);
    }

      /**
     * 添加 and 编辑班主任
     */
    public function addAndEditClasslist(){
        if (request()->isAjax()) {
            $data = input('post.');
            $class_id = input('get.class_id');
            $validate = (new AddClasslist())->goCheck();
            if ($validate) {
                if (is_object($validate)) {
                    return json($validate);
                }
            }
            $res = (new classListModel)->addAndEditClasslist($data, $class_id);
            return json($res);
        }
    }
    /**
     * 添加页面
     */
    public function addClasslist(){
        $staffRoom = input('get.staffRoom');
        $grade = input('get.grade');
        $classtch = (new ClasstchModel())->gettch($staffRoom);
        $this->assign('staffRoom', $staffRoom);
        $this->assign('classtch', $classtch);
        $this->assign('grade', $grade);
        return $this->fetch();
    }

    /**
     * 编辑页面
     */
    public function editClasslist() {
        $staffRoom = input('get.staffRoom');
        $class_id = input('get.class_id');
        $oldClasslist = (new classListModel)->getOldClasslist($class_id);
        $classtch = (new ClasstchModel())->gettch($staffRoom);
        $grade = input('get.grade');
        $this->assign('staffRoom', $staffRoom);
        $this->assign('classtch', $classtch);
        $this->assign('grade', $grade);
        $this->assign('class_id', $class_id);
        $this->assign('oldClasslist', $oldClasslist);
        return $this->fetch();
    }

    public function delClasslist() {
        $class_id = input('post.');

        foreach ($class_id as $key => $value) {
            (new \app\admin\model\Classinfo())->where('class_id', $value)->delete();
        }
        $res = classListModel::destroy($class_id);
        if ($res) {
            return json($res = ['valid' => 1, 'msg' => '删除成功']);
        }
    }

    public function allotTch() {
        if (request()->isPost()) {
            $classtch_id = input('post.classtch_id');
            $class_id = input('post.class_id');
            $classListModel = new classListModel;
            $res = $classListModel->save([
                'classtch_id'  => $classtch_id,
            ],['class_id' => $class_id]);

            if ($res) {
                return json($res= ['valid' => 1, 'msg' => '分配成功']);
            } else {
                return json($res= ['valid' => 0, 'msg' => '分配失败']);

            }
        }
    }

    public function export() {

        $class_id = input('get.class_id');

        vendor("PHPExcel.PHPExcel");

        $objPHPExcel = new \PHPExcel();
        $class_name = classListModel::get($class_id);

        $objPHPExcel->getProperties();

        $stuData = (new \app\admin\model\Classinfo())->getExportData($class_id);

        (new classListModel)->export($objPHPExcel, $stuData, $class_name, null);

    }

    public function gradeExpot(){
        $stu_grade = input('get.stu_grade');

        vendor("PHPExcel.PHPExcel");

        $objPHPExcel = new \PHPExcel();
//        $class_name = classListModel::get($class_id);

        $objPHPExcel->getProperties();

        $stuData = student::where('stu_grade', '=', $stu_grade)->order('class_id')->select();

        (new classListModel)->export($objPHPExcel, $stuData, null, $stu_grade);
    }
}