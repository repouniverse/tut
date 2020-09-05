<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[HelpAyuda]].
 *
 * @see HelpAyuda
 */
class HelpAyudaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return HelpAyuda[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return HelpAyuda|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
