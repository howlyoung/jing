<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%jing_user}}".
 *
 * @property int $id 自增主键
 * @property string $openid 用户的openid
 * @property string $name 用户名
 * @property string $mobile 用户手机
 * @property string $dt_create 创建时间
 * @property int $status 0 没有申请  1 初审中 2 注册中  3 注册完成
 */
class JingUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jing_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_create'], 'safe'],
            [['status'], 'integer'],
            [['openid'], 'string', 'max' => 64],
            [['name', 'mobile'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增主键',
            'openid' => '用户的openid',
            'name' => '用户名',
            'mobile' => '用户手机',
            'dt_create' => '创建时间',
            'status' => '0 没有申请  1 初审中 2 注册中  3 注册完成',
        ];
    }

    /**
     * {@inheritdoc}
     * @return JingUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JingUserQuery(get_called_class());
    }
}
