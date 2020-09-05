<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaFlujo]].
 *
 * @see StaFlujo
 */
class StaFlujoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaFlujo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaFlujo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
