<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/11
 * Time: 20:37
 */

namespace app\admin\controller;


use app\admin\validate\Psd;
use app\lib\exception\LoginException;
use app\lib\exception\ParameterException;
use app\teacher\model\BaseModel;
use think\Controller;
use app\admin\model\Login as loginModel;
use app\admin\validate\Login as loginValidate;
use think\Session;

class Login extends Controller {
    public function login() {
        if (request()->isAjax()) {

            $admin_number = input('post.admin_number');
            $admin_password = input('post.admin_password');

            $validate = (new loginValidate())->goCheck();
            if (is_object($validate)) {
                return json($validate);
            }

            $admin = (new loginModel())->getAdmin($admin_number, $admin_password);
            if (!$admin) {
                return new LoginException();
            }

            Session::set('admin.admin_name',$admin['admin_name']);
            Session::set('admin.admin_id',$admin['admin_id']);
            Session::set('admin.admin_authority',$admin['admin_authority']);
        }

        return $this->fetch();
    }


    public function editPsd(){
        if (request()->isAjax()) {
            $data = input('post.');

            $validate = (new Psd())->goCheck();

            if (is_object($validate)) {
                return json($validate);
            }

            $phone = (new \app\admin\model\Admin())->validatePhone($data['admin_numBer'], $data['admin_phone']);

            if (!$phone) {
                return new ParameterException([
                    'msg' => '联系电话不正确',
                ]);
            }

            if ($data['validate'] != $data['validateVal']) {
                return new ParameterException([
                    'msg' => '验证码不正确',
                ]);
            }

            $res = (new \app\admin\model\Admin)->psd($data);

            if ($res || $res == 0) {
                return new ParameterException([
                    'code' => '0',
                    'msg' => '密码重置成功',
                ]);
            } else {
                return new ParameterException([
                    'code' => '500',
                    'msg' => '密码重置失败',
                ]);
            }
        }
        return $this->fetch();
    }

    public function getValidate() {
        $data = input('post.');

        $admin_phone = input('post.admin_phone');
        $randNumber = rand(1000, 9999);

        $phone = (new \app\admin\model\Admin())->validatePhone($data['admin_numBer'], $data['admin_phone']);

        if (!$phone) {
            $res = ['valid' => 0, 'msg' => '联系电话不正确'];
            return json(['res' => $res, 'validate' => $randNumber]);
        }

        $res = (new \app\admin\model\Login())->getValidate($admin_phone, $randNumber);

        return json(['res' => $res, 'validate' => $randNumber]);

    }

}