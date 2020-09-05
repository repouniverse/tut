<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[PlantillaCorreos]].
 *
 * @see PlantillaCorreos
 */
class PlantillaCorreosQuery extends \frontend\modules\sta\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PlantillaCorreos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PlantillaCorreos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
