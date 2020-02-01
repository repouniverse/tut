<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\components\ActiveQueryScope;
/**
 * This is the ActiveQuery class for [[VwStaTutores]].
 *
 * @see VwStaTutores
 */
class VwStaTutoresQuery extends ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwStaTutores[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwStaTutores|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
