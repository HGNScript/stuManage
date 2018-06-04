<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/11
 * Time: 13:00
 */

namespace app\teacher\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate {
    public function goCheck() {
        //必须设置contetn-type:application/json
        $request = Request::instance();
//        $params = input('param.');
        $result = $this->check($request->param());

        if (!$result) {
            $exception = new ParameterException([
                'msg' => $this->error,
//                'code' => '',
//                'errerCode' => '',
            ]);
            return $exception;
        } else {
            return true;
        }
    }
}