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


}