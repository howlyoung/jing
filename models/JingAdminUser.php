<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%jing_admin_user}}".
 *
 * @property int $id 自增主键
 * @property string $user_name 用户名
 * @property string $password 密码，密文
 * @property string $auth_key 认证key
 * @property string $access_token 访问token
 * @property string $dt_create 创建时间
 * @property string $last_login_time 最近登录时间
 */
class JingAdminUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jing_admin_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_create', 'last_login_time'], 'safe'],
            [['user_name'], 'string', 'max' => 64],
            [['password', 'auth_key', 'access_token'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增主键',
            'user_name' => '用户名',
            'password' => '密码，密文',
            'auth_key' => '认证key',
            'access_token' => '访问token',
            'dt_create' => '创建时间',
            'last_login_time' => '最近登录时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return JingAdminUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JingAdminUserQuery(get_called_class());
    }
}
