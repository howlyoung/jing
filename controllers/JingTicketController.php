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

class JingTicketController extends AppController
{

    public function actionCreate() {
        $title = $this->request->post('title');
        $amount = $this->request->post('amount');
        $expressAddress = $this->request->post('expressAddress');
        $consignee = $this->request->post('consignee');
        $consigneeMobile = $this->request->post('consigneeMobile');

        $model = JingTicketEx::loadByTitle($title);
        if(empty($model)) {
            $model = new JingTicketEx();
        }
        $user = $this->getUser();
        $ticketTitle = JingTicketTitleEx::loadByTitle($title);
        $model->ticket_title = $title;
        $model->ticket_code = $ticketTitle->ticket_code;
        $model->ticket_amount = $amount;
        $model->user_id = $user->id;
        $model->area = $expressAddress;
        $model->shoujianren_mobile = $consigneeMobile;
        $model->shoujian = $consignee;

        $model->save();

        return $this->respone(['code'=>1]);

    }

    public function actionCreateTitle() {
        if(!JingUserEx::checkLogin($this->token)) {
            return '请登录';
        }

        $title = $this->request->post('title');
        $code = $this->request->post('code');
        $mail = $this->request->post('mail');
        $expressAddress = $this->request->post('expressAddress');
        $addressee = $this->request->post('addressee');
        $mobile = $this->request->post('mobile');

        $model = JingTicketTitleEx::loadByTitle($title);
        if(empty($model)) {
            $model = new JingTicketTitleEx();
        }
        $user = $this->getUser();
        $model->ticket_title = $title;
        $model->ticket_code = $code;
        $model->user_id = $user->id;
        $model->area = $expressAddress;
        $model->shoujianren_mobile = $mobile;

        $model->save();

        return $this->respone(['code'=>1]);
    }
}