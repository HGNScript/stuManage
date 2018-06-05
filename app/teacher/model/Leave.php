<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/25
 * Time: 21:14
 */

namespace app\teacher\model;


class Leave extends BaseModel {
    protected $pk = 'leave_id';
    protected $table = 'leave';

    public function search($search, $leave_flag, $class_id) {
        return  $this->alias('l')
            ->join('class c','l.class_id = c.class_id')
            ->where('l.leave_name','like', "%".$search."%")
            ->where('l.leave_flag', $leave_flag)
            ->where('c.class_id', $class_id)
            ->select();
    }
}