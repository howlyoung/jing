<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/25
 * Time: 16:10
 */

namespace app\controllers;


use app\modelex\JingAccessEx;
use app\modelex\JingApplyEx;
use app\modelex\JingUserEx;
use yii\data\ActiveDataProvider;

class AdminAccessController extends AdminController
{

    public function actionIndex() {
        $request = \Yii::$app->request;
        $list = JingAccessEx::getListByStatus();

        $query = JingAccessEx::find()->select(['*'])->where('1=1');

        $data['list'] = $list;
        $data['provider'] = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 20
                ]
            ]
        );

        return $this->render('index',$data);
    }

    public function actionAjaxConfirm() {
        $request = \Yii::$app->request;
        $id = $request->get('id');
        $model = JingAccessEx::loadByPk($id);
        $user = JingUserEx::loadByPk($model->user_id);
        if(empty($model)) {
            return json_encode(['code'=>-1,'msg'=>'申请不存在']);
        } else {
            $model->confirm();
            $user->setStatus(JingUserEx::STATUS_REGISTER); //改变用户状态
            $apply = new JingApplyEx();
            $apply->person_name = $model->name;
            $apply->user_id = $user->id;
            $apply->save();
            return $this->redirect(['admin-access/index']);
        }
    }
}