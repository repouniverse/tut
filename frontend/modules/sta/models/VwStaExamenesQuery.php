<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[VwStaExamenes]].
 *
 * @see VwStaExamenes
 */
class VwStaExamenesQuery extends \frontend\modules\sta\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwStaExamenes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwStaExamenes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
