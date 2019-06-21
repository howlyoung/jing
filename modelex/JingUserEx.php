<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/11
 * Time: 9:38
 */

namespace app\modelex;


use app\models\JingUser;

class JingUserEx extends  JingUser
{

    const STATUS_NONE = 0;  //无申请
    const STATUS_INITIAL = 1; //初审
    const STATUS_REGISTER = 2;//注册
    const STATUS_COMPLETE = 3;//完成

    /**
     * @param $pk
     * @return JingUserEx|array|null
     */
    public static function loadByPk($pk) {
        return self::find()->select(['*'])->where(['id' => $pk])->one();
    }

    /**
     * @param $openid
     * @return JingUser|array|null
     */
    public static function loadByOpenid($openid) {
        return self::find()->select(['*'])->where(['openid'=>$openid])->one();
    }

    public static function getUserByKey($key) {
        return self::loadByPk(1);
    }

    public function getStatus() {
        return $this->status;
    }

    /**
     * 检查是否登陆
     * @param $uid
     * @return bool
     */
    public static function checkLogin($token) {
        $token = JingTokenEx::loadByToken($token);
        if(empty($token)) {
            return false;
        } else {
            return $token->isExpire();
        }
    }

    /**
     * @param $sk
     * @return string
     */
    public function login($sk) {
        return JingTokenEx::login($this,$sk);
    }

    public function setStatus($status) {
        $this->status = $status;
        $this->save();
    }
}