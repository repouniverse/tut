<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[VwStaInformes]].
 *
 * @see VwStaInformes
 */
class VwStaInformesQuery extends  \frontend\modules\sta\components\ActiveQueryStatus
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwStaInformes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwStaInformes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
