<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/14
 * Time: 10:57
 */

namespace app\admin\model;


use app\student\model\classModel;

class Classlist extends BaseModel {

    protected $pk = 'class_id';
    protected $table = 'class';

    public function getClass($data, $classtch) {

        if ($data['search']) {
            $classlist = $this->alias('c')
                        ->join('classtch t','c.classtch_id = t.classtch_id', 'left')
                        ->where('c.class_staffRoom','=',$data['staffRoom'])
                        ->where('c.class_name|c.class_specialty|t.classtch_name','like',"%".$data['search']."%")
                        ->where('c.class_grade',$data['grade'])
                        ->select();
        } else {
            $classlist = $this->alias('c')
                        ->join('classtch t','c.classtch_id = t.classtch_id','LEFT')
                        ->where('c.class_staffRoom', $data['staffRoom'])
                        ->where('c.class_grade',$data['grade'])
                        ->select();
        }

        $tchdata = (array)$classtch;
        $option = '';

        foreach ($tchdata as $key => $va) {
            $option .= '<option value="'.$va['classtch_id'].'">'. $va['classtch_name'] .'</option>';
        }

        foreach ($classlist as $key => $value) {
            if (!$value['classtch_name']) {
                $value['classtch_name'] = '<select name="city" lay-verify="" class="addTch">
                                              <option value="">请选择一个教师</option>'
                                              .$option.
                                            '</select>';
            }
        }


            return $classlist;
    }

    public function excelAddClasslist($file, $info, $staffRoom, $grade) {
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
                    // $n = $this->where('class_name', $v[0])->find();
                    // if (!$n) {
                    $data[$k]['class_name'] = trim($v[0]);
                    $data[$k]['class_specialty'] = trim($v[1]);
                    $data[$k]['class_grade'] = $grade;
                        $data[$k]['class_staffRoom'] = $staffRoom;;
                    // }
                    $i++;
                }
                $data = $this->arrOnly($data, 'class_name');

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





    public function addAndEditClasslist($data, $class_id) {
        if ($class_id) {
            $res = $this->save($data, ['class_id' => $class_id]);
            if ($res) {
                return $res = ['valid' => 1, 'msg' => '编辑成功'];
            } else {
                return $res = ['valid' => 0, 'msg' => '编辑失败'];
            }
        } else {
            $n = $this->where('class_name', $data['class_name'])->find();
            if ($n) {
                return $res = ['valid' => 0, 'msg' => '班级名称不能重复'];
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

    public function getOldClasslist($class_id) {
        return $this->alias('c')
                    ->join('classtch t','c.classtch_id = t.classtch_id','LEFT')
                    ->where('c.class_id', $class_id)
                    ->find();
    }

    public function export($objPHPExcel, $stuData, $class_name ,$stu_grade) {
        $header=[
            '学习形式',
            '姓名',
            '身份证号',
            '性别',
            '出生日期',
            '民族',
            '联系电话',
            '政治面貌',
            '户口所在地',
            '户口性质',
            '学习专业名称',
            '毕业学校',
            '招生年份',
            '招生季度',
            '班级',
            '专业级别',
            '入学前文化程度',
            '学制',
            '家庭联系人',
            '家庭联系电话',
            '家庭年总收入',
            '家庭人均收入',
            '是否10万以下民族',
            '是否家庭困难',
            '是否低保',
            '收入来源',
            '邮政编码',
            '学号',
            '国别',
            '证件类型',
            '户口地址',
            // '是否住宿',
            // '国家编号',
            // '省编号',
            // '联合办学',
            '是否退役士兵',
            '入学总分',
            // '是否应届',
            // '扶贫',
            '宿舍号',
            '办学点名称',
            '学生类别',
            '户口区域',
            '户籍所在地',
            '是否三侨生',
            '学生状态',
            '原部队',
            '原军衔',
            '入伍地',
            '入伍时间',
            '退伍时间',
            '退役方式',
            '健康状况',
            // '地区',
            '广州市户口地区',
            '原毕业学校（广州市就填写）',
            '原毕业学校生源省',
            '原毕业学校生源市',
        ];
        $charactors = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

        foreach ($header as $key => $v) {
            if ($key >= sizeof($charactors)) {
                $headermin = array_slice($header,26);
                foreach ($headermin as $k => $value) {
                    if ($k >= sizeof($charactors)) {
                        $headermin = array_slice($headermin,26);
                        foreach ($headermin as $ke => $va) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$charactors[$ke].'1', $va);
                        }
                    } else {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$charactors[$k].'1', $value);
                    }

                }
            } else {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($charactors[$key].'1', $v);
            }

        }

        $col = 2;
        $objActSheet = $objPHPExcel->getActiveSheet();

        foreach ($stuData as $key => $rows) { // 行写入

            $class = self::get($rows['class_id']);


            $arr = [];
            array_push($arr, $rows['stu_studystyle']);
            array_push($arr, $rows['stu_name']);
            array_push($arr, $rows['stu_identity'] . "\t");
            array_push($arr, $rows['stu_sex']);


            $card = $rows['stu_identity'];

            $stu_birthday = strlen($card)==15 ? ('19' . substr($card, 6, 6)) : substr($card, 6, 8);
            array_push($arr, $stu_birthday);
            array_push($arr, $rows['stu_nation']);
            array_push($arr, $rows['stu_phone'] . "\t");
            array_push($arr, $rows['stu_politicalstatus']);
            array_push($arr, $rows['stu_hukouaddress']);
            array_push($arr, $rows['stu_hokoustyle']);
            array_push($arr, $rows['stu_specialty']);
            array_push($arr, $rows['stu_graduation']);
            array_push($arr, $rows['stu_grade']);
            array_push($arr, $rows['stu_enrollmentquarter']);
            array_push($arr, $class['class_name']);
            array_push($arr, $rows['stu_professionallevel']);
            array_push($arr, $rows['stu_Preschooleducation']);
            array_push($arr, $rows['stu_schoolsystem']);
            array_push($arr, $rows['stu_familycontact']);
            array_push($arr, $rows['stu_familyphone'] . "\t");
            array_push($arr, $rows['stu_totalannualincomefamily'] . "\t");
            array_push($arr, $rows['stu_percapitaincomefamily'] . "\t");
            array_push($arr, $rows['stu_100thousand']);
            array_push($arr, $rows['stu_familydifficulties']);
            array_push($arr, $rows['stu_familylow']);
            array_push($arr, $rows['stu_sourceincome']);
            array_push($arr, $rows['stu_postalcode'] . "\t");
            array_push($arr, $rows['stu_number'] . "\t");
            array_push($arr, $rows['stu_differentcountries']);
            array_push($arr, $rows['stu_certificatestyle']);
            array_push($arr, $rows['stu_hukouaddresstow']);
            // array_push($arr, $rows['stu_dormFlag']);
            // array_push($arr, 1);
            // array_push($arr, 1);
            // array_push($arr, $rows['stu_lhbx']);

            array_push($arr, $rows['stu_retiredsoldier']);
            array_push($arr, $rows['stu_totalentrancescore']);
            // array_push($arr, $rows['stu_yj']);
            // array_push($arr, $rows['stu_fp']);
            array_push($arr, $rows['stu_dormnumber']);
            array_push($arr, $rows['stu_nameofschoolrunningpoint']);
            array_push($arr, $rows['stu_classstudents']);
            array_push($arr, $rows['stu_hukouquyu']);
            array_push($arr, $rows['stu_hukouaddressf'] . "\t");
            array_push($arr, $rows['stu_sanqiao']);
            array_push($arr, $rows['stu_state']);
            array_push($arr, $rows['stu_originaltroops']);
            array_push($arr, $rows['stu_originalmilitaryrank']);
            array_push($arr, $rows['stu_enlist']);
            array_push($arr, $rows['stu_enlisttime']);
            array_push($arr, $rows['stu_demobilizedtime']);
            array_push($arr, $rows['stu_demobilizedstyle']);
            array_push($arr, $rows['stu_health']);
            // array_push($arr, $rows['stu_area']);
            array_push($arr, $rows['stu_guangzhouHukou']);
            array_push($arr, $rows['stu_guangzhouprimaryschool']);
            array_push($arr, $rows['stu_sourceprovince']);
            array_push($arr, $rows['stu_shengyuancity']);
            
  

            foreach ($arr as $key => $value) { // 列写入
                if ($key >= sizeof($charactors)) {
                    $headermin = array_slice($header,26);
                    $arrmin = array_slice($arr,26);
                    foreach ($headermin as $k => $v) {

                        if ($k >= sizeof($charactors)) {
                            $headermin = array_slice($headermin,26);
                            $arrmin = array_slice($arrmin,26);
                            foreach ($headermin as $ke => $va) {
                                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$charactors[$ke].$col, $arrmin[$ke]);
                            }
                        } else {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$charactors[$k].$col, $arrmin[$k]);
                        }
                    }
                } else {
                    $objActSheet->setCellValue($charactors[$key].$col, $value);
                }
            }

            $col++;
        }

        $objPHPExcel->setActiveSheetIndex(0); // 设置活动单指数到第一个表,所以Excel打开这是第一个表

        if ($class_name) {
            $fileName = $class_name['class_grade']."级".$class_name['class_name'].'.xls';
        } else {
            $fileName = $stu_grade."级".'.xls';
        }

        $fileName = rawurlencode($fileName);

        header('Content-Disposition: attachment;filename='.$fileName);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output'); // 文件通过浏览器下载
        exit;
    }
}