<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/12
 * Time: 15:04
 */

namespace app\admin\model;


use app\lib\exception\ParameterException;
use think\Model;
use think\Session;

class Grade extends Model {
    protected $pk = 'grade_id';
    protected $table = 'grade';

    public function getGrade() {
        $grade = $this->select();
        return $grade;
    }
    public function addGrade($data) {
        $grade = $this->where('grade_name', $data['grade_name'])->find();
        if ($grade) {
            return 0;
        }
        return $this->save($data);

    }
    public function delGrade($grade, $password) {
        $admin_id = Session::get('admin.admin_id');
        $flag = (new Admin())->where('admin_id', $admin_id)->where('admin_password', md5($password))->find();

        if ($flag) {
            $class_id = (new Classlist())->where('class_grade', $grade)->column('class_id');
            (new Classlist())->where('class_grade', $grade)->delete();

            foreach ($class_id as $key => $value) {
                (new Classinfo())->where('class_id', $value)->delete();
            }


            return $this->where('grade_name',$grade)->delete();
        }else {
            return 0;
        }
    }
}