<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaIndisesiones]].
 *
 * @see StaIndisesiones
 */
class StaIndisesionesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaIndisesiones[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaIndisesiones|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
