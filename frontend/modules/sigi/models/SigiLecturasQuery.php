<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiLecturas]].
 *
 * @see SigiLecturas
 */
class SigiLecturasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiLecturas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiLecturas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
