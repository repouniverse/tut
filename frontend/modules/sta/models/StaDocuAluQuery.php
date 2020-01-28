<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaDocuAlu]].
 *
 * @see StaDocuAlu
 */
class StaDocuAluQuery extends \frontend\modules\sta\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaDocuAlu[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaDocuAlu|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
