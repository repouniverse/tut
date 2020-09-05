<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaEventosdet]].
 *
 * @see StaEventosdet
 */
class StaEventosdetQuery extends \frontend\modules\sta\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaEventosdet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaEventosdet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
