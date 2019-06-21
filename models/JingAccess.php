<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%jing_access}}".
 *
 * @property int $id 自增主键
 * @property int $user_id 用户id
 * @property string $name 客户名称
 * @property string $mobile 客户手机号
 * @property int $user_type 客户类型 0 个人 1 公司 2 其他
 * @property string $user_demand_desc 客户需求描述
 * @property string $solution 当前开票解决方案
 * @property string $user_business '客户业务
 * @property int $status
 */
class JingAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jing_access}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'user_type', 'status'], 'integer'],
            [['name', 'mobile'], 'string', 'max' => 32],
            [['user_demand_desc', 'solution', 'user_business'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增主键',
            'user_id' => '用户id',
            'name' => '客户名称',
            'mobile' => '客户手机号',
            'user_type' => '客户类型 0 个人 1 公司 2 其他',
            'user_demand_desc' => '客户需求描述',
            'solution' => '当前开票解决方案',
            'user_business' => '\'客户业务',
            'status' => 'Status',
        ];
    }

    /**
     * {@inheritdoc}
     * @return JingAccessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JingAccessQuery(get_called_class());
    }
}
