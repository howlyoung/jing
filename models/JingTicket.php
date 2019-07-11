<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%jing_ticket}}".
 *
 * @property int $id 自增主键
 * @property string $person_name 个体工商户名称
 * @property string $ticket_title 发票抬头
 * @property string $ticket_code 纳税人识别号
 * @property int $ticket_type 发票类型 1 普通 2 专用
 * @property int $ticket_amount 开票金额，分
 * @property int $user_id 用户id
 * @property int $receive_type 接收方式 0 电子  1 纸质
 * @property string $email 电子邮箱
 * @property string $bankCode 开户行
 * @property string $bank_card 银行账号
 * @property string $company_address 公司地址
 * @property string $company_tel 公司电话
 * @property string $address 快递地址
 * @property string $addressee 收件人
 * @property string $addressee_mobile 收件人手机
 * @property int $service_fee 服务费
 * @property string $service_bill 服务费凭据
 * @property string $amount_bill 打款凭证
 * @property string $random_flag 随机的唯一标识，供页面重复上传使用
 * @property int $status 状态
 * @property string $dt_create 创建时间
 * @property string $dt_update 更新时间
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
            [['ticket_type', 'ticket_amount', 'user_id', 'receive_type', 'service_fee', 'status'], 'integer'],
            [['dt_create', 'dt_update'], 'safe'],
            [['person_name', 'company_address', 'address', 'addressee', 'service_bill', 'amount_bill', 'random_flag'], 'string', 'max' => 128],
            [['ticket_title', 'company_tel', 'addressee_mobile'], 'string', 'max' => 32],
            [['ticket_code', 'email', 'bankCode', 'bank_card'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增主键',
            'person_name' => '个体工商户名称',
            'ticket_title' => '发票抬头',
            'ticket_code' => '纳税人识别号',
            'ticket_type' => '发票类型 1 普通 2 专用',
            'ticket_amount' => '开票金额，分',
            'user_id' => '用户id',
            'receive_type' => '接收方式 0 电子  1 纸质',
            'email' => '电子邮箱',
            'bankCode' => '开户行',
            'bank_card' => '银行账号',
            'company_address' => '公司地址',
            'company_tel' => '公司电话',
            'address' => '快递地址',
            'addressee' => '收件人',
            'addressee_mobile' => '收件人手机',
            'service_fee' => '服务费',
            'service_bill' => '服务费凭据',
            'amount_bill' => '打款凭证',
            'random_flag' => '随机的唯一标识，供页面重复上传使用',
            'status' => '状态',
            'dt_create' => '创建时间',
            'dt_update' => '更新时间',
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
