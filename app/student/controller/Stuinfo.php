<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/18
 * Time: 15:57
 */

namespace app\student\controller;


use app\student\model\student;
use app\student\validate\Info;
use app\student\validate\Retiredsoldier;
use app\student\validate\gzhk;

class Stuinfo extends BaseController {
    public function index(){
        $stu_id = session('student.stu_id');
        $stuinfo = (new student())->getStuInfo($stu_id);

        $card = $stuinfo['stu_identity'];

        $stu_birthday = strlen($card)==15 ? ('19' . substr($card, 6, 6)) : substr($card, 6, 8);

        $stuinfo['stu_birthday'] = $stu_birthday;

        $this->assign('stuinfo', $stuinfo);
        return $this->fetch();
    }

    public function upload() {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('images');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                return json( $res = ['url' => '/uploads/'. $info->getSaveName()]);
            }else{
                // 上传失败获取错误信息
                return json($res = ['url' => $file->getError()]);
            }
        }
    }

    public function stuInfoKeep(){
        $info = input('post.');


        $Info = (new Info())->goCheck();
        if (is_object($Info)) {
            return json($Info);
        }

        if ($info['stu_retiredsoldier'] == '是') {
            $Info = (new Retiredsoldier())->goCheck();
            if (is_object($Info)) {
                return json($Info);
            }
        }

        // if ($info['stu_dormFlag'] == '是') {
        //     $Info = (new DormFlag())->goCheck();
        //     if (is_object($Info)) {
        //         return json($Info);
        //     }
        // } else {
        //     $info['stu_dormnumber'] = '';
        // }

        if ($info['stu_guangzhouHukou']) {
            $Info = (new gzhk())->goCheck();
            if (is_object($Info)) {
                return json($Info);
            }
        } else {
            $info['stu_guangzhouprimaryschool'] = '';
        }


        $stu_infoflag = input('get.stu_infoflag');
        $stu_id = session('student.stu_id');

        $res = (new student())->upDataInfo($info, $stu_id, $stu_infoflag);
        if ($res || $res == 0) {
            if ($stu_infoflag) {
                return json($res = ['valid' => 1, 'msg' => '提交成功']);
            } else {
                return json($res = ['valid' => 1, 'msg' => '保存成功']);
            }
        } else {
            if ($stu_infoflag) {
                return json($res = ['valid' => 0, 'msg' => '提交失败']);
            } else {
                return json($res = ['valid' => 0, 'msg' => '保存失败']);
            }

        }
    }

    public function getHK(){
        $code = input('post.code');
        $HK = (new student())->getHK_address($code);

        if ($HK) {
            return json(['HK' => $HK, 'valid' => 1]);
        } else {
            return json(['msg' => '获取户口所在地出现异常，请检查身份证号码是否填写正确', 'valid' => 0]);
        }


    }



}