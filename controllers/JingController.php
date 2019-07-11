<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/12
 * Time: 10:00
 */

namespace app\controllers;


use app\modelex\JingUserEx;

class JingController extends AppController
{

    public $enableCsrfValidation = false;

    public function beforeAction($action) {
        if($action->id != 'login') {
            return parent::beforeAction($action);
        } else {
            return true;
        }
    }

    public function actionIndex() {
        if(!JingUserEx::checkLogin($this->token)) {
            return $this->respone(['code'=>-1,'msg'=>'需要登录']);
        }
        $user = $this->getUser();

        return json_encode(['userStatus'=>$user->getStatus()]);
    }

    public function actionLoad() {
        error_log(var_export($_POST,true)."\n",3,'upload.log');
        print_r($_FILES);
    }

    public function actionLogin() {
        $request = \Yii::$app->request;
        $code = $request->get('code');
        $service = \Yii::$app->weixin;

        $res = $service->loginByCode($code);
        $data = json_decode($res,true);
        $openid = $data['openid'];
        $sk = $data['session_key'];

        $user = JingUserEx::loadByOpenid($openid);
        if(empty($user)) {
            //创建用户并登陆
            $user = new JingUserEx();
            $user->openid = $openid;
            $user->dt_create = date('Y-m-d H:i:s',time());
            $user->save();
        }
        $token = $user->login($sk);

        return $this->respone(['code'=>1,'data'=>['token'=>$token,'userStatus'=>$user->status]]);
    }

    public function actionTest() {
        $openid = 'onkn74i96Ea79Q-0JpEnW4Ky4xeU';
        $user = JingUserEx::loadByOpenid($openid);
        $user->login('sdfsdf');
    }

    public function actionCheckStatus() {
        if(!JingUserEx::checkLogin($this->token)) {
            return $this->respone(['code'=>0]);
        } else {
            $user = $this->getUser();
            return $this->respone(['code'=>1,'data'=>['userStatus'=>$user->status]]);
        }
    }

    public function actionAuth() {
        $user = $this->getUser();
//        $user->setStatus(JingUserEx::STATUS_USER_CONFIRM);
        $user->setStatus(JingUserEx::STATUS_COMPLETE);
        return $this->respone(['code'=>1,'data'=>['userStatus'=>$user->status]]);
    }
}