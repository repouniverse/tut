<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AccesDocu]].
 *
 * @see AccesDocu
 */
class AccesDocuQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AccesDocu[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AccesDocu|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
