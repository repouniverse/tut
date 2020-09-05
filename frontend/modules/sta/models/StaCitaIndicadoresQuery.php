<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaCitaIndicadores]].
 *
 * @see StaCitaIndicadores
 */
class StaCitaIndicadoresQuery extends \frontend\modules\sta\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaCitaIndicadores[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaCitaIndicadores|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
