<?php

namespace common\models\audit;

/**
 * This is the ActiveQuery class for [[AccessDocuLog]].
 *
 * @see AccessDocuLog
 */
class AccessDocuLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AccessDocuLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AccessDocuLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
