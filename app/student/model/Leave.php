<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/21
 * Time: 16:50
 */

namespace app\student\model;



use think\Model;

class Leave extends Model {

    protected $pk = 'leave_id';
    protected $table = 'leave';

    protected $autoWriteTimestamp = true;

    public function editAndAddLeave($info, $stu_id, $leave_flag){
        $class_id = student::where('stu_id', $stu_id)->value('class_id');
        $info['class_id'] = $class_id;
        $info['stu_id'] = $stu_id;
        if ($info['id']) {
            if ($leave_flag) {
                $info['leave_flag'] = $leave_flag;
                return $this->allowField(true)->save($info, ['leave_id' => $info['id']]);
            } else {
                return $this->allowField(true)->save($info, ['leave_id' => $info['id']]);
            }
        } else {
            if ($leave_flag) {
                $info['leave_flag'] = $leave_flag;
                return $this->allowField(true)->save($info);
            } else {
                return $this->allowField(true)->save($info);
            }
        }

    }

    public function getLeave($id) {
        return $this->where('stu_id', $id)->where('leave_flag', '<>', 0)->select();
    }

}