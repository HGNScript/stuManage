<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/28
 * Time: 17:06
 */

namespace app\teacher\model;


class reduction extends BaseModel {
    protected $pk = 'reduction_id';
    protected $table = 'reduction';

    public function getClassReduction($class_id, $reduction_flag) {
        return $this->alias('r')
            ->join('student s','r.stu_id = s.stu_id')
            ->join('class c','c.class_id = s.class_id')
            ->where('c.class_id', $class_id)
            ->where('r.reduction_flag', $reduction_flag)
            ->order('r.create_time desc')
            ->select();
    }

    public function search($search, $reduction_flag, $class_id) {
        return  $this->alias('r')
            ->join('student s','r.stu_id = s.stu_id')
            ->join('class c','s.class_id = c.class_id')
            ->where('r.stu_name','like', "%".$search."%")
            ->where('r.reduction_flag', $reduction_flag)
            ->where('s.class_id', $class_id)
            ->order('r.create_time desc')
            ->select();
    }

    public function getReduction($grant_id) {
        return $this->alias('r')
                    ->join('student s','r.stu_id = s.stu_id')
                    ->where('r.reduction_id', $grant_id)->find();
    }
}