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

    /**
     * @param $mobile
     * @return self|array|null
     */
    public static function loadByMobile($mobile) {
        return self::find()->select(['*'])->where(['mobile'=>$mobile])->one();
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
}