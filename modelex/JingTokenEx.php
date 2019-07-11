<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/18
 * Time: 13:34
 */

namespace app\modelex;


use app\models\JingToken;

class JingTokenEx extends JingToken
{

    /**
     * @param $uid
     * @return self|array|null
     */
    public static function loadByUserId($uid) {
        return self::find()->select(['*'])->where(['user_id'=>$uid])->one();
    }

    /**
     * @param $token
     * @return self|array|null
     */
    public static function loadByToken($token) {
        return self::find()->select(['*'])->where(['token'=>$token])->one();
    }

    public static function token($openid,$sk) {
        return md5($openid.$sk);
    }

    /**
     * @param $user
     * @param $sk
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public static function login($user,$sk) {
        /** @var JingUserEx $user */
        $token = self::token($user->openid,$sk);
        $model = self::loadByUserId($user->id);
        if(empty($model)) {
            $model = new self();
            $model->user_id = $user->id;
            $model->session_key = $sk;
            $model->token = $token;
            $model->expire_time = date('Y-m-d H:i:s',time() + 60 * 60 * 2 );
            $model->save();
        } else {
            $model->session_key = $sk;
            $model->token = $token;
            $model->expire_time = date('Y-m-d H:i:s',time() + 60 * 60 * 2 );
            $model->update();
        }
        return $model->token;
    }

    /**
     * 判断token是否过期
     * @return bool
     */
    public function isExpire() {
        $time = date('Y-m-d H:i:s', time());
        return ($this->expire_time > $time)? true: false;
    }

}