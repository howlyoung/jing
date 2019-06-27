<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/25
 * Time: 16:15
 */

namespace app\controllers;


use app\modelex\JingTicketEx;
use yii\data\ActiveDataProvider;

class AdminTicketController extends AdminController
{

    public function actionIndex() {
        $request = \Yii::$app->request;

        $list = JingTicketEx::getListByStatus();

        $query = JingTicketEx::find()->select(['*'])->where('1=1');

        $data['list'] = $list;
        $data['provider'] = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 20
                ]
            ]
        );
//        $data['typeList'] = [
//            '普通' => 0,
//            '专票' => 1,
//        ];

        return $this->render('index',$data);
    }

    public function actionExport() {

    }
}