<?php

namespace frontend\modules\avisos\models;

/**
 * This is the ActiveQuery class for [[AvisosTablon]].
 *
 * @see AvisosTablon
 */
class AvisosTablonQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AvisosTablon[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AvisosTablon|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
