<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/27
 * Time: 14:07
 */

namespace app\teacher\model;


class Grant extends BaseModel {
    protected $pk = 'grant_id';
    protected $table = 'grant';

    public function getClassGrant($class_id, $grant_flag) {
        return $this->alias('g')
            ->join('student s','g.stu_id = s.stu_id')
            ->join('class c','s.class_id = c.class_id')
            ->where('c.class_id', $class_id)
            ->where('g.grant_flag', $grant_flag)
            ->order('g.create_time desc')
            ->select();
    }

    public function search($search, $grant_flag, $class_id) {
        return  $this->alias('g')
            ->join('student s','g.stu_id = s.stu_id')
            ->join('class c','s.class_id = c.class_id')
            ->where('s.stu_name','like', "%".$search."%")
            ->where('g.grant_flag', $grant_flag)
            ->where('c.class_id', $class_id)
            ->order('g.update_time  desc')
            ->select();
    }

    public function getGrant($grant_id) {
        return $this->alias('g')
                    ->join('student s','g.stu_id = s.stu_id')
                    ->where('g.grant_id', $grant_id)->find();
    }
}