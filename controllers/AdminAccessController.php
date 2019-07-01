<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/25
 * Time: 16:10
 */

namespace app\controllers;


use app\lib\tools\ZipFile;
use app\modelex\JingAccessEx;
use app\modelex\JingApplyEx;
use app\modelex\JingUserEx;
use yii\data\ActiveDataProvider;

class AdminAccessController extends AdminController
{

    public function actionIndex() {
        $request = \Yii::$app->request;
//        $list = JingAccessEx::getListByStatus();
        $data['status'] = $request->get('status');
        $data['searchName'] = $request->get('searchName');
        $data['mobile'] = $request->get('mobile');

//        $query = JingAccessEx::find()->select(['*'])->where('1=1');
//        if(!empty($data['status'])) {
//            $query->andWhere(['status'=>$data['status']]);
//        }
//        if(!empty($data['searchName'])) {
//            $query->andWhere(['like','name',$data['searchName']]);
//        }
//        if(!empty($data['mobile'])) {
//            $query->andWhere(['like','mobile',$data['mobile']]);
//        }
        $data['statusList'] = JingAccessEx::getStatusList();

        $query = $this->getQuery($data);
        $query->orderBy([
            'dt_create' => SORT_DESC
        ]);
        $data['list'] = $query->all();
        $data['provider'] = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 20
                ]
            ]
        );

        return $this->render('index',$data);
    }

    /**
     * @param $params
     * @return $this
     */
    protected function getQuery($params) {
        $query = JingAccessEx::find()->select(['*'])->where('1=1');
        if(!empty($params['status'])) {
            $query->andWhere(['status'=>$params['status']]);
        }
        if(!empty($params['searchName'])) {
            $query->andWhere(['like','name',$params['searchName']]);
        }
        if(!empty($params['mobile'])) {
            $query->andWhere(['like','mobile',$params['mobile']]);
        }
        return $query;
    }

    public function actionAjaxConfirm() {
        $request = \Yii::$app->request;
        $id = $request->get('id');
        $model = JingAccessEx::loadByPk($id);
        $user = JingUserEx::loadByPk($model->user_id);
        if(empty($model)) {
            return json_encode(['code'=>-1,'msg'=>'申请不存在']);
        } else {
            $model->confirm();
            $user->setStatus(JingUserEx::STATUS_REGISTER); //改变用户状态
            $apply = new JingApplyEx();
            $apply->person_name = $model->name;
            $apply->user_id = $user->id;
            $apply->save();
            return $this->redirect(['admin-access/index']);
        }
    }

    public function actionExport() {
        $request = \Yii::$app->request;

        $param['status'] = $request->get('status');
        $param['searchName'] = $request->get('searchName');
        $param['mobile'] = $request->get('mobile');

        $query = $this->getQuery($param);
        $list = $query->all();

        $delimiter = ',';
        $arr = [];

        $arr[] = '="客户手机"';
        $arr[] = $delimiter . '="客户名称"';
        $arr[] = $delimiter . '="类型"';
        $arr[] = $delimiter . '="需求描述"';
        $arr[] = $delimiter . '="解决方案"';
        $arr[] = $delimiter . '="供需关系"';
        $arr[] = $delimiter . '="客户业务"';
        $arr[] = $delimiter . '="状态"';
        $arr[] = $delimiter . '="创建时间"';
        $arr[] = "\n";

        foreach($list as $k=>$apply) {
            $arr[] = '="' . $apply->mobile . '"';
            $arr[] = $delimiter.'="' . $apply->name . '"';
            $arr[] = $delimiter .'="' .$apply->getTypeName() . '"';
            $arr[] = $delimiter .'="' . $apply->user_demand_desc . '"';
            $arr[] = $delimiter .'="' . $apply->solution . '"';
            $arr[] = $delimiter .'="' . $apply->relation . '"';
            $arr[] = $delimiter .'="' . $apply->user_business . '"';
            $arr[] = $delimiter .'="' . $apply->getStatusName() . '"';
            $arr[] = $delimiter .'="' . $apply->dt_create . '"';
            $arr[] = "\n";
        }

        $fileName = 'jing-' . date('Y-m-d H:i:s',time()) . '-access.csv';

        header('Content-Type: text/csv; charset=GBK');
        header('Content-Disposition: attachment; filename="' . $fileName);
        header('Content-Transfer-Encoding: binary');

        echo(iconv('utf-8', 'GBK//IGNORE', implode('', $arr)));

    }
}