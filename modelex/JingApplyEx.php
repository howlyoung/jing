<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/19
 * Time: 15:39
 */

namespace app\modelex;


use app\models\JingApply;
use app\models\Upload;
use yii\web\UploadedFile;

class JingApplyEx extends JingApply
{
    const STATUS_WAIT = 0;  //待审核
    const STATUS_FIRST_PASS = 1;    //初审通过
    const STATUS_FIRST_FAIL = 2;    //不通过
    const STATUS_COMPLETE = 3;      //完成

    const TYPE_COMMON = 0;  //普通票
    const TYPE_SPECIAL = 1; //专票

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            if($this->isNewRecord) {
                $this->dt_create = date("Y-m-d H:i:s",time());
                $this->dt_update = date("Y-m-d H:i:s",time());
            } else {
                $this->dt_update = date("Y-m-d H:i:s",time());
            }
            return true;
        }
        return false;
    }
    /**
     * @param $mobile
     * @return self|array|null
     */
    public static function loadByMobile($mobile) {
        return self::find()->select(['*'])->where(['mobile'=>$mobile])->one();
    }

    /**
     * @param $pk
     * @return self|array|null
     */
    public static function loadByPk($pk) {
        return self::find()->select(['*'])->where(['id'=>$pk])->one();
    }

    /**
     * @param string $status
     * @return \app\models\self[]|array
     */
    public static function getListByStatus($status='') {
        if(empty($status)) {
            return self::find()->select(['*'])->all();
        } else {
            return self::find()->select(['*'])->where(['status'=>$status])->all();
        }
    }

    /**
     * @param $uid
     * @return JingApplyEx|array|null
     */
    public static function loadByUserId($uid) {
        return self::find()->select(['*'])->where(['user_id'=>$uid])->one();
    }

    /**
     * @return array
     */
    public function getFields() {
        $host = \yii::$app->request->hostInfo.'/jing/web/';
        return [
            'agreement' => JingResourseEx::getPathByTypeAndNameAndReferId(JingResourseEx::TYPE_APPLY, JingResourseEx::NAME_THREE_AGREEMENT, $this->id, $host),
            'agent' => JingResourseEx::getPathByTypeAndNameAndReferId(JingResourseEx::TYPE_APPLY, JingResourseEx::NAME_ENTRUST_AGENT, $this->id, $host),
            'id_card_u' => JingResourseEx::getPathByTypeAndNameAndReferId(JingResourseEx::TYPE_APPLY, JingResourseEx::NAME_ID_CARD_U, $this->id, $host),
            'id_card_d' => JingResourseEx::getPathByTypeAndNameAndReferId(JingResourseEx::TYPE_APPLY, JingResourseEx::NAME_ID_CARD_D, $this->id, $host),
            'current' => JingResourseEx::getPathByTypeAndNameAndReferId(JingResourseEx::TYPE_APPLY, JingResourseEx::NAME_SCENE_PHOTO, $this->id, $host),
            'passport' => JingResourseEx::getPathByTypeAndNameAndReferId(JingResourseEx::TYPE_APPLY, JingResourseEx::NAME_BUS_PASSPORT, $this->id, $host),
            'bankCard' => $this->bank_card,
            'bankCode' => $this->bank_code,
            'ticketContent' => $this->ticket_content,
            'ticketType' => $this->getTypeName(),
            'busRange' => $this->bus_range,
            'busType' => $this->bus_type,
            'personName' => $this->person_name,
            'hostInfo' => $host,
        ];
    }

    /**
     * 获取图片资源
     * @return array
     */
    public function getImageRes() {
        return [
            'agreement' => JingResourseEx::loadAllByTypeAndNameAndReferId(JingResourseEx::TYPE_APPLY, JingResourseEx::NAME_THREE_AGREEMENT, $this->id),
            'agent' => JingResourseEx::loadAllByTypeAndNameAndReferId(JingResourseEx::TYPE_APPLY, JingResourseEx::NAME_ENTRUST_AGENT, $this->id),
            'id_card_u' => JingResourseEx::loadAllByTypeAndNameAndReferId(JingResourseEx::TYPE_APPLY, JingResourseEx::NAME_ID_CARD_U, $this->id),
            'id_card_d' => JingResourseEx::loadAllByTypeAndNameAndReferId(JingResourseEx::TYPE_APPLY, JingResourseEx::NAME_ID_CARD_D, $this->id),
            'current' => JingResourseEx::loadAllByTypeAndNameAndReferId(JingResourseEx::TYPE_APPLY, JingResourseEx::NAME_SCENE_PHOTO, $this->id),
            'passport' => JingResourseEx::loadAllByTypeAndNameAndReferId(JingResourseEx::TYPE_APPLY, JingResourseEx::NAME_BUS_PASSPORT, $this->id),
        ];
    }

    /**
     *
     */
    public function confirm() {
        $this->status = self::STATUS_FIRST_PASS;
        $this->save();
    }

    /**
     *
     */
    public function complete() {
        $this->status = self::STATUS_COMPLETE;
        $this->save();
    }

    /**
     * @return string
     */
    public function getTypeName() {
        $arr = [
            self::TYPE_COMMON => '普票',
            self::TYPE_SPECIAL => '专票',
        ];
        return array_key_exists($this->ticket_type,$arr)?$arr[$this->ticket_type]:'异常';
    }

    /**
     * @return string
     */
    public function getStatusName() {
        $arr = [
            self::STATUS_WAIT => '审核中',
            self::STATUS_FIRST_PASS => '通过',
            self::STATUS_FIRST_FAIL => '未通过',
            self::STATUS_COMPLETE => '完成',
        ];
        return array_key_exists($this->status,$arr)?$arr[$this->status]:'异常';
    }

    /**
     * @return array
     */
    public static function getStatusList() {
        return [
            self::STATUS_WAIT => '审核中',
            self::STATUS_FIRST_PASS => '通过',
            self::STATUS_FIRST_FAIL => '未通过',
        ];
    }

    /**
     * @param $name
     * @param $uploadName
     * @return JingResourseEx|null
     */
    public function saveRes($name, $uploadName) {
        $upload = new Upload();
        $upload->imageFile = UploadedFile::getInstanceByName($uploadName);
        if($path = $upload->upload()) {
            return JingResourseEx::create(JingResourseEx::TYPE_APPLY, $this->id, $name, $path);
        } else {
            return null;
        }
    }

    /**
     * @param $name
     * @param $path
     * @return JingResourseEx|null
     */
    public function saveImage($name,$path) {
        return JingResourseEx::create(JingResourseEx::TYPE_APPLY, $this->id, $name, $path);
    }
}