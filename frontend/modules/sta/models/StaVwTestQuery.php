<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaVwTest]].
 *
 * @see StaVwTest
 */
class StaVwTestQuery extends \frontend\modules\sta\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaVwTest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaVwTest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
