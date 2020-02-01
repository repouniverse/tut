<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\components\ActiveQueryScope;
/**
 * This is the ActiveQuery class for [[Talleresdet]].
 *
 * @see Talleresdet
 */
class TalleresdetQuery extends ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Talleresdet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Talleresdet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
