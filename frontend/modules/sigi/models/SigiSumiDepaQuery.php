<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiSumiDepa]].
 *
 * @see SigiSumiDepa
 */
class SigiSumiDepaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiSumiDepa[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiSumiDepa|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
