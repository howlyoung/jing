<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%jing_ticket}}".
 *
 * @property int $id 自增主键
 * @property string $ticket_title 发票抬头
 * @property string $ticket_code 纳税人识别号
 * @property int $ticket_type 发票类型 1 普通 2 专用
 * @property int $ticket_amount 开票金额，分
 * @property int $user_id 用户id
 * @property int $service_fee 服务费
 * @property string $service_bill 服务费凭据
 * @property string $amount_bill 打款凭证
 * @property string $area 快递地址
 * @property string $shoujian 收件人
 * @property string $shoujianren_mobile 收件人手机
 * @property int $status 状态
 */
class JingTicket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jing_ticket}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ticket_type', 'ticket_amount', 'user_id', 'service_fee', 'status'], 'integer'],
            [['ticket_title', 'shoujianren_mobile'], 'string', 'max' => 32],
            [['ticket_code'], 'string', 'max' => 64],
            [['service_bill', 'amount_bill', 'area', 'shoujian'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增主键',
            'ticket_title' => '发票抬头',
            'ticket_code' => '纳税人识别号',
            'ticket_type' => '发票类型 1 普通 2 专用',
            'ticket_amount' => '开票金额，分',
            'user_id' => '用户id',
            'service_fee' => '服务费',
            'service_bill' => '服务费凭据',
            'amount_bill' => '打款凭证',
            'area' => '快递地址',
            'shoujian' => '收件人',
            'shoujianren_mobile' => '收件人手机',
            'status' => '状态',
        ];
    }

    /**
     * {@inheritdoc}
     * @return JingTicketQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JingTicketQuery(get_called_class());
    }
}
