<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[Bancos]].
 *
 * @see Bancos
 */
class BancosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Bancos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Bancos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
