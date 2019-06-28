<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/21
 * Time: 14:29
 */

namespace app\controllers;


use app\lib\tools\ZipFile;
use app\modelex\JingApplyEx;
use app\modelex\JingUserEx;
use app\models\Upload;
use yii\web\UploadedFile;
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
//        $data['typeList'] = [
//            '普通' => 0,
//            '专票' => 1,
//        ];

        return $this->render('index',$data);
    }

    public function actionUpdate() {
        $request = \Yii::$app->request;

        $id = $request->get('id');
        $model = JingApplyEx::loadByPk($id);

        return $this->render('update',[
            'model' => $model,
            'typeList' => [
                '普通',
                '专票',
            ]
        ]);
    }

    public function actionDoUpdate() {
        $request = \Yii::$app->request;

        $id = $request->post('id');
        $model = JingApplyEx::loadByPk($id);

        $model->ticket_content = $request->post('ticketContent');
        $model->person_name = $request->post('personName');
        $model->ticket_type = $request->post('type');
        $model->bus_type = $request->post('busType');
        $model->bus_range = $request->post('busRange');

        $model->save();

        $upload = new Upload();
        $upload->imageFile = UploadedFile::getInstanceByName('imageFile');

        if($path = $upload->upload()) {
            $model->bus_passport = $path;
            $model->save();
        }

        return $this->redirect(['admin-apply/update','id'=>$id]);
    }

    public function actionAjaxConfirm() {
        $request = \Yii::$app->request;
        $id = $request->get('id');

        $model = JingApplyEx::loadByPk($id);
        $user = JingUserEx::loadByPk($model->user_id);
        if(empty($model)) {
            return json_encode(['code'=>-1,'msg'=>'申请不存在']);
        } else {
            $model->confirm();
            $user->setStatus(JingUserEx::STATUS_AUTHING); //改变用户状态

            return $this->redirect(['admin-apply/index']);
        }
    }

    public function actionExport() {
        $request = \Yii::$app->request;

        $id = $request->get('id');
        $m = JingApplyEx::loadByPk($id);
        $dfFile = tempnam('tmp','tmp');
        $zip = new ZipFile();
        $filename = 'data.zip';

//        $images = [
//            [
//                'image_src' => $model->three_agreement, 'image_name' => '123.jpg'
//            ],
//            [
//                'image_src' => $model->entrust_agent, 'image_name' => '456.jpg'
//            ],
//        ];
        if(empty($m)) {
            $list = JingApplyEx::getListByStatus();
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
//        $imgArr = $model->getImageRes();
//
//        foreach($imgArr as $ik => $path) {
//            if(!empty($path)) {
//                $images[] = [
//                    'image_src' => $path, 'image_name' => $model->id.'_'.$ik.'.jpg'
//                ];
//            }
//        }

        foreach($images as $image) {
            $zip->add_file(file_get_contents($image['image_src']),$image['image_name']);
        }
        $delimiter = ',';
        $arr = [];

//        $list = JingApplyEx::getListByStatus();

        $arr[] = '="个体户名称"';
        $arr[] = $delimiter . '="行业类别"';
        $arr[] = $delimiter . '="经营范围"';
        $arr[] = $delimiter . '="发票内容"';
        $arr[] = $delimiter . '="银行卡号"';
        $arr[] = $delimiter . '="开户行"';
        $arr[] = $delimiter . '="状态"';
        $arr[] = $delimiter . '="创建时间"';
        $arr[] = "\n";

        foreach($list as $k=>$apply) {
            $arr[] = '="' . $apply->person_name . '"';
            $arr[] = $delimiter.'="' . $apply->bus_type . '"';
            $arr[] = $delimiter .'="' .$apply->bus_range . '"';
            $arr[] = $delimiter .'="' . $apply->ticket_content . '"';
            $arr[] = $delimiter .'="' . $apply->bank_card . '"';
            $arr[] = $delimiter .'="' . $apply->bank_code . '"';
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