<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/11
 * Time: 10:06
 */

namespace app\controllers;


use app\modelex\JingAccessEx;
use app\modelex\JingUserEx;

class JingAccessController extends AppController
{

    public function actionIndex() {
        $request = \Yii::$app->request;
        $token = $request->get('token');

    }

    public function actionCreate() {
        if(!JingUserEx::checkLogin($this->token)) {
            return '请登录';
        }

        $user = $this->getUser();
        $request = \Yii::$app->request;
        $name = $request->post('name');
        $mobile = $request->post('mobile');
        $type = $request->post('type');
        $desc = $request->post('desc','');
        $solution = $request->post('solution','');
        $business = $request->post('business','');
        $relation = $request->post('relation','');
        $extend = $request->post('extend','');
        $extendChannel = $request->post('extendChannel','');

        $access = new JingAccessEx();
        $access->user_id = $user->id;
        $access->name = $name;
        $access->mobile = $mobile;
        $access->user_type = $type;
        $access->user_demand_desc = $desc;
        $access->user_business = $business;
        $access->solution = $solution;
        $access->relation = $relation;
        $access->referrer = $extend;
        $access->marker_channel = $extendChannel;
        $access->dt_create = date('Y-m-d H:i:s',time());
        $access->dt_update = date('Y-m-d H:i:s',time());
        $access->save();

        $user->setStatus(JingUserEx::STATUS_INITIAL);

        return $this->respone(['code'=>1,'data'=>['userStatus'=>$user->status]]);
    }

}