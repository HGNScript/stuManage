<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 2018/7/20
 * Time: 15:37
 */

namespace app\admin\controller;


class Leave extends BaseController
{
    public function index(){
        $leave_flag = input('get.leave_flag');
        $leave_flag_top = input('get.leave_flag_top');

        $leave = (new \app\student\model\Leave)
            ->where('leave_flag', $leave_flag)
            ->where('leave_flag_top', '=', $leave_flag_top)
            ->order('create_time desc')
            ->select();

        $this->assign('leave', $leave);
        $this->assign('leave_flag', $leave_flag);
        $this->assign('leave_flag_top', $leave_flag_top);

        return $this->fetch();
    }

    public function examine()
    {
        $leave_id = input('get.leave_id');

        $leave = \app\teacher\model\Leave::get($leave_id);

        $meridiem = $leave['meridiem'];
        $meridiemend = $leave['meridiemend'];

        $day = (new \app\teacher\model\Leave())->getDay($meridiem, $meridiemend, $leave);
        $this->assign('leave', $leave);
        $this->assign('day', $day);
        return $this->fetch();
    }
}