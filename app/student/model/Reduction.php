<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/24
 * Time: 8:46
 */

namespace app\student\model;


use think\Model;

class Reduction extends Model {
    protected $pk = 'reduction_id';
    protected $table = 'reduction';
    protected $autoWriteTimestamp = true;

    public function submitReduction($data){

        $grant = $this->where('stu_id', $data['stu_id'])->find();

        if ($grant) {

            return $this->allowField(true)->save($data, ['stu_id' => $data['stu_id']]);

        } else{

            return $this->allowField(true)->save($data);
        }
    }

    public function getReduction($stu_id) {
        return $this->alias('r')
                    ->join('student s','r.stu_id = s.stu_id', 'left')
                    ->where('s.stu_id', $stu_id)->find();
    }
}