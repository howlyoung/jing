<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[JingApply]].
 *
 * @see JingApply
 */
class JingApplyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JingApply[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JingApply|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
