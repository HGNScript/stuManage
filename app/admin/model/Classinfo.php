<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/16
 * Time: 8:57
 */

namespace app\admin\model;


class Classinfo extends BaseModel {

    protected $pk = 'stu_id';
    protected $table = 'student';

//    public function getFirstStateAttr($value) {
//        return ['val' => $value, 'text' => $this->state[$value]];
//    }
//    public function setStuPasswordAttr($value)
//    {
//        return md5('gzcj');
//    }

    public function getStu($data, $class_id){
        if ($data['search']) {
            $classstu = $this->where('class_id', $class_id)
                ->where('stu_number|stu_name','like', "%".$data["search"]."%")
                ->order('stu_number')->select();
        } else {
            $classstu = $this->where('class_id', $class_id)->order('stu_number')->select();
        }

        foreach ($classstu as $key => $value) {
            $classstu[$key]['stu_phone']?$classstu[$key]['stu_phone'] = '<span class="layui-badge layui-bg-green">'. $classstu[$key]['stu_phone'] .'</span>':$classstu[$key]['stu_phone'] = '<span class="layui-badge">未填写联系电话</span>';
        }
        return $classstu;
    }

    public function excelAddStu($info, $class_id) {
        $class_grade = (new Classlist)->where('class_id', $class_id)->find();

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
                $n = $this->where('stu_number', $v[1])->find();
                if (!$n) {
                    $data[$k]['stu_name'] = $v[0];
                    $data[$k]['stu_number'] = $v[1];
                    $data[$k]['stu_sex'] = $v[2];
                    $data[$k]['stu_identity'] = $v[3];
                    $data[$k]['stu_dormnumber'] = $v[4];
                    $data[$k]['class_id'] = $class_id;
                    $data[$k]['stu_password'] = md5('gzcj');
                    $data[$k]['stu_grade'] = $class_grade['class_grade'];
                    $data[$k]['stu_specialty'] = $class_grade['class_specialty'];

                    $card = $data[$k]['stu_identity'];

                    $stu_birthday = strlen($card)==15 ? ('19' . substr($card, 6, 6)) : substr($card, 6, 8);

                    $data[$k]['stu_birthday'] = $stu_birthday;

                    $code = substr($card, 0, 6);

                    $data[$k]['stu_hukouaddress'] = self::getHK_address($code);
                    $data[$k]['stu_hukouaddressf'] = $code;


                }
                $i++;
            }

            $data = $this->arrOnly($data, 'stu_number');

            // (new \app\student\model\grant())->allowField(true)->saveAll($data);
            // (new \app\student\model\Reduction())->allowField(true)->saveAll($data);

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
            return  $res = ['valid' => 0, 'msg' => '上传文件出错'];
        }
    }

    public function addAndEditClassStu($data, $stu_id, $class_id) {
        $class_grade = (new Classlist)->where('class_id', $class_id)->find();

        $data['stu_grade'] = $class_grade['class_grade'];
        $data['stu_specialty'] = $class_grade['class_specialty'];

        if ($stu_id) {
            $n = $this->where('stu_id', '<>', $stu_id)->where('stu_number', $data['stu_number'])->find();
            if ($n) {
                return $res = ['valid' => 0, 'msg' => '学号不能重复'];
            } else {

                $code = substr($data['stu_identity'], 0, 6);

                $data['stu_hukouaddress'] = self::getHK_address($code);
                $data['stu_hukouaddressf'] = $code;

                $res = $this->save($data, ['stu_id' => $stu_id]);
                if ($res) {
                    return $res = ['valid' => 1, 'msg' => '编辑成功'];
                } else {
                    return $res = ['valid' => 0, 'msg' => '编辑失败'];
                }
            }
        } else {
            $n = $this->where('stu_number', $data['stu_number'])->find();
            if ($n) {
                return $res = ['valid' => 0, 'msg' => '学号不能重复'];
            } else {
                $data['stu_password'] = md5('gzcj');

                $code = substr($data['stu_identity'], 0, 6);

                $data['stu_hukouaddress'] = self::getHK_address($code);
                $data['stu_hukouaddressf'] = $code;


                $res = $this->save($data);

                if ($res) {
                    return $res = ['valid' => 1, 'msg' => '添加成功'];
                } else {
                    return $res = ['valid' => 0, 'msg' => '添加失败'];
                }
            }
        }
    }

    public function getOldClassStu($stu_id) {
        return $this->where('stu_id', $stu_id)->field('stu_id, stu_number, stu_sex, stu_identity, stu_dormnumber, stu_name, class_id')->find();
    }

    public function getStuInfo($stu_id) {
        $stuInfo = $this->alias('s')
            ->join('class c','s.class_id= c.class_id','LEFT')
            ->where('s.stu_id', $stu_id)
            ->find();

        return $stuInfo;
    }

    public function getExportData($class_id){
        return $this->alias('s')
                    ->join('class c','s.class_id= c.class_id','LEFT')
                    ->where('s.class_id', $class_id)
                    ->order('s.stu_number')->select();
    }

    public function getStuInfoFlag($stu_id) {
        return $this->where('stu_id', $stu_id)->value('stu_infoflag');
    }

    protected function getHK_address($code){
        return Hk::where('hk_code', $code)->value('hk_address');
    }

}