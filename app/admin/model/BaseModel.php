<?php
/**
 * Created by PhpStorm.
 * User: HGN
 * Date: 18/5/12
 * Time: 12:00
 */

namespace app\admin\model;


use think\Model;
use sms\SmsMultiSender;

class BaseModel extends Model {

    public function arrOnly($data, $onlyItem){
        $datao = [];
        foreach ($data as $key => $value) {
            $datao[$key] = $value[$onlyItem];
        }
        foreach ($datao as $key => $v) {
            $arr = $datao;
            unset($arr[$key]);
            if (in_array($datao[$key], $arr)) {
                unset($datao[$key]);
            }
        }
        $claInfo = [];
        foreach ($data as $key => $value) {
            foreach ($datao as $k => $va) {
                if ($key == $k) {
                    array_push($claInfo, $value);
                }
            }
        }
        return $claInfo;
    }

    public function sms($phone, $paramsArr, $templId) {
        $appid = 1400095432;
        $appkey = "9aeee6eea3a684068f66f651f9b26f48";
        $phone = [$phone];
        $templId = $templId;


        try {
            $sender = new SmsMultiSender($appid, $appkey);
            $params = $paramsArr;
            // 假设模板内容为：测试短信，{1}，{2}，{3}，上学。
            $result = $sender->sendWithParam("86", $phone, $templId,
                $params, "", "", "");
            $rsp = json_decode($result);
            return $res = ['valid' => 1, 'msg' => $rsp];

        } catch (\Exception $e) {

            return $res = ['valid' => 0 , 'msg' => var_dump($e)];
        }
    }
}