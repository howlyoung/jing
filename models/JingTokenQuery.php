<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[JingToken]].
 *
 * @see JingToken
 */
class JingTokenQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JingToken[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JingToken|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
