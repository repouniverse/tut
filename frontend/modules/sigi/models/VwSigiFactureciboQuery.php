<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[VwSigiFacturecibo]].
 *
 * @see VwSigiFacturecibo
 */
class VwSigiFactureciboQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwSigiFacturecibo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwSigiFacturecibo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
