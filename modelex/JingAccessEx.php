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
     * @return string
     */
    public function getStatusName() {
        $arr = [
            self::STATUS_CONFIRM => '通过',
            self::STATUS_EXAMINE => '审核中',
        ];
        return in_array($this->status,$arr)?$arr[$this->status]:'异常';
    }

    /**
     *
     */
    public function confirm() {
        $this->status = self::STATUS_CONFIRM;
        $this->save();
    }
}