<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/27
 * Time: 14:01
 */

namespace app\teacher\controller;


use app\student\model\student;
use think\Controller;
use think\Session;

class Grant extends Controller {

    protected function _initialize() {
        if (!Session::get('teacher.tch_id') && !Session::get('admin.admin_id') ) {
            $this->redirect('/tchLogin');
        }
    }

    public function index()
    {
        $class_id = input('get.class_id');
        $grant_flag = input('get.grant_flag');

        $class = \app\admin\model\Classlist::get($class_id);

        $grant = (new \app\teacher\model\Grant())->getClassGrant($class_id, $grant_flag);

        $this->assign('grant', $grant);
        $this->assign('grant_flag', $grant_flag);
        $this->assign('class_id', $class_id);
        $this->assign('class', $class);

        return $this->fetch();
    }

    public function search() {
        $search = input('post.search');
        $class_id = input('post.class_id');
        $grant_flag = input('post.grant_flag');

        $data = (new \app\teacher\model\Grant())->search($search, $grant_flag, $class_id);

        return json($data);
    }


    public function examine()
    {
        $grant_id = input('get.grant_id');

        $grant = \app\teacher\model\Grant::get($grant_id);
        $class_id = (new student())->where('stu_id', $grant['stu_id'])->value('class_id');

        $this->assign('grant', $grant);
        $this->assign('stuinfo', null);
        $this->assign('class_id', $class_id);
        return $this->fetch();
    }

    public function examineRequest()
    {
        $grant_flag = input('post.grant_flag');
        $grant_id = input('post.grant_id');

        $grant = \app\teacher\model\Grant::get($grant_id);

        $res = (new \app\teacher\model\Grant())->save(['grant_flag' => $grant_flag], ['grant_id' => $grant_id]);

        if ($res) {
            if($grant_flag == 2) {
                $paramsArr = ["已通过"];
            } else {
                $paramsArr = ["未通过"];
            }

            $res = (new \app\teacher\model\Leave())->sms($grant['stu_phone'], $paramsArr, 131678);
            return $res;

        } else {
            return json($res = ['valid' => 0, 'msg' => '服务器出现错误']);
        }

    }
}