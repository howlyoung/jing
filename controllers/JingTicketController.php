<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/21
 * Time: 9:21
 */

namespace app\controllers;


use app\modelex\JingTicketEx;
use app\modelex\JingTicketTitleEx;
use app\modelex\JingUserEx;
use app\models\Upload;
use yii\web\UploadedFile;

class JingTicketController extends AppController
{

    public function actionCreate() {
        $title = $this->request->post('title');
        $amount = $this->request->post('amount');
        $expressAddress = $this->request->post('expressAddress');
        $addressee = $this->request->post('addressee');
        $consigneeMobile = $this->request->post('mobile');
        $bank = $this->request->post('bank');
        $mail = $this->request->post('mail');
        $imgName = $this->request->post('imgName');
        $flag = $this->request->post('flag');

        $model = JingTicketEx::loadByFlag($flag);
        $user = $this->getUser();

        if(empty($model)) {
            $model = new JingTicketEx();
            $ticketTitle = JingTicketTitleEx::loadByTitle($title);
            $model->ticket_title = $title;
            $model->ticket_code = $ticketTitle->ticket_code;
            $model->ticket_amount = $amount;
            $model->user_id = $user->id;
            $model->address = $expressAddress;
            $model->addressee_mobile = $consigneeMobile;
            $model->addressee = $addressee;
            $model->bankCode = $bank;
            $model->email = $mail;
            $model->random_flag = $flag;
            $model->save();
        }

        $upload = new Upload();
        $upload->imageFile = UploadedFile::getInstanceByName('imageFile');

        if($path = $upload->upload()) {
            $filed = $this->map($imgName);
            $model->$filed = $path;
            $model->save();
        }

        return $this->respone(['code'=>1]);

    }

    public function actionCreateTitle() {
        $title = $this->request->post('title');
        $code = $this->request->post('code');
        $mail = $this->request->post('mail');
        $address = $this->request->post('address');
        $addressee = $this->request->post('addressee');
        $mobile = $this->request->post('mobile');
        $bankCode = $this->request->post('bankCode');

        $model = JingTicketTitleEx::loadByTitle($title);
        if(empty($model)) {
            $model = new JingTicketTitleEx();
        }
        $user = $this->getUser();
        $model->ticket_title = $title;
        $model->ticket_code = $code;
        $model->user_id = $user->id;
        $model->address = $address;
        $model->addressee_mobile = $mobile;
        $model->email = $mail;
        $model->addressee = $addressee;
        $model->bank_code = $bankCode;

        $model->save();

        return $this->respone(['code'=>1]);
    }

    public function actionGetTitle() {
        $user = $this->getUser();
        $list = JingTicketTitleEx::getListByUid($user->id);
        $result = [];
        foreach($list as $title) {
            $tmp['title'] = $title->ticket_title;
            $tmp['code'] = $title->ticket_code;
            $tmp['expressAddress'] = $title->address;
            $tmp['addressee'] = $title->addressee;
            $tmp['mobile'] = $title->addressee_mobile;
            $tmp['mail'] = $title->email;
            $tmp['bankCode'] = $title->bank_code;
            $result[] = $tmp;
        }
        return $this->respone(['code'=>1,'data'=>$result]);
    }

    protected function map($name) {
        $arr = [
            'serviceBill' => 'service_bill',
            'amountBill' => 'amount_bill',
        ];
        return $arr[$name];
    }
}