<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%jing_resourse}}".
 *
 * @property int $id 自增主键
 * @property string $path 资源路径
 * @property string $res_name 资源名称
 * @property int $res_type 资源类型
 * @property int $refer_id 关联的id
 * @property string $dt_create 创建时间
 */
class JingResourse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jing_resourse}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['res_type', 'refer_id'], 'integer'],
            [['dt_create'], 'safe'],
            [['path'], 'string', 'max' => 128],
            [['res_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增主键',
            'path' => '资源路径',
            'res_name' => '资源名称',
            'res_type' => '资源类型',
            'refer_id' => '关联的id',
            'dt_create' => '创建时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return JingResourseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JingResourseQuery(get_called_class());
    }
}
