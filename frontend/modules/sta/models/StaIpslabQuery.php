<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaIpslab]].
 *
 * @see StaIpslab
 */
class StaIpslabQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaIpslab[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaIpslab|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
