<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/18
 * Time: 14:34
 */

namespace app\student\model;


use app\admin\model\Hk;
use think\Model;

class student extends Model {

    protected $pk = 'stu_id';
    protected $table = 'student';

    public function getLoginStu($number, $password) {
        return $this->where('stu_number', $number)->where('stu_password', md5($password))->find();
    }

    public function getStuInfo($stu_id) {
        return $this->alias('s')
                    ->join('class c','s.class_id = c.class_id')
                    ->join('grant g','s.stu_id = g.stu_id', 'left')
                    ->where('s.stu_id', $stu_id)->find();
    }

    public function editPsd($data, $stu_id) {
        $oldpsd = $this->where('stu_password', md5($data['oldtch_psw']))
            ->where('stu_id', $stu_id)->find();
        if (!$oldpsd) {
            return $res = ['valid' => 0, 'msg' => '旧密码不正确'];
        } else {
            if ($data['newtch_psw'] == $data['newtch_psws']) {
                return $this->save(['stu_password' => md5($data['newtch_psw'])], ['stu_id' => $stu_id]);
            } else {
                return $res = ['valid' => 0, 'msg' => '两次新密码不一致'];
            }
        }
    }

    public function upDataInfo($info, $stu_id, $stu_infoflag){

        $grant = grant::where('stu_id', $stu_id)->find();
        $reduction = Reduction::where('stu_id', $stu_id)->find();

        $info['stu_id'] = $stu_id;

        $info['stu_infoflag'] = $stu_infoflag;


        $class_id = (new classModel())->stuGetClass($info['class_name']);
        $info['class_id'] = $class_id;

       
        if ($grant) {
            (new grant())->allowField(true)->save($info,['stu_id' => $stu_id]);
        } else {
            (new grant())->allowField(true)->save($info);   
        }

        if ($reduction) {
            (new Reduction())->allowField(true)->save($info,['stu_id' => $stu_id]);
        } else {
            (new Reduction())->allowField(true)->save($info);
        }

        return $this->allowField(true)->save($info,['stu_id' => $stu_id]);

    }





    public function dbClickEdit($stu_id, $name, $val) {
        if (!$val) {
            return 0;
        }
        return $this->save([$name => $val],['stu_id' => $stu_id]);
    }

    public function psd($data) {
        return $this->where('stu_number', $data['stu_numBer'])
            ->update(['stu_password' => md5($data['newtch_psws'])]);
    }

    public function validatePhone($stu_numBer, $stu_phone) {
        return $this->where('stu_number',$stu_numBer)->where('stu_phone',$stu_phone)->find();
    }

    public function getHK_address($code){
        return Hk::where('hk_code', $code)->value('hk_address');
    }

}