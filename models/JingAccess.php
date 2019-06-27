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
 * @property string $relation 客户与发票需求方关系
 * @property string $user_business 客户业务
 * @property int $status
 * @property string $marker_channel 推广渠道
 * @property string $referrer 推荐人
 * @property string $dt_create 创建时间
 * @property string $dt_update 更新时间
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
            [['dt_create', 'dt_update'], 'safe'],
            [['name', 'mobile'], 'string', 'max' => 32],
            [['user_demand_desc', 'solution', 'relation', 'user_business', 'marker_channel'], 'string', 'max' => 128],
            [['referrer'], 'string', 'max' => 30],
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
            'relation' => '客户与发票需求方关系',
            'user_business' => '客户业务',
            'status' => 'Status',
            'marker_channel' => '推广渠道',
            'referrer' => '推荐人',
            'dt_create' => '创建时间',
            'dt_update' => '更新时间',
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
