<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/25
 * Time: 15:29
 */

namespace app\teacher\controller;


use think\Controller;

class Leave extends Controller
{

    public function index()
    {
        $class_id = input('get.class_id');
        $leave_flag = input('get.leave_flag');
        $leave_flag_top = input('get.leave_flag_top');

        $class = \app\admin\model\Classlist::get($class_id);


        $leave = (new \app\student\model\Leave)
            ->where('class_id', $class_id)
            ->where('leave_flag', $leave_flag)
            ->where('leave_flag_top', '=', '')
            ->order('create_time desc')
            ->select();

        $this->assign('leave', $leave);
        $this->assign('leave_flag', $leave_flag);
        $this->assign('class_id', $class_id);
        $this->assign('class', $class);
        return $this->fetch();
    }

    public function search()
    {
        $search = input('post.search');
        $class_id = input('post.class_id');
        $leave_flag = input('post.leave_flag');
        $leave_flag_top = input('post.leave_flag_top');
        $month = input('post.month');

        if ($search) {
            $data = (new \app\teacher\model\Leave())->search($search, $leave_flag, $class_id, $leave_flag_top);

        }

        if ($month) {

            $data = (new \app\teacher\model\Leave())->getClassLeave($class_id, $leave_flag, $leave_flag_top);
            foreach ($data as $key => $value) {
                $value = $value->toArray();
                $monthNumber = $value['create_time'];
                $monthNumber = substr($monthNumber, 6, 1);
                if ($monthNumber != $month) {
                    unset($data[$key]);
                }
            }

        }

        if ($search && $month) {
            $data = (new \app\teacher\model\Leave())->search($search, $leave_flag, $class_id, $leave_flag_top);
            foreach ($data as $key => $value) {
                $value = $value->toArray();
                $monthNumber = $value['create_time'];
                $monthNumber = substr($monthNumber, 6, 1);
                if ($monthNumber != $month) {
                    unset($data[$key]);
                }
            }
        }

        return json($data);
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


    public function examineRequest()
    {
        $leave_flag = input('post.leave_flag');
        $leave_id = input('post.leave_id');
        $leave_flag_top = input('post.leave_flag_top');

        $leave = \app\teacher\model\Leave::get($leave_id);


        if ($leave_flag_top) {
            $res = (new \app\teacher\model\Leave())->save(['leave_flag' => $leave_flag, 'leave_flag_top' => $leave_flag_top], ['leave_id' => $leave_id]);
        } else {
            $res = (new \app\teacher\model\Leave())->save(['leave_flag' => $leave_flag], ['leave_id' => $leave_id]);
        }




        if ($res) {
            if ($leave_flag == 2) {
                $paramsArr = ["已通过"];
            } else {
                $paramsArr = ["未通过"];
            }

            if ($leave_flag_top == 4) {
                $phone = db('admin')->where('admin_authority', '=', 100)->value('admin_phone');

                $res = (new \app\teacher\model\Leave())->sms($phone, $paramsArr, 127661);

            }else if($leave_flag_top == 5){
                $phone = db('admin')->where('admin_authority', '=', 101)->value('admin_phone');

                $res = (new \app\teacher\model\Leave())->sms($phone, $paramsArr, 127661);

            } else {

                $res = (new \app\teacher\model\Leave())->sms($leave['stu_phone'], $paramsArr, 127661);
            }
            return $res;

        } else {
            return json($res = ['valid' => 0, 'msg' => '服务器出现错误']);
        }

    }
}