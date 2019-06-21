<?php

namespace app\lib\service;

use \linslin\yii2\curl\Curl;
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/17
 * Time: 16:32
 */
class WeixinService
{
    public $loginUrl;
    public $appId;
    public $appSecret;

    public function loginByCode($code) {
//        $curl = new Curl();
//        $respone = $curl->setGetParams(
//            [
//                'appid' => $this->appId,
//                'secret'=> $this->appSecret,
//                'js_code'=> $code,
//            ]
//        )->get($this->loginUrl);
        $respone = $this->request($code);
        return $respone;
    }

    protected function request($code) {
        $data = [
            'appid' => $this->appId,
            'secret'=> $this->appSecret,
            'js_code'=> $code,
        ];
        $url = $this->loginUrl.'?'.http_build_query($data);
        return file_get_contents($url);
    }
}