<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[JingUser]].
 *
 * @see JingUser
 */
class JingUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JingUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JingUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
