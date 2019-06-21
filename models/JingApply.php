<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%jing_apply}}".
 *
 * @property int $id 自增主键
 * @property string $name 名称
 * @property string $mobile 手机号码
 * @property int $user_type 客户类型 0 个人 1 公司 2 其他
 * @property string $user_demand_desc 客户需求描述
 * @property string $user_business 客户业务
 * @property string $user_agreement 客户与开票方协议关系
 * @property string $solution 当前开票解决方案
 * @property string $referee 推荐人
 * @property string $ticket_content 发票内容
 * @property int $ticket_type 发票类型 1 普通 2 专用
 * @property string $three_agreement 三方协议，资源链接
 * @property string $entrust_agent 委托代理证明，资源链接
 * @property string $id_card 身份证照片
 * @property string $true_photo 现场照片
 * @property string $bank_no 银行卡号
 * @property string $bank_card 开户行
 * @property string $credit_no 社会信用代码
 * @property string $term 经营期限
 * @property string $bus_passport 经营执照
 * @property int $status 审核状态 0 待审核 1 初审通过 2 初审不通过
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
            [['user_type', 'ticket_type', 'status'], 'integer'],
            [['name', 'mobile', 'referee'], 'string', 'max' => 32],
            [['user_demand_desc', 'user_business', 'user_agreement', 'solution'], 'string', 'max' => 64],
            [['ticket_content', 'three_agreement', 'entrust_agent', 'id_card', 'true_photo', 'bank_no', 'bank_card', 'credit_no', 'term', 'bus_passport'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增主键',
            'name' => '名称',
            'mobile' => '手机号码',
            'user_type' => '客户类型 0 个人 1 公司 2 其他',
            'user_demand_desc' => '客户需求描述',
            'user_business' => '客户业务',
            'user_agreement' => '客户与开票方协议关系',
            'solution' => '当前开票解决方案',
            'referee' => '推荐人',
            'ticket_content' => '发票内容',
            'ticket_type' => '发票类型 1 普通 2 专用',
            'three_agreement' => '三方协议，资源链接',
            'entrust_agent' => '委托代理证明，资源链接',
            'id_card' => '身份证照片',
            'true_photo' => '现场照片',
            'bank_no' => '银行卡号',
            'bank_card' => '开户行',
            'credit_no' => '社会信用代码',
            'term' => '经营期限',
            'bus_passport' => '经营执照',
            'status' => '审核状态 0 待审核 1 初审通过 2 初审不通过',
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
