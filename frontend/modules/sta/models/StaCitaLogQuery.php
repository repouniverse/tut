<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaCitaLog]].
 *
 * @see StaCitaLog
 */
class StaCitaLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StaCitaLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaCitaLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
