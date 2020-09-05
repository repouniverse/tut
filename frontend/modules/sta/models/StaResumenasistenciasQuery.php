<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaResumenasistencias]].
 *
 * @see StaResumenasistencias
 */
class StaResumenasistenciasQuery extends \frontend\modules\sta\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaResumenasistencias[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaResumenasistencias|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
    
    
}
