<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/27
 * Time: 14:01
 */

namespace app\teacher\controller;


use think\Controller;
use think\Session;

class Reduction extends Controller {
    protected function _initialize() {
        if (!Session::get('teacher.tch_id') && !Session::get('admin.admin_id') ) {
            $this->redirect('/tchLogin');
        }
    }


    public function index()
    {
        $class_id = input('get.class_id');
        $reduction_flag = input('get.reduction_flag');

        $class = \app\admin\model\Classlist::get($class_id);

        $reduction = (new \app\teacher\model\reduction())->getClassReduction($class_id, $reduction_flag);

        $this->assign('reduction', $reduction);
        $this->assign('reduction_flag', $reduction_flag);
        $this->assign('class_id', $class_id);
        $this->assign('class', $class);

        return $this->fetch();
    }

    public function search() {
        $search = input('post.search');
        $class_id = input('post.class_id');
        $reduction_flag = input('post.reduction_flag');

        $data = (new \app\teacher\model\reduction())->search($search, $reduction_flag, $class_id);

        return json($data);
    }

    public function examine()
    {
        $reduction_id = input('get.reduction_id');

        $reduction = \app\teacher\model\reduction::get($reduction_id);

        $this->assign('reduction', $reduction);
        return $this->fetch();
    }

    public function examineRequest()
    {
        $reduction_flag = input('post.reduction_flag');
        $reduction_id = input('post.reduction_id');

        $reduction = \app\teacher\model\reduction::get($reduction_id);

        $res = (new \app\teacher\model\reduction())->save(['reduction_flag' => $reduction_flag], ['reduction_id' => $reduction_id]);

        if ($res) {
            if($reduction_flag == 2) {
                $paramsArr = ["已通过"];
            } else {
                $paramsArr = ["未通过"];
            }

            $res = (new \app\teacher\model\reduction())->sms($reduction['stu_phone'], $paramsArr);
            return $res;

        } else {
            return json($res = ['valid' => 0, 'msg' => '服务器出现错误']);
        }

    }
}