<?php
namespace frontend\modules\sta\models;
class StaEventosSesionesQuery extends \yii\db\ActiveQuery
{
  
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaEventosSesiones|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
