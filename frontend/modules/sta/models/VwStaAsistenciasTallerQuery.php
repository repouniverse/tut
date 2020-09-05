<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[VwStaAsistenciasTaller]].
 *
 * @see VwStaAsistenciasTaller
 */
class VwStaAsistenciasTallerQuery extends \frontend\modules\sta\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwStaAsistenciasTaller[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwStaAsistenciasTaller|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
