<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[VwStaEventos]].
 *
 * @see VwStaEventos
 */
class VwStaEventosQuery extends  \frontend\modules\sta\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwStaEventos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwStaEventos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
