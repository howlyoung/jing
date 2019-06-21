<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[JingTicket]].
 *
 * @see JingTicket
 */
class JingTicketQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JingTicket[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JingTicket|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
