<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[VwStaResultados]].
 *
 * @see VwStaResultados
 */
class VwStaResultadosQuery extends \frontend\modules\sta\components\ActiveQueryStatus
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwStaResultados[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwStaResultados|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
