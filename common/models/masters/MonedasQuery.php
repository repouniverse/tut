<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[Monedas]].
 *
 * @see Monedas
 */
class MonedasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Monedas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Monedas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
