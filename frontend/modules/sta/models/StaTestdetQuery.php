<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaTestdet]].
 *
 * @see StaTestdet
 */
<<<<<<< HEAD
class StaTestdetQuery extends  \frontend\modules\sta\components\ActiveQueryScope
=======
class StaTestdetQuery extends  \yii\db\ActiveQuery
>>>>>>> e4b47ce01ec1bf57231883a79bf995c89c46af44
{
   CONST SCENARIO_MIN='minimo';
    
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaTestdet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaTestdet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
