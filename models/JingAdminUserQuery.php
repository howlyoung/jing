<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[JingAdminUser]].
 *
 * @see JingAdminUser
 */
class JingAdminUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JingAdminUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JingAdminUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
