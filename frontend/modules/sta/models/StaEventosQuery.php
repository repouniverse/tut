<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaEventos]].
 *
 * @see StaEventos
 */
class StaEventosQuery extends \frontend\modules\sta\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaEventos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaEventos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
