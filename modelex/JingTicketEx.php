<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/21
 * Time: 9:40
 */

namespace app\modelex;


use app\models\JingTicket;

class JingTicketEx extends JingTicket
{

    const STATUS_WAIT = 0;
    const STATUS_COMPLETE = 1;

    const TYPE_COMMON = 0;
    const TYPE_SPECIAL = 1;

    const MODE_ELE = 0;
    const MODE_POST = 1;
    /**
     * @param $title
     * @return $this
     */
    public static function loadByTitle($title) {
        return self::find()->select(['*'])->where(['ticket_title'=>$title])->one();
    }

    /**
     * @param $flag
     * @return self|array|null
     */
    public static function loadByFlag($flag) {
        return self::find()->select(['*'])->where(['random_flag'=>$flag])->one();
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
     * @return self|array
     */
    public static function getListByStatus($status='') {
        if(empty($status)) {
            return self::find()->select(['*'])->all();
        } else {
            return self::find()->select(['*'])->where(['status'=>$status])->all();
        }
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
            self::STATUS_WAIT => '等待开票',
            self::STATUS_COMPLETE => '已开',
        ];
        return array_key_exists($this->status,$arr)?$arr[$this->status]:'异常';
    }

    /**
     * 获取图片资源
     * @return array
     */
    public function getImageRes() {
        return [
            'service_bill' => !empty($this->service_bill)?$this->service_bill:'',
            'amount_bill' => !empty($this->amount_bill)?$this->amount_bill:'',
        ];
    }

    /**
     * @return array
     */
    public static function getStatusList() {
        return [
            self::STATUS_WAIT => '等待开票',
            self::STATUS_COMPLETE => '已开',
        ];
    }

    /**
     * @return string
     */
    public function getPersonName() {
        $apply = JingApplyEx::loadByUserId($this->user_id);
        return empty($apply)?'':$apply->person_name;
    }

    /**
     * @return array
     */
    public function getMode() {
        $arr =  [
            self::MODE_ELE => '电子',
            self::MODE_POST => '快递'
        ];
        return array_key_exists($this->receive_type,$arr)?$arr[$this->receive_type]:'异常';
    }

    /**
     *
     */
    public function confirm(){
        $this->status = self::STATUS_COMPLETE;
        $this->save();
    }
}