<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[JingResourse]].
 *
 * @see JingResourse
 */
class JingResourseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JingResourse[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JingResourse|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
