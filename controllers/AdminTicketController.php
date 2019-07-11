<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/25
 * Time: 16:15
 */

namespace app\controllers;


use app\lib\tools\ZipFile;
use app\modelex\JingApplyEx;
use app\modelex\JingResourseEx;
use app\modelex\JingTicketEx;
use app\models\Upload;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\UploadedFile;

class AdminTicketController extends AdminController
{

    public function actionIndex() {
        $request = \Yii::$app->request;

        $data['status'] = $request->get('status');
        $data['name'] = $request->get('name');

        $query = $this->getQuery($data);
        $query->orderBy([
            'jing_ticket.dt_create' => SORT_DESC
        ]);
        $data['list'] = $query->all();

        $data['statusList'] = JingTicketEx::getStatusList();
        $data['provider'] = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 20
                ]
            ]
        );


        return $this->render('index',$data);
    }

    public function actionUpdate() {
        $request = \Yii::$app->request;
        $id = $request->get('id');

        $model = JingTicketEx::loadByPk($id);
        $data['model'] = $model;
        $data['typeList'] = JingTicketEx::getTypeList();

        $imageList = $model->getImageRes();
        $imageKey = [
            'serviceBill' => '服务费凭证',
            'amountBill' => '打款凭证',
            'agreement' => '合作协议',
        ];
        $imagePaths = [];
        $imagesConfig = [];
        $host = \yii::$app->request->hostInfo.'/';
        foreach($imageList as $type => $image) {
            foreach($image as $img) {
                $imagePaths[$type][] = $host.$img->path;
                $imagesConfig[$type][] = [
                    'url' => Url::to(['admin-ticket/del-image','id'=>$img->id]),
                    'key' => $img->id,
                ];
            }
        }
        $data['imageList'] = $imagePaths;
        $data['imageKey'] = $imageKey;
        $data['imageListConfig'] = $imagesConfig;

        return $this->render('update',$data);
    }

    public function actionDoUpdate() {
        $request = \Yii::$app->request;

        $id = $request->post('id');
        $model = JingTicketEx::loadByPk($id);

        $model->person_name = $request->post('personName');
        $model->ticket_title = $request->post('ticketTitle');
        $model->ticket_code = $request->post('ticketCode');
        $model->receive_type = $request->post('type');
        $model->address = $request->post('address');
        $model->addressee = $request->post('addressee');
        $model->addressee_mobile = $request->post('addresseeMobile');
        $model->bankCode = $request->post('bankCode','');
        $model->bank_card = $request->post('bankCard','');
        $model->company_address = $request->post('companyAddress','');
        $model->company_tel = $request->post('companyTel','');
        $model->save();

        $typeList = [
            'serviceBill' => '服务费凭证',
            'amountBill' => '打款凭证',
            'agreement' => '合作协议',
        ];
        $images = new Upload();
        foreach($typeList as $tk=>$tName) {
            $images->imageFiles = UploadedFile::getInstancesByName($tk);
            $pathList = $images->uploads();

            foreach($pathList as $path) {
                $model->saveImage($tk, $path);
            }
        }

        return $this->redirect(['admin-ticket/update','id'=>$id]);


    }

    /**
     * @param $params
     * @return $this
     */
    protected function getQuery($params) {
        $query = JingTicketEx::find()->select(['jing_ticket.*'])->join('LEFT JOIN','jing_apply','jing_apply.user_id=jing_ticket.user_id')->where('1=1');

        if(!empty($params['name'])) {
            $query->andWhere(['like','jing_apply.person_name',$params['name']]);
        }

        if(!empty($params['status'])) {
            $query->andWhere(['status'=>$params['status']]);
        }

        return $query;
    }

    public function actionDelImage() {
        $request = \Yii::$app->request;

        $id = $request->get('id');
        $img = JingResourseEx::loadByPk($id);
        if(!empty($img)) {
            $img->delete();
        }
        return true;
    }


    public function actionAjaxConfirm() {
        $request = \Yii::$app->request;
        $id = $request->get('id');

        $model = JingTicketEx::loadByPk($id);
        if(empty($model)) {
            return json_encode(['code'=>-1,'msg'=>'申请不存在']);
        } else {
            $model->confirm();

            return $this->redirect(['admin-ticket/index']);
        }
    }

    public function actionConfirm() {
        $request = \Yii::$app->request;
        $id = $request->get('id');

        $model = JingTicketEx::loadByPk($id);
        if(empty($model)) {
            return json_encode(['code'=>-1,'msg'=>'申请不存在']);
        } else {
            $model->confirm();

            return $this->redirect(['admin-ticket/update','id'=>$id]);
        }
    }

    public function actionExport() {
        $request = \Yii::$app->request;


        $param['status'] = $request->get('status');
        $param['name'] = $request->get('name');

        $dfFile = tempnam('tmp','tmp');
        $zip = new ZipFile();
        $filename = 'ticket.zip';

        $query = $this->getQuery($param);
        $list = $query->all();
        $images = [];
        foreach($list as $model) {
            $imgArr = $model->getImageRes();
            foreach($imgArr as $ik => $path) {
                if(!empty($path)) {
                    $images[] = [
                        'image_src' => $path, 'image_name' => $model->id.'_'.$ik.'.jpg'
                    ];
                }
            }
        }
        foreach($images as $image) {
            $zip->add_file(file_get_contents($image['image_src']),$image['image_name']);
        }
        $delimiter = ',';
        $arr = [];

        $arr[] = '="个体户名称"';
        $arr[] = $delimiter . '="发票抬头"';
        $arr[] = $delimiter . '="纳税人识别号"';
        $arr[] = $delimiter . '="发票类型"';
        $arr[] = $delimiter . '="开票金额"';
        $arr[] = $delimiter . '="快递地址"';
        $arr[] = $delimiter . '="收件人"';
        $arr[] = $delimiter . '="收件人电话"';
        $arr[] = $delimiter . '="状态"';
        $arr[] = $delimiter . '="创建时间"';
        $arr[] = "\n";

        foreach($list as $k=>$apply) {
            $ap = JingApplyEx::loadByUserId($apply->user_id);
            $arr[] = '="' . $ap->person_name . '"';
            $arr[] = $delimiter.'="' . $apply->ticket_title . '"';
            $arr[] = $delimiter .'="' .$apply->ticket_code . '"';
            $arr[] = $delimiter .'="' . $apply->getTypeName() . '"';
            $arr[] = $delimiter .'="' . $apply->ticket_amount . '"';
            $arr[] = $delimiter .'="' . $apply->address . '"';
            $arr[] = $delimiter .'="' . $apply->addressee . '"';
            $arr[] = $delimiter .'="' . $apply->addressee_mobile . '"';
            $arr[] = $delimiter .'="' . $apply->getStatusName() . '"';
            $arr[] = $delimiter .'="' . $apply->dt_create . '"';
            $arr[] = "\n";
        }
        $zip->add_file(iconv('utf-8', 'GBK//IGNORE', implode('', $arr)),'file.csv');

        $zip->output($dfFile);

        ob_clean();
        header('Pragma: public');
        header('Last-Modified:'.gmdate('D, d M Y H:i:s') . 'GMT');
        header('Cache-Control:no-store, no-cache, must-revalidate');
        header('Cache-Control:pre-check=0, post-check=0, max-age=0');
        header('Content-Transfer-Encoding:binary');
        header('Content-Encoding:none');
        header('Content-type:multipart/form-data');
        header('Content-Disposition:attachment; filename="'.$filename.'"'); //设置下载的默认文件名
        header('Content-length:'. filesize($dfFile));
        $fp = fopen($dfFile, 'r');
        while(connection_status() == 0 && $buf = @fread($fp, 8192)){
            echo $buf;
        }
        fclose($fp);
        @unlink($dfFile);
        @flush();
        @ob_flush();
        exit();
    }
}