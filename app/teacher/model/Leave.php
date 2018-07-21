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


    public function getClassLeave($class_id, $leave_flag, $leave_flag_top) {
        if (!$leave_flag_top) {
            return $this->alias('l')
                ->join('student s','l.stu_id = s.stu_id')
                ->join('class c','s.class_id = c.class_id')
                ->where('c.class_id', $class_id)
                ->where('l.leave_flag', $leave_flag)
                ->where('l.leave_flag_top', '')
                ->order('l.create_time desc')
                ->select();
        } else {
            return $this->alias('l')
                ->where('l.leave_flag', $leave_flag)
                ->where('l.leave_flag_top', $leave_flag_top)
                ->order('l.create_time desc')
                ->select();
        }

    }

    public function search($search, $leave_flag, $class_id, $leave_flag_top) {
        if (!$leave_flag_top) {
            return  $this->alias('l')
                ->join('class c','l.class_id = c.class_id')
                ->where('l.leave_name','like', "%".$search."%")
                ->where('l.leave_flag', $leave_flag)
                ->where('l.leave_flag_top', '')
                ->where('c.class_id', $class_id)
                ->order('l.create_time desc')
                ->select();
        } else {
            return  $this->alias('l')
                ->where('l.leave_name','like', "%".$search."%")
                ->where('l.leave_flag', $leave_flag)
                ->where('l.leave_flag_top', $leave_flag_top)
                ->order('l.create_time desc')
                ->select();
        }

    }


    //获取请假时间的天数
    public function getDay($meridiem, $meridiemend, $leave){
        if ($meridiem == '下午') {
            $startTime = strtotime($leave['leave_startTime']) - 43200;

        } else {
            $startTime = strtotime($leave['leave_startTime']);
        }

        if ($meridiemend == '下午') {
            $endTime = strtotime($leave['leave_endTime']) - 43200;

        }else {
            $endTime = strtotime($leave['leave_endTime']);

        }

        $day = ($endTime - $startTime) / 86400;

        return $day;
    }
}