<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/21
 * Time: 9:40
 */

namespace app\modelex;


use app\models\JingTicket;
use app\models\Upload;
use yii\web\UploadedFile;

class JingTicketEx extends JingTicket
{

    const STATUS_WAIT = 0;
    const STATUS_COMPLETE = 1;

    const TYPE_COMMON = 0;
    const TYPE_SPECIAL = 1;

    const MODE_ELE = 0;
    const MODE_POST = 1;

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
     * @return array
     */
    public static function getTypeList() {
        return [
            self::TYPE_COMMON => '普票',
            self::TYPE_SPECIAL => '专票',
        ];
    }

    /**
     * @return string
     */
    public function getStatusName() {
        $arr = [
            self::STATUS_WAIT => '待开票',
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
            'serviceBill' => JingResourseEx::loadAllByTypeAndNameAndReferId(JingResourseEx::TYPE_TICKET, JingResourseEx::NAME_SERVICE_BILL, $this->id),
            'amountBill' => JingResourseEx::loadAllByTypeAndNameAndReferId(JingResourseEx::TYPE_TICKET, JingResourseEx::NAME_AMOUNT_BILL, $this->id),
            'agreement' => JingResourseEx::loadAllByTypeAndNameAndReferId(JingResourseEx::TYPE_TICKET, JingResourseEx::NAME_THREE_AGREEMENT, $this->id),
        ];
    }

    /**
     * @param $type
     * @param string $host
     * @return array
     */
    public function getImagePathByType($type, $host='') {
        $arr = $this->getImageRes();
        $path = [];
        if(array_key_exists($type,$arr)) {
            foreach($arr[$type] as $img) {
                $path[] = $img->getPath($host);
            }
        }
        return $path;
    }

    /**
     * 通过用户ID获取最近一次开票
     * @param $userId
     * @return JingTicketEx|array|null
     */
    public static function getLastByUserId($userId) {
        return self::find()->select(['*'])->where(['user_id'=>$userId])->orderBy(['dt_create'=> SORT_DESC])->one();
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

    /**
     * @param $name
     * @param $uploadName
     * @return JingResourseEx|null
     */
    public function saveRes($name, $uploadName) {
        $upload = new Upload();
        $upload->imageFile = UploadedFile::getInstanceByName($uploadName);
        if($path = $upload->upload()) {
            return JingResourseEx::create(JingResourseEx::TYPE_TICKET, $this->id, $name, $path);
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
        return JingResourseEx::create(JingResourseEx::TYPE_TICKET, $this->id, $name, $path);
    }
}