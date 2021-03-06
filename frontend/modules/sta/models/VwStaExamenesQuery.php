<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\components\ActiveQueryStatus;
/**
 * This is the ActiveQuery class for [[VwStaExamenes]].
 *
 * @see VwStaExamenes
 */
class VwStaExamenesQuery extends ActiveQueryStatus
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
