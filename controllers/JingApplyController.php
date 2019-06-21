<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/19
 * Time: 15:05
 */

namespace app\controllers;


use app\modelex\JingApplyEx;
use app\modelex\JingUserEx;
use app\models\Upload;

use yii\web\UploadedFile;

class JingApplyController extends AppController
{
    public $enableCsrfValidation = false;

    public function actionCreate() {
        if(!JingUserEx::checkLogin($this->token)) {
            return $this->respone(['code'=>-1]);
        }

        $name = $this->request->post('name');
        $mobile = $this->request->post('mobile');
        $imgName = $this->request->post('imgName');

        $model = JingApplyEx::loadByMobile($mobile);

        if(empty($model)) {
            $model = new JingApplyEx();
            $model->name = $name;
            $model->mobile = $mobile;
            $model->save();
        }


        $upload = new Upload();
        $upload->imageFile = UploadedFile::getInstanceByName('imageFile');

        if($path = $upload->upload()) {
            $filed = $this->map($imgName);
            $model->$filed = $path;
            $model->save();
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    protected function map($name) {
        $arr = [
            'argeement' => 'three_agreement',
            'agent' => 'entrust_agent',
            'id_card_u' => 'id_card',
            'id_card_d' => '',
            'current' => 'true_photo',
            'passport' => 'bus_passport',
        ];
        return $arr[$name];
    }
}