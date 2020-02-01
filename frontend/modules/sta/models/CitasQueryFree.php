<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[Citas]].
 *
 * @see Citas
 */
class CitasQueryFree extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Citas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Citas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
