<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/10
 * Time: 22:17
 */

namespace app\admin\model;


use think\Model;

class Login extends Model {
    protected $pk = 'admin_id';
    protected $table = 'admin';

    public function getAdmin($admin_number, $admin_password) {
        $data =[
            'admin_number' => $admin_number,
            'admin_password' => md5($admin_password),
        ];
        $admin = $this->where([
            'admin_number' => $data['admin_number'],
            'admin_password' => $data['admin_password'],
        ])->find();
        return $admin;

    }

    public function getValidate($admin_phone, $randNumber) {

        $paramsArr = [$randNumber];

        $res = (new BaseModel())->sms($admin_phone, $paramsArr, 131681);

        return $res;
    }
}