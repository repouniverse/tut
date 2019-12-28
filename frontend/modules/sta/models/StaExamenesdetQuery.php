<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaExamenesdet]].
 *
 * @see StaExamenesdet
 */
class StaExamenesdetQuery extends \frontend\modules\sta\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaExamenesdet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaExamenesdet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
