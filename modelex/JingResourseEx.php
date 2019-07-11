<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/7/8
 * Time: 9:23
 */

namespace app\modelex;


use app\models\JingResourse;

class JingResourseEx extends JingResourse
{

    const TYPE_APPLY = 0;   //申请表的图片
    const TYPE_TICKET = 1;  //发票的图片

    const NAME_ID_CARD_U = 'id_card_u';              //身份证正面
    const NAME_ID_CARD_D = 'id_card_d';              //身份证反面
    const NAME_THREE_AGREEMENT = 'agreement';        //三方协议
    const NAME_ENTRUST_AGENT = 'agent';          //委托代理证明
    const NAME_SCENE_PHOTO = 'current';            //现场照片
    const NAME_BUS_PASSPORT = 'passport';           //营业执照

    const NAME_SERVICE_BILL = 'serviceBill';        //服务费凭据
    const NAME_AMOUNT_BILL = 'amountBill';        //打款凭据

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            if($this->isNewRecord) {
                $this->dt_create = date("Y-m-d H:i:s",time());
            }
            return true;
        }
        return false;
    }

    /**
     * @param $type
     * @param $referId
     * @param $name
     * @param $path
     * @return JingResourseEx|null
     */
    public static function create($type, $referId, $name, $path) {
        $model = new self();
        $model->res_type = $type;
        $model->refer_id = $referId;
        $model->res_name = $name;
        $model->path = $path;
        $model->dt_create = date('Y-m-d H:i:s', time());
        $model->save();
        $error = $model->getErrors();
        return empty($error)?$model:null;
    }

    /**
     * @param $pk
     * @return JingResourseEx|array|null
     */
    public static function loadByPk($pk) {
        return self::find()->select(['*'])->where(['id'=>$pk])->one();
    }

    /**
     * @param $type
     * @param $name
     * @param $referId
     * @return self[]|array
     */
    public static function loadAllByTypeAndNameAndReferId($type, $name ,$referId) {
        return self::find()->select(['*'])->where(['res_type'=>$type, 'res_name'=>$name, 'refer_id'=>$referId])->all();
    }

    /**
     * @param $type
     * @param $name
     * @param $referId
     * @param $host
     * @return array
     */
    public static function getPathByTypeAndNameAndReferId($type, $name ,$referId, $host='') {
        $arr = self::loadAllByTypeAndNameAndReferId($type, $name ,$referId);
        $paths = [];
        foreach($arr as $p) {
            $paths[$p->id] = $host.$p->path;
        }
        return $paths;
    }

    /**
     * @return array
     */
    public static function getTypeNameList() {
        return [
            'argeement' => '三方协议',
            'agent' => '代理协议',
            'id_card_u' => '身份证正面',
            'id_card_d' => '身份反面',
            'current' => '现场照',
            'passport' => '营业执照',
        ];
    }
}