<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\components\ActiveQueryStatus;
/**
 * This is the ActiveQuery class for [[Examenes]].
 *
 * @see Examenes
 */
class ExamenesQuery extends ActiveQueryStatus
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Examenes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    public function WithRetired(){
        return  $this->orWhere(['status'=> Aluriesgo::FLAG_RETIRADO]);
    }
    /**
     * {@inheritdoc}
     * @return Examenes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
