<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/22
 * Time: 20:03
 */

namespace app\student\model;


use think\Model;

class grant extends Model {

    protected $pk = 'grant_id';
    protected $table = 'grant';
    protected $autoWriteTimestamp = true;

    public function submitGrant($data){

        $grant = $this->where('stu_id', $data['stu_id'])->find();


        if ($grant) {

            return $this->allowField(true)->save($data, ['stu_id' => $data['stu_id']]);

        } else{

            return $this->allowField(true)->save($data);
        }
    }

    public function getGrant($stu_id) {
        return $this->alias('g')
                    ->join('student s','g.stu_id = s.stu_id', 'left')
                    ->join('class c','s.class_id = c.class_id')
                    ->where('s.stu_id', $stu_id)->find();
    }
}