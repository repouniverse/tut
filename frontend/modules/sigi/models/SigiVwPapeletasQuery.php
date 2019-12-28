<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiVwPapeletas]].
 *
 * @see SigiVwPapeletas
 */
class SigiVwPapeletasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiVwPapeletas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiVwPapeletas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
