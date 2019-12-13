<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaConvocatoria]].
 *
 * @see StaConvocatoria
 */
class StaConvocatoriaQuery extends \frontend\modules\sta\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaConvocatoria[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaConvocatoria|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
