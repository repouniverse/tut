<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\models\Talleres;
 use common\models\masters\Trabajadores;
use common\models\masters\Trabajadores AS Psicologo;
class Talleres_n extends Talleres{
    
 public function getFacultad()
    {
        return $this->hasOne(Facultades::className(), ['codfac' => 'codfac']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodo()
    {
        return $this->hasOne(Periodos::className(), ['codperiodo' => 'codperiodo']);
    }
    
    public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }
    
     public function getPsicologo()
    {
        return $this->hasOne(Psicologo::className(), ['codigotra' => 'codtra_psico']);
    }
    
     public function getTutores()
    {
        return $this->hasMany(Tallerpsico::className(), ['talleres_id' => 'id']);
    }
    
    public function getAlumnos()
    {
        return $this->hasMany(Talleresdet::className(), ['talleres_id' => 'id']);
    }
    
    public function getRanges()
    {
        return $this->hasMany(Rangos::className(), ['talleres_id' => 'id']);
    }
 public function beforeSave($insert){
      parent::beforeSave($insert);
    $this->clase= \frontend\modules\sta\staModule::CLASE_REGULAR; 
      RETURN true ;
 }
 
 
}
