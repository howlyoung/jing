<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/11
 * Time: 9:49
 */

namespace app\modelex;


use app\models\JingAccess;

class JingAccessEx extends JingAccess
{
    const STATUS_EXAMINE = 0;   //审核中
    const STATUS_CONFIRM = 1;   //通过

    const TYPE_PERSON = 0;  //个人客户
    const TYPE_COMPANY = 1; //企业客户

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
     * @param string $status
     * @return \self[]|array
     */
    public static function getListByStatus($status='') {
        if(empty($status)) {
            return self::find()->select(['*'])->all();
        } else {
            return self::find()->select(['*'])->where(['status'=>$status])->all();
        }
    }

    /**
     * @param $pk
     * @return JingAccessEx|array|null
     */
    public static function loadByPk($pk) {
        return self::find()->select(['*'])->where(['id'=>$pk])->one();
    }

    /**
     * @param $uid
     * @return JingAccess|array|null
     */
    public static function loadByUid($uid) {
        return self::find()->select(['*'])->where(['user_id'=>$uid])->one();
    }

    /**
     * @return string
     */
    public function getStatusName() {
        $arr = self::getStatusList();
        return array_key_exists($this->status,$arr)?$arr[$this->status]:'异常';
    }

    /**
     * @return array
     */
    public static function getStatusList() {
        return [
            self::STATUS_CONFIRM => '初审通过',
            self::STATUS_EXAMINE => '审核中',
        ];
    }

    /**
     * @return string
     */
    public function getTypeName() {
        $arr = self::getTypeList();
        return array_key_exists($this->user_type,$arr)?$arr[$this->user_type]:'异常';
    }

    /**
     *
     */
    public function confirm() {
        $this->status = self::STATUS_CONFIRM;
        $this->save();
    }

    /**
     * @return array
     */
    public static function getTypeList() {
        return [
            self::TYPE_COMPANY => '企业客户',
            self::TYPE_PERSON => '个人客户',
        ];
    }
}