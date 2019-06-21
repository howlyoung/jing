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
 * @property string $area 快递地址
 * @property string $shoujian 收件人
 * @property string $shoujianren_mobile 收件人手机
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
            [['ticket_title', 'ticket_code', 'area', 'shoujian', 'shoujianren_mobile'], 'string', 'max' => 128],
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
            'area' => '快递地址',
            'shoujian' => '收件人',
            'shoujianren_mobile' => '收件人手机',
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
