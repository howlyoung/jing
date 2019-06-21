<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/21
 * Time: 14:29
 */

namespace app\controllers;


use app\modelex\JingApplyEx;
use yii\data\ActiveDataProvider;

class AdminApplyController extends AdminController
{
    public function actionIndex() {
        $request = \Yii::$app->request;

        $list = JingApplyEx::getListByStatus();

        $query = JingApplyEx::find()->select(['*'])->where('1=1');

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

    public function export() {

    }
}