<?php

namespace frontend\modules\sta\models;

/**
 * This is the ActiveQuery class for [[StaResultados]].
 *
 * @see StaResultados
 */
class StaResultadosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/
public function init()
    {
       $this->andWhere([
              'status'=> ['N','I']
               ]);
        parent::init();
    }
    
    public function complete(){
       return  $this->orWhere(['status'=>'R']);
   } 
    /**
     * {@inheritdoc}
     * @return StaResultados[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StaResultados|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
