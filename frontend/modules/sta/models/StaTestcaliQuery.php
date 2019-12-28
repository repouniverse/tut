<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaTestcali]].
 *
 * @see StaTestcali
 */
class StaTestcaliQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaTestcali[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaTestcali|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
