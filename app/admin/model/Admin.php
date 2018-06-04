<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/12
 * Time: 12:00
 */

namespace app\admin\model;


use think\Model;

class Admin extends Model {
    protected $pk = 'admin_id';
    protected $table = 'admin';

    public function getAdminInfo($admin_id) {
        return $this->where('admin_id', $admin_id)->find();
    }


    public function editInfo($data, $admin_id) {
        return $this->save($data, ['admin_id' => $admin_id]);

    }

    public function editPsd($data, $admin_id) {
        $oldpsd = $this->where('admin_password', md5($data['oldtch_psw']))
            ->where('admin_id', $admin_id)->find();
        if (!$oldpsd) {
            return $res = ['valid' => 0, 'msg' => '旧密码不正确'];
        } else {
            if ($data['newtch_psw'] == $data['newtch_psws']) {
                return $this->save(['admin_password' => md5($data['newtch_psw'])], ['admin_id' => $admin_id]);
            } else {
                return $res = ['valid' => 0, 'msg' => '两次新密码不一致'];
            }
        }

    }

    public function psd($data) {
        return $this->where('admin_number', $data['admin_numBer'])
                    ->update(['admin_password' => md5($data['newtch_psws'])]);
    }

    public function validatePhone($admin_numBer,$admin_phone) {
        return $this->where('admin_number',$admin_numBer)->where('admin_phone',$admin_phone)->find();
    }
}