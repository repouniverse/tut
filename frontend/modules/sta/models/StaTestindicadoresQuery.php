<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaTestindicadores]].
 *
 * @see StaTestindicadores
 */
class StaTestindicadoresQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaTestindicadores[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaTestindicadores|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
