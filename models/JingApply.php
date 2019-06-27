<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%jing_apply}}".
 *
 * @property int $id 自增主键
 * @property int $user_id 用户id
 * @property string $ticket_content 发票内容
 * @property int $ticket_type 发票类型 1 普通 2 专用
 * @property string $bus_type 经营行业类别
 * @property string $person_name 个体户名称
 * @property string $bus_range 经营范围
 * @property string $three_agreement 三方协议，资源链接
 * @property string $entrust_agent 委托代理证明，资源链接
 * @property string $id_card_u 身份证照片
 * @property string $id_card_d 身份证照反面
 * @property string $scene_photo 现场照片
 * @property string $bank_card 银行卡号
 * @property string $bank_code 开户行
 * @property string $credit_no 社会信用代码
 * @property string $term 经营期限
 * @property string $bus_passport 经营执照
 * @property int $status 审核状态 0 待审核 1 初审通过 2 初审不通过
 * @property string $dt_create 创建时间
 * @property string $dt_update 更新时间
 */
class JingApply extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jing_apply}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'ticket_type', 'status'], 'integer'],
            [['dt_create', 'dt_update'], 'safe'],
            [['ticket_content', 'bus_type', 'bus_range', 'three_agreement', 'entrust_agent', 'id_card_u', 'id_card_d', 'scene_photo', 'bank_card', 'bank_code', 'credit_no', 'term', 'bus_passport'], 'string', 'max' => 128],
            [['person_name'], 'string', 'max' => 32],
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
            'ticket_content' => '发票内容',
            'ticket_type' => '发票类型 1 普通 2 专用',
            'bus_type' => '经营行业类别',
            'person_name' => '个体户名称',
            'bus_range' => '经营范围',
            'three_agreement' => '三方协议，资源链接',
            'entrust_agent' => '委托代理证明，资源链接',
            'id_card_u' => '身份证照片',
            'id_card_d' => '身份证照反面',
            'scene_photo' => '现场照片',
            'bank_card' => '银行卡号',
            'bank_code' => '开户行',
            'credit_no' => '社会信用代码',
            'term' => '经营期限',
            'bus_passport' => '经营执照',
            'status' => '审核状态 0 待审核 1 初审通过 2 初审不通过',
            'dt_create' => '创建时间',
            'dt_update' => '更新时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return JingApplyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JingApplyQuery(get_called_class());
    }
}
