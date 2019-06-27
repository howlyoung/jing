<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/21
 * Time: 14:23
 */

namespace app\controllers;


use yii\web\Controller;
use yii;

class AdminController extends Controller
{
    public function beforeAction($action) {
        parent::beforeAction($action);
        if(yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        return true;
    }
}