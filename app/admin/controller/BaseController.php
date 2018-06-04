<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/12
 * Time: 10:52
 */

namespace app\admin\controller;


use think\Controller;
use think\Session;

class BaseController extends Controller {
    protected function _initialize() {
        if (!Session::get('admin.admin_id')) {
            $this->redirect('/adminLogin');
        }
    }

}