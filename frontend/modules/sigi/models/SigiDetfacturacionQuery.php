<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiDetfacturacion]].
 *
 * @see SigiDetfacturacion
 */
class SigiDetfacturacionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiDetfacturacion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiDetfacturacion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
