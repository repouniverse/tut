<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaGrupoflujo]].
 *
 * @see StaGrupoflujo
 */
class StaGrupoflujoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaGrupoflujo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaGrupoflujo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
