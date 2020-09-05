<?php
namespace frontend\modules\sta\models;
use frontend\modules\sta\components\ActiveQueryScope_n;
/**
 * This is the ActiveQuery class for [[Talleres]].
 *
 * @see Talleres
 */
class Talleres_nQuery extends ActiveQueryScope_n
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Talleres[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Talleres|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
