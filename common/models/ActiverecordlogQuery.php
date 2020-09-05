<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Activerecordlog]].
 *
 * @see Activerecordlog
 */
class ActiverecordlogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Activerecordlog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Activerecordlog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
