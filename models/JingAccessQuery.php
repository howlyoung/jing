<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[JingAccess]].
 *
 * @see JingAccess
 */
class JingAccessQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JingAccess[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JingAccess|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
