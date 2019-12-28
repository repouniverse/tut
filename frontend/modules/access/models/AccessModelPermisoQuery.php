<?php

namespace frontend\modules\access\models;

/**
 * This is the ActiveQuery class for [[AccessModelPermiso]].
 *
 * @see AccessModelPermiso
 */
class AccessModelPermisoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AccessModelPermiso[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AccessModelPermiso|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
