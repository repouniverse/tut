<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[VwSigiTempLecturas]].
 *
 * @see VwSigiTempLecturas
 */
class VwSigiLecturasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwSigiTempLecturas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwSigiTempLecturas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
