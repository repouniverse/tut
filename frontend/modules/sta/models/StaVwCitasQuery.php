<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaVwCitas]].
 *
 * @see StaVwCitas
 */
class StaVwCitasQuery extends \frontend\modules\sta\components\ActiveQueryCitas
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaVwCitas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaVwCitas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
