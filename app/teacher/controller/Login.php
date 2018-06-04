<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/24
 * Time: 10:39
 */

namespace app\teacher\controller;


use app\lib\exception\LoginException;
use app\lib\exception\ParameterException;
use app\teacher\model\tch;
use app\teacher\validate\Psd;
use think\Controller;
use app\teacher\validate\Login as Loginvalidate;
use think\Session;
use think\Validate;

class Login extends Controller {
    public function login() {
        if (request()->isAjax()) {

            $classtch_number = input('post.classtch_number');
            $classtch_password = input('post.classtch_password');

            $validate = (new Loginvalidate())->goCheck();
            if (is_object($validate)) {
                return json($validate);
            }

            $teacher = (new tch())->checkUser($classtch_number, $classtch_password);

            if (!$teacher) {
                return new LoginException();
            }

            Session::set('teacher.tch_name',$teacher['classtch_name']);
            Session::set('teacher.tch_id',$teacher['classtch_id']);
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

            $phone = (new tch())->validatePhone($data['tch_numBer'], $data['tch_phone']);

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

            $res = (new tch())->psd($data);

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

        $tch_phone = input('post.tch_phone');
        $randNumber = rand(1000, 9999);

        $phone = (new tch())->validatePhone($data['tch_numBer'], $data['tch_phone']);

        if (!$phone) {
            $res = ['valid' => 0, 'msg' => '联系电话不正确'];
            return json(['res' => $res, 'validate' => $randNumber]);
        }

        $res = (new \app\admin\model\Login())->getValidate($tch_phone, $randNumber);

        return json(['res' => $res, 'validate' => $randNumber]);

    }
}