<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/13
 * Time: 12:26
 */

namespace app\admin\controller;

use app\admin\model\Classtch as classtchModel;
use app\admin\validate\AddClasstch;

class Classtch extends BaseController {

    public function index() {

        if (request()->isAjax()) {
            $data = input('post.');

            $classtch = (new classtchModel())->getClasstch($data);
            return json($classtch);

        }

        $staffRoom = input('get.staffRoom');
        $this->assign('staffRoom',$staffRoom);
        return $this->fetch();
    }

    /**
     * 以excel 表格导入班主任数据
     */
    public function excelAddClasstch() {
        //import('phpexcel.PHPExcel', EXTEND_PATH);//方法二
            vendor("PHPExcel.PHPExcel"); //方法一
            $objPHPExcel = new \PHPExcel();

            //获取表单上传文件
            $file = request()->file('excel');
            $info = $file->validate(['size'=>80000,'ext'=>'xlsx,xls,csv'])->move(ROOT_PATH . 'public' . DS . 'excel');
            $staffRoom = input('get.staffRoom');
            $res = (new classtchModel())->excelAddClasstch($info, $staffRoom);
            return json($res);
    }

    /**
     * 添加 and 编辑班主任
     */
    public function addAndEditClasstch(){
        if (request()->isAjax()) {
            $data = input('post.');
            $classtch_id = input('get.classtch_id');
            $validate = (new AddClasstch())->goCheck();
            if ($validate) {
                if (is_object($validate)) {
                    return json($validate);
                }
            }
            $res = (new classtchModel)->addAndEditClasstch($data, $classtch_id);
            return json($res);
        }
    }
    /**
     * 添加页面
     */
    public function addClasstch(){
        $staffRoom = input('get.staffRoom');
        $this->assign('staffRoom', $staffRoom);
        return $this->fetch();
    }

    /**
     * 编辑页面
     */
    public function editClasstch() {
        $staffRoom = input('get.staffRoom');
        $classtch_id = input('get.classtch_id');
        $oldClasstch = (new classtchModel)->getOldClasstch($classtch_id);
        $this->assign('staffRoom', $staffRoom);
        $this->assign('oldClasstch', $oldClasstch);
        return $this->fetch();
    }

    /**
     * 删除教师数据
     */
    public function delClasstch() {
        $classtch_id = input('post.');
        $classtchModel = new classtchModel;
        $res = classtchModel::destroy($classtch_id);
        if ($res) {
            return json($res = ['valid' => 1, 'msg' => '删除成功']);
        }
    }
}
