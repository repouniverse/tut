<?php
/*
 * Esta clase para ahorrar tiempo
 * Evitando escribir Yii::$app->
 */
namespace common\helpers;
use yii;

class timeHelper {
     
    public static function getMaxTimeExecute(){
      return ini_get('max_execution_time')+0; 
   }
   
   public static function excedioDuracion($duration, $anticipate=0){
      return ($duration + $anticipate >= static::getMaxTimeExecute());
   }
   
   public STATIC function daysOfWeek(){
       return [
           0=>yii::t('base.names','Domingo'),
           1=>yii::t('base.names','Lunes'),
           2=>yii::t('base.names','Martes'),
           3=>yii::t('base.names','Miercoles'),
           4=>yii::t('base.names','Jueves'),
           5=>yii::t('base.names','Viernes'),
           6=>yii::t('base.names','Sabado'),
        
           
       ];
   }
   
   
   public static  function cboAnnos(){
       return [
           '2018'=>'2018',
            '2019'=>'2019',
            '2020'=>'2020',
           '2021'=>'2021',
           '2022'=>'2022',
       ];
   }
 
   
    public static  function cboMeses(){
       return [
           '01'=>yii::t('base.names','ENERO'),
           '02'=>yii::t('base.names','FEBRERO'),
           '03'=>yii::t('base.names','MARZO'),
           '04'=>yii::t('base.names','ABRIL'),
           '05'=>yii::t('base.names','MAYO'),
           '06'=>yii::t('base.names','JUNIO'),
           '07'=>yii::t('base.names','JULIO'),
           '08'=>yii::t('base.names','AGOSTO'),
           '09'=>yii::t('base.names','SETIEMBRE'),
           '10'=>yii::t('base.names','OCTUBRE'),
           '11'=>yii::t('base.names','NOVIEMBRE'),
           '12'=>yii::t('base.names','DICIEMBRE'),
       ];
   }
   
   public static function getDateTimeInitial(){
       return '1970-01-01 00:00:00';
   }
   public static function getDateInitial(){
       return '1970-01-01';
   }
   
   } 
   
  
   
