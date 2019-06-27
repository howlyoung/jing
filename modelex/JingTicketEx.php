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
}