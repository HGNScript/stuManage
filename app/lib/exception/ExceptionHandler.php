<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/10
 * Time: 21:41
 */

namespace app\lib\exception;


use think\Config;
use think\Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle {
    private $code;
    private $msg;
    private $errorCode;

     // public function render(Exception $e) {
     //     if ($e instanceof BaseException) {
     //         $this->code = $e->code;
     //         $this->msg = $e->msg;
     //         $this->errorCode = $e->errorCode;
     //     } else {
     //         if (Config::get('app_debug')) {
     //             return parent::render($e);
     //         } else {
     //             $this->code = 500;
     //             $this->msg = '服务器内部异常';
     //             $this->errorCode = 999;
     //             $this->recordErrorLog($e);
     //         }

     //     }

     //     $request = Request::instance();

     //     $res = [
     //         'msg' => $this->msg,
     //         'error_code' => $this->errorCode,
     //         'request_url' => $request->url(),
     //     ];

     //     return json($res, $this->code);
     // }

 //    初始化日志, 创建日志
     private function  recordErrorLog(Exception $e) {
         Log::init([
             'type' => 'File',
             'path'  => LOG_PATH,
             'level' => ['error'],
         ]);
         Log::record($e->getMessage(), 'error');
     }

}