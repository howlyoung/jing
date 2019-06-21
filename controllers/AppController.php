<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/19
 * Time: 9:29
 */

namespace app\controllers;


use app\modelex\JingTokenEx;
use app\modelex\JingUserEx;

class AppController extends \yii\web\Controller
{
    protected $token;
    protected $request;

    public $enableCsrfValidation = false;

    public function beforeAction($action) {
        parent::beforeAction($action);
        $this->request = \Yii::$app->request;

        $this->token = $this->request->get('token');
        if(!JingUserEx::checkLogin($this->token)) {
            echo $this->respone(['code'=>-1,'msg'=>'请登录!']);
            return false;
        } else {
            return true;
        }
    }

    public function respone($data) {
        return json_encode($data);
    }

    /**
     * @return JingUserEx|array|null
     */
    public function getUser() {
        $token = JingTokenEx::loadByToken($this->token);
        if(empty($token)) {
            return null;
        } else {
            return JingUserEx::loadByPk($token->user_id);
        }
    }
}