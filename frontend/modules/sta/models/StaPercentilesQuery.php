<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaPercentiles]].
 *
 * @see StaPercentiles
 */
class StaPercentilesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaPercentiles[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaPercentiles|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
