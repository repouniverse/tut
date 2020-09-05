<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiTransferencias]].
 *
 * @see SigiTransferencias
 */
class SigiTransferenciasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiTransferencias[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiTransferencias|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
