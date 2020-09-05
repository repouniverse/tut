<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaTipoMail]].
 *
 * @see StaTipoMail
 */
class StaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaTipoMail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaTipoMail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
