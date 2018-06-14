<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/12
 * Time: 10:52
 */

namespace app\teacher\controller;


use think\Controller;
use think\Session;

class BaseController extends Controller {
    protected function _initialize() {
        if (!Session::get('teacher.classtch_id')) {
            $this->redirect('/tchLogin');
        }
    }
}