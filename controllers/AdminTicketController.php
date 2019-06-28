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
        $request = \Yii::$app->request;

        $id = $request->get('id');
        $m = JingTicketEx::loadByPk($id);
        $dfFile = tempnam('tmp','tmp');
        $zip = new ZipFile();
        $filename = 'ticket.zip';

        if(empty($m)) {
            $list = JingTicketEx::getListByStatus();
        } else {
            $list = [$m];
        }
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