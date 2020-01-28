<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaTestdet]].
 *
 * @see StaTestdet
 */
class StaTestdetQuery extends  \frontend\modules\sta\components\ActiveQueryScope
{
   CONST SCENARIO_MIN='minimo';
    
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaTestdet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaTestdet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
