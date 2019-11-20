<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiCargosedificio]].
 *
 * @see SigiCargosedificio
 */
class SigiCargosedificioQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiCargosedificio[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiCargosedificio|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
