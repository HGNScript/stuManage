<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/18
 * Time: 22:43
 */
namespace app\student\model;

use think\Model;


class classModel extends Model {
    protected $pk = 'class_id';
    protected $table = 'class';

    public function stuGetClass($class_name) {
        return $this->where('class_name', $class_name)->value('class_id');
    }
}