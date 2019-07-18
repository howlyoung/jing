<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/21
 * Time: 9:21
 */

namespace app\controllers;


use app\lib\tools\CashUtil;
use app\modelex\JingApplyEx;
use app\modelex\JingResourseEx;
use app\modelex\JingTicketEx;
use app\modelex\JingTicketTitleEx;
use app\modelex\JingUserEx;
use app\models\Upload;
use yii\helpers\Url;
use yii\web\UploadedFile;

class JingTicketController extends AppController
{

    public function actionCreate() {
        $title = $this->request->post('title');
        $amount = $this->request->post('amount');
        $expressAddress = $this->request->post('expressAddress');
        $addressee = $this->request->post('addressee');
        $consigneeMobile = $this->request->post('mobile');
        $bank = $this->request->post('bankCode');
        $mail = $this->request->post('mail');
        $imgName = $this->request->post('imgName');
        $flag = $this->request->post('flag');
        $bankCard = $this->request->post('bankCard','');
        $companyAddress = $this->request->post('companyAddress','');
        $companyTel = $this->request->post('companyTel','');
        $ticketType = $this->request->post('ticketType','');
        $personName = $this->request->post('personName','');
        $content = $this->request->post('content','');

        $model = JingTicketEx::loadByFlag($flag);
        $user = $this->getUser();

        if(empty($model)) {
            $model = new JingTicketEx();
            $ticketTitle = JingTicketTitleEx::loadByTitle($title);
            $model->ticket_title = $title;
            $model->ticket_code = $ticketTitle->ticket_code;
            $model->ticket_amount = CashUtil::toSaveFmt($amount);
            $model->user_id = $user->id;
            $model->address = $expressAddress;
            $model->addressee_mobile = $consigneeMobile;
            $model->addressee = $addressee;
            $model->bankCode = $bank;
            $model->email = $mail;
            $model->random_flag = $flag;
            $model->bank_card = $bankCard;
            $model->company_address = $companyAddress;
            $model->company_tel = $companyTel;
            $model->ticket_type = $ticketType;
            $model->person_name = $personName;
            $model->ticket_content = $content;
            $model->save();
        }

        $model->saveRes($imgName, 'imageFile');

        return $this->respone(['code'=>1]);

    }

    public function actionCreateTitle() {
        $title = $this->request->post('title','');
        $code = $this->request->post('code','');
        $mail = $this->request->post('mail','');
        $address = $this->request->post('address','');
        $addressee = $this->request->post('addressee','');
        $mobile = $this->request->post('mobile','');
        $bankCode = $this->request->post('bankCode','');
        $bankCard = $this->request->post('bankCard','');
        $companyAddress = $this->request->post('companyAddress','');
        $companyTel = $this->request->post('companyTel','');


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
        $model->bank_card = $bankCard;
        $model->company_address = $companyAddress;
        $model->company_tel = $companyTel;

        $model->save();

        return $this->respone(['code'=>1]);
    }

    /**
     * 小程序获取title信息接口，同时也获取最近一次开票信息
     * @return string
     */
    public function actionGetTitle() {
        $user = $this->getUser();
        $apply = JingApplyEx::loadByUserId($user->id);
        $list = JingTicketTitleEx::getListByUid($user->id);
        $lastTicket = JingTicketEx::getLastByUserId($user->id);
        $result = [];
        foreach($list as $title) {
            $tmp['title'] = $title->ticket_title;
            $tmp['code'] = $title->ticket_code;
            $tmp['expressAddress'] = $title->address;
            $tmp['addressee'] = $title->addressee;
            $tmp['mobile'] = $title->addressee_mobile;
            $tmp['mail'] = $title->email;
            $tmp['bankCode'] = $title->bank_code;
            $tmp['bankCard'] = $title->bank_card;
            $tmp['companyAddress'] = $title->company_address;
            $tmp['companyTel'] = $title->company_tel;
            $result[] = $tmp;
        }

        if(!empty($lastTicket)) {
            foreach($result as $k => $val) {
                if($val['title'] == $lastTicket->ticket_title) {
                    $tmp = $val;
                    unset($result[$k]);
                    array_unshift($result, $tmp);
                    break;
                }
            }
        }

        $host =  Url::base(true).'/';

        return $this->respone(['code'=>1,'data'=>[
            'list'=>$result,
            'personName' => empty($apply)?'':$apply->person_name,
            'imageArr'=>[
                [
                    'id' => JingResourseEx::NAME_SERVICE_BILL,
                    'title' => '税款凭证',
                    'src' => ''
                ],
                [
                    'id' => JingResourseEx::NAME_AMOUNT_BILL,
                    'title' => '公司向个体工商户打款凭证',
                    'src' => ''
                ],
                [
                    'id' => JingResourseEx::NAME_THREE_AGREEMENT,
                    'title' => '公司与个体工商户合作协议',
                    'src' => !empty($lastTicket)?$lastTicket->getImagePathByType(JingResourseEx::NAME_THREE_AGREEMENT,$host):''
                ],
                ]
            ]
        ]);
    }

    protected function map($name) {
        $arr = [
            'serviceBill' => 'service_bill',
            'amountBill' => 'amount_bill',
        ];
        return $arr[$name];
    }
}