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
        $bankCode = $this->request->post('bankCode');
        $bankCard = $this->request->post('bankCard');
        $creditNo = $this->request->post('creditNo');
        $imgName = $this->request->post('imgName');

        $user = $this->getUser();
        $model = JingApplyEx::loadByUserId($user->id);

        if(empty($model)) {
            $model = new JingApplyEx();
        }

        $model->bank_code = $bankCode;
        $model->bank_card = $bankCard;
        $model->credit_no = $creditNo;
        $model->dt_update = date('Y-m-d H:i:s',time());
        $model->save();

        $upload = new Upload();
        $upload->imageFile = UploadedFile::getInstanceByName('imageFile');

        if($path = $upload->upload()) {
            $filed = $this->map($imgName);
            $model->$filed = $path;
            $model->save();
        }
    }

    public function actionGetApply() {
        $user = $this->getUser();

        $model = JingApplyEx::loadByUserId($user->id);
        if(!empty($model)) {
            return $this->respone(['code'=>1,'data'=>$model->getFields()]);
        } else {
            return $this->respone(['code'=>1,'data'=>'']);
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
            'id_card_u' => 'id_card_u',
            'id_card_d' => 'id_card_d',
            'current' => 'scene_photo',
            'passport' => 'bus_passport',
        ];
        return $arr[$name];
    }
}