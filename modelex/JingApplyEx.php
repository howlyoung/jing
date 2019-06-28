<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/19
 * Time: 15:39
 */

namespace app\modelex;


use app\models\JingApply;

class JingApplyEx extends JingApply
{
    const STATUS_WAIT = 0;  //待审核
    const STATUS_FIRST_PASS = 1;    //初审通过
    const STATUS_FIRST_FAIL = 2;    //不通过

    const TYPE_COMMON = 0;  //普通票
    const TYPE_SPECIAL = 1; //专票
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
        $host = \yii::$app->request->hostInfo.'/';
        return [
            'argeement' => !empty($this->three_agreement)?$host.$this->three_agreement:'',
            'agent' => !empty($this->entrust_agent)?$host.$this->entrust_agent:'',
            'id_card_u' => !empty($this->id_card_u)?$host.$this->id_card_u:'',
            'id_card_d' => !empty($this->id_card_d)?$host.$this->id_card_d:'',
            'current' => !empty($this->scene_photo)?$host.$this->scene_photo:'',
            'passport' => !empty($this->bus_passport)?$host.$this->bus_passport:'',
            'bankCard' => $this->bank_card,
//            'creditNo' => $this->credit_no,
            'bankCode' => $this->bank_code,
        ];
    }

    /**
     * 获取图片资源
     * @return array
     */
    public function getImageRes() {
        return [
            'argeement' => !empty($this->three_agreement)?$this->three_agreement:'',
            'agent' => !empty($this->entrust_agent)?$this->entrust_agent:'',
            'id_card_u' => !empty($this->id_card_u)?$this->id_card_u:'',
            'id_card_d' => !empty($this->id_card_d)?$this->id_card_d:'',
            'current' => !empty($this->scene_photo)?$this->scene_photo:'',
            'passport' => !empty($this->bus_passport)?$this->bus_passport:'',
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
        ];
        return array_key_exists($this->status,$arr)?$arr[$this->status]:'异常';
    }
}