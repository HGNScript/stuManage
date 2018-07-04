<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/13
 * Time: 13:17
 */

namespace app\admin\model;


use think\Model;
use app\admin\model\BaseModel;

class Classtch extends BaseModel {
    protected $pk = 'classtch_id';
    protected $table = 'classtch';

    protected $auto = ['classtch_password'];

    public function setClasstchPasswordAttr($value)
    {
        return md5('gzcj');
    }

    public function gettch($staffRoom) {
        return $this->where('classtch_staffRoom', $staffRoom)->select();
    }

    public function getClasstch($data) {
        if ($data['search']) {
            $classtch = $this->where('classtch_staffRoom','=',$data['staffRoom'])
                            ->where('classtch_number|classtch_name','like',"%".$data['search']."%")
                            ->select();
        } else {
            $classtch = $this->where('classtch_staffRoom', $data['staffRoom'])->select();
        }


        return $classtch;

    }

    public function excelAddClasstch($info, $staffRoom) {
        if($info){
                $exclePath = $info->getSaveName();  //获取文件名
                $file_name = ROOT_PATH . 'public' . DS . 'excel' . DS . $exclePath;   //上传文件的地址
                $objReader =\PHPExcel_IOFactory::createReader('Excel2007');
                $obj_PHPExcel =$objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8
                $excel_array=$obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
                array_shift($excel_array);  //删除第一个数组(标题);
                $data = [];
                $i = 0;
                foreach($excel_array as $k=>$v) {
                    $n = $this->where('classtch_number', $v[0])->find();
                    if (!$n) {
                        $data[$k]['classtch_number'] = trim($v[0]);
                        $data[$k]['classtch_name'] = $v[1];
                        $data[$k]['classtch_phone'] = $v[2];
                        $data[$k]['classtch_email'] = $v[3];
                        $data[$k]['classtch_staffRoom'] = $staffRoom;
                        $data[$k]['classtch_password'] = md5('gzcj');
                    }
                    $i++;
                }
                $data = $this->arrOnly($data, 'classtch_number');

                $success=$this->saveAll($data); //批量插入数据
                $success = sizeof($success);

                $error=$i-$success;
                if ($success) {
                    return  $res = ['valid' => 1, 'msg' => "共导入{$i}条，成功{$success}条，失败{$error}条。"];
                } else {
                    return  $res = ['valid' => 0, 'msg' => "共导入{$i}条，成功{$success}条，失败{$error}条。"];
                }
            }else{
                // 上传失败获取错误信息
                return  $res = ['valid' => 0, 'msg' => $file->getError()];
            }
    }

    public function addAndEditClasstch($data, $classtch_id) {

        if ($classtch_id) {
            $n = $this->where('classtch_id', '<>', $classtch_id)->where('classtch_number', $data['classtch_number'])->find();
            $a = (new Admin)->where('admin_number', $data['classtch_number'])->find();
            if ($n || $a) {
                return $res = ['valid' => 0, 'msg' => '工号不能重复'];
            } else {
                $res = $this->save($data, ['classtch_id' => $classtch_id]);
                if ($res) {
                    return $res = ['valid' => 1, 'msg' => '编辑成功'];
                } else {
                    return $res = ['valid' => 0, 'msg' => '编辑失败'];
                }
            }
        } else {
            $n = $this->where('classtch_number', $data['classtch_number'])->find();
            $a = (new Admin)->where('admin_number', $data['classtch_number'])->find();
                if ($n || $a) {
                     return $res = ['valid' => 0, 'msg' => '工号不能重复'];
                } else {
                    $res = $this->save($data);
                    if ($res) {
                        return $res = ['valid' => 1, 'msg' => '添加成功'];
                    } else {
                        return $res = ['valid' => 0, 'msg' => '添加失败'];
                    }
                }
        }
    }

    public function getOldClasstch($classtch_id) {
        return $this->where('classtch_id', $classtch_id)->find();
    }
}