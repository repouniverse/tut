<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaRetiros]].
 *
 * @see StaRetiros
 */
class StaRetirosQuery extends \frontend\modules\sta\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaRetiros[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaRetiros|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
