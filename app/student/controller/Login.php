<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/11
 * Time: 20:37
 */

namespace app\student\controller;

use app\lib\exception\LoginException;
use app\lib\exception\ParameterException;
use app\student\model\student;
use app\student\validate\Psd;
use think\Controller;
use think\Session;
use app\student\validate\Login as loginValidate;

class Login extends Controller {
    public function login() {
        if (request()->isAjax()) {

            $number = input('post.number');
            $password = input('post.password');

            $validate = (new loginValidate())->goCheck();
            if (is_object($validate)) {
                return json($validate);
            }

            $student = (new student())->getLoginStu($number, $password);
            if (!$student) {
                return new LoginException();
            }

            Session::set('student.stu_name',$student['stu_name']);
            Session::set('student.stu_id',$student['stu_id']);
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

            $phone = (new student())->validatePhone($data['stu_numBer'], $data['stu_phone']);

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

            $res = (new student())->psd($data);

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

        $stu_phone = input('post.stu_phone');
        $randNumber = rand(1000, 9999);

        $phone = (new student())->validatePhone($data['stu_numBer'], $data['stu_phone']);

        if (!$phone) {
            $res = ['valid' => 0, 'msg' => '联系电话不正确'];
            return json(['res' => $res, 'validate' => $randNumber]);
        }

        $res = (new \app\admin\model\Login())->getValidate($stu_phone, $randNumber);

        return json(['res' => $res, 'validate' => $randNumber]);

    }

}