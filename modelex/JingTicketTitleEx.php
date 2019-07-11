<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/21
 * Time: 9:40
 */

namespace app\modelex;


use app\models\JingTicketTitle;

class JingTicketTitleEx extends JingTicketTitle
{

    /**
     * @param $title
     * @return self|array|null
     */
    public static function loadByTitle($title) {
        return self::find()->select(['*'])->where(['ticket_title'=>$title])->one();
    }

    /**
     * @return self[]|array
     */
    public static function getList() {
        return self::find()->select(['*'])->all();
    }

    /**
     * @param $uid
     * @return \app\models\JingTicketTitle[]|array
     */
    public static function getListByUid($uid) {
        return self::find()->select(['*'])->where(['user_id'=>$uid])->all();
    }
}