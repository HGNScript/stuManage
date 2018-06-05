<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/24
 * Time: 11:18
 */

namespace app\teacher\model;


use think\Model;

class tch extends Model {
    protected $pk = 'classtch_id';
    protected $table = 'classtch';

    public function checkUser($classtch_number, $classtch_password) {
        $data =[
            'classtch_number' => $classtch_number,
            'classtch_password' => md5($classtch_password),
        ];
        $teacher = $this->where([
            'classtch_number' => $data['classtch_number'],
            'classtch_password' => $data['classtch_password'],
        ])->find();

        return $teacher;
    }

    public function editInfo($data, $classtch_id){
        return $this->save($data, ['classtch_id' => $classtch_id]);
    }

    public function editPsd($data, $classtch_id) {
        $oldpsd = $this->where('classtch_password', md5($data['oldtch_psw']))
            ->where('classtch_id', $classtch_id)->find();
        if (!$oldpsd) {
            return $res = ['valid' => 0, 'msg' => '旧密码不正确'];
        } else {
            if ($data['newtch_psw'] == $data['newtch_psws']) {
                return $this->save(['classtch_password' => md5($data['newtch_psw'])], ['classtch_id' => $classtch_id]);
            } else {
                return $res = ['valid' => 0, 'msg' => '两次新密码不一致'];
            }
        }

    }

    public function psd($data) {
        return $this->where('classtch_number', $data['tch_numBer'])
            ->update(['classtch_password' => md5($data['newtch_psws'])]);
    }

    public function validatePhone($tch_numBer, $tch_phone) {
        return $this->where('classtch_number',$tch_numBer)->where('classtch_phone',$tch_phone)->find();
    }

    public function notice ($classtch_id){
        $class_id = (new classModel())->where('classtch_id', $classtch_id)->column('class_id');

        $arr = [];
        foreach ($class_id as $key => $v) {
            $class_name = (new classModel())->where('class_id', $v)->value('class_name');

            $grant = (new classModel())->alias('c')
                ->join('student s','c.class_id = s.class_id')
                ->join('grant g','s.stu_id = g.stu_id')
                ->where('c.class_name', $class_name)
                ->where('g.grant_flag', 1)
                ->select();

            $leave = (new classModel())->alias('c')
                ->join('student s','c.class_id = s.class_id')
                ->join('leave l','s.stu_id = l.stu_id')
                ->where('c.class_name', $class_name)
                ->where('l.leave_flag', 1)
                ->select();

            $reduction = (new classModel())->alias('c')
                ->join('student s','c.class_id = s.class_id')
                ->join('reduction r','s.stu_id = r.stu_id')
                ->where('c.class_name', $class_name)
                ->where('r.reduction_flag', 1)
                ->select();

            $arr[$key]['grant'] = sizeof($grant);
            $arr[$key]['leave'] = sizeof($leave);
            $arr[$key]['reduction'] = sizeof($reduction);
            $arr[$key]['class_name'] = $class_name;
        }

        return $arr;
    }

    public function classNotice($class_id) {
        $class_name = (new classModel())->where('class_id', $class_id)->value('class_name');

        $grant = (new classModel())->alias('c')
            ->join('student s','c.class_id = s.class_id')
            ->join('grant g','s.stu_id = g.stu_id')
            ->where('c.class_name', $class_name)
            ->where('g.grant_flag', 1)
            ->select();

        $leave = (new classModel())->alias('c')
            ->join('student s','c.class_id = s.class_id')
            ->join('leave l','s.stu_id = l.stu_id')
            ->where('c.class_name', $class_name)
            ->where('l.leave_flag', 1)
            ->select();

        $reduction = (new classModel())->alias('c')
            ->join('student s','c.class_id = s.class_id')
            ->join('reduction r','s.stu_id = r.stu_id')
            ->where('c.class_name', $class_name)
            ->where('r.reduction_flag', 1)
            ->select();

        $arr['grant'] = sizeof($grant);
        $arr['leave'] = sizeof($leave);
        $arr['reduction'] = sizeof($reduction);
        $arr['class_name'] = $class_name;

        return $arr;

    }



}