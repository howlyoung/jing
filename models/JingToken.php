<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%jing_token}}".
 *
 * @property int $id 自增主键
 * @property int $user_id 用户Id
 * @property string $session_key 登录标识
 * @property string $token 登录用token
 * @property string $expire_time 过期时间
 */
class JingToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jing_token}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['expire_time'], 'safe'],
            [['session_key', 'token'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增主键',
            'user_id' => '用户Id',
            'session_key' => '登录标识',
            'token' => '登录用token',
            'expire_time' => '过期时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return JingTokenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JingTokenQuery(get_called_class());
    }
}
