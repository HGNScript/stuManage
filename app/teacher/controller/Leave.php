<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/25
 * Time: 15:29
 */

namespace app\teacher\controller;



class Leave extends BaseController {

    public function index()
    {
        $class_id = input('get.class_id');
        $leave_flag = input('get.leave_flag');

        $class = \app\admin\model\Classlist::get($class_id);

        $leave = (new \app\student\model\Leave)->where('class_id', $class_id)
            ->where('leave_flag', $leave_flag)
            ->order('create_time desc')
            ->select();

        $this->assign('leave', $leave);
        $this->assign('leave_flag', $leave_flag);
        $this->assign('class_id', $class_id);
        $this->assign('class', $class);
        return $this->fetch();
    }

    public function search() {
        $search = input('post.search');
        $class_id = input('post.class_id');
        $leave_flag = input('post.leave_flag');

        $data = (new \app\teacher\model\Leave())->search($search, $leave_flag, $class_id);

        return json($data);
    }

    public function examine()
    {
        $leave_id = input('get.leave_id');

        $leave = \app\teacher\model\Leave::get($leave_id);

        $this->assign('leave', $leave);
        return $this->fetch();
    }

    public function examineRequest()
    {
        $leave_flag = input('post.leave_flag');
        $leave_id = input('post.leave_id');

        $leave = \app\teacher\model\Leave::get($leave_id);

        $res = (new \app\teacher\model\Leave())->save(['leave_flag' => $leave_flag], ['leave_id' => $leave_id]);

        if ($res) {
            if($leave_flag == 2) {
                $paramsArr = ["已通过"];
            } else {
                $paramsArr = ["未通过"];
            }

            $res = (new \app\teacher\model\Leave())->sms($leave['stu_phone'], $paramsArr, 127661);
            return $res;

        } else {
            return json($res = ['valid' => 0, 'msg' => '服务器出现错误']);
        }

    }
}