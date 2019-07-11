<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%jing_ticket_title}}".
 *
 * @property int $id 自增主键
 * @property int $user_id 用户Id
 * @property string $ticket_title 抬头
 * @property string $ticket_code 识别号
 * @property string $address 快递地址
 * @property string $addressee 收件人
 * @property string $addressee_mobile 收件人手机
 * @property string $email 电子邮箱
 * @property string $bank_code 开户行
 * @property string $bank_card 银行账号
 * @property string $company_address 公司地址
 * @property string $company_tel 公司联系电话
 */
class JingTicketTitle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jing_ticket_title}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['ticket_title', 'ticket_code', 'address', 'addressee', 'addressee_mobile', 'email', 'bank_code', 'company_address'], 'string', 'max' => 128],
            [['bank_card'], 'string', 'max' => 64],
            [['company_tel'], 'string', 'max' => 32],
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
            'ticket_title' => '抬头',
            'ticket_code' => '识别号',
            'address' => '快递地址',
            'addressee' => '收件人',
            'addressee_mobile' => '收件人手机',
            'email' => '电子邮箱',
            'bank_code' => '开户行',
            'bank_card' => '银行账号',
            'company_address' => '公司地址',
            'company_tel' => '公司联系电话',
        ];
    }

    /**
     * {@inheritdoc}
     * @return JingTicketTitleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JingTicketTitleQuery(get_called_class());
    }
}
