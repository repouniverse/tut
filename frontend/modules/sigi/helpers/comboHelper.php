<?php
/*
 * Esta clase extiende la clase original
 * pero adicionalmetne devuelve los data
 * para los combos  
 * FACULTADES
 * CARRERAS
 * CARRERAS POR FACULTAD
 */
namespace frontend\modules\sigi\helpers;
use common\helpers\ComboHelper as Combito;
use yii\helpers\ArrayHelper;
use yii;
class comboHelper extends Combito
{
     public static function getCboEdificios(){
        return ArrayHelper::map(
                        \frontend\modules\sigi\models\Edificios::find()->all(),
                'id','nombre');
    }
    
    public static function getCboTipoUnidades(){
        return ArrayHelper::map(
        \frontend\modules\sigi\models\SigiTipoUnidades::find()->all(),
                'codtipo','desunidad');
    }
    
      public static function getCboCargos(){
        return ArrayHelper::map(
        \frontend\modules\sigi\models\SigiCargos::find()->all(),
                'id','descargo');
    }
    
    public static function getCboGrPresup(){
        return ArrayHelper::map(
        \frontend\modules\sigi\models\SigiGrupoPresupuesto::find()->all(),
                'codigo','descripcion');
    }
    
    /*
     * Devuel combno apoderados  por edificio
     */
    public static function getCboApoderados($id_edificio){
        $apode= \frontend\modules\sigi\models\SigiApoderados::find()
                 ->select(['codpro'])
                 ->where(['edificio_id'=>$id_edificio])->asArray()->all();
 $codigos=ArrayHelper::getColumn($apode, 'codpro');
        return ArrayHelper::map(
                \common\models\masters\Clipro::find()->
                where(['in',
              'codpro', $codigos
               ])->all(),
                'codpro','despro');
        
    }
    
     public static function getCboSameUnits($id_edificio,$id=null){
      if($id===null){
          return ArrayHelper::map(
                          \frontend\modules\sigi\models\SigiUnidades::find()
                  ->where(['edificio_id'=>$id_edificio])->all(),
                'id','numero'); 
      }else{
          return ArrayHelper::map(
                          \frontend\modules\sigi\models\SigiUnidades::find()
                  ->where(['edificio_id'=>$id_edificio])
                  ->andWhere(['not', 'id=1'])->all(),
                'id','numero'); 
      }
       
    }
    
    public static function getCboPisos($init=-3,$top=50){
        $pisos=[];
        for ($x = $init; $x <= $top; $x++) {
              if($x<0){
                  $prefijo=yii::t('sigi.labels','SÓTANO');
              }else{
                  $prefijo=yii::t('sigi.labels','PISO'); 
              }
             $pisos[$x]=$prefijo.' '.abs($x);
            }
           $pisos[0]=yii::t('sigi.labels','AZOTEA');
        return $pisos;
    }
    
   public static function getCboGrupos($id_edificio){
        $apode= \frontend\modules\sigi\models\SigiCargosgrupoedificio::find()
                ->where(['edificio_id'=>$id_edificio])
                ->all();
 
        return ArrayHelper::map($apode,
                'codgrupo','descripcion');
        
    }  
    
    public static function getCboTipoResidente(){
        return [
            \frontend\modules\sigi\models\SigiUnidades::TYP_PROPIETARIO=>yii::t('sigi.labels','PROPIETARIO') ,
            \frontend\modules\sigi\models\SigiUnidades::TYP_INQUILINO=>yii::t('sigi.labels','INQULINO') ,
            // \frontend\modules\sigi\models\SigiUnidades::TYP_EX_PROPIETARIO=>yii::t('sigi.labels','ANTERIOR-PROPIETARIO') ,
            // \frontend\modules\sigi\models\SigiUnidades::TYP_EX_INQUILINO=>yii::t('sigi.labels','ANTERIOR-INQUILINO') ,
            ];
    } 
    
    /*
     * Devueklve las juntas de ropietarios del un edificio, solo
     * las juntas directivas 
     */
      public static function getCboJuntas($idedificio){
         $apode= \frontend\modules\sigi\models\SigiApoderados::find()
                 ->select(['codpro'])
                 ->where(['edificio_id'=>$idedificio,'tienejunta'=>'1'])->asArray()->all();
         
 $codigos=ArrayHelper::getColumn($apode, 'codpro');
         //VAR_DUMP($apode,$idedificio,$codigos);DIE();
        return ArrayHelper::map(
                \common\models\masters\Clipro::find()->
                where(['in',
              'codpro', $codigos
               ])->all(),
                'codpro','despro');
    }
    
    /*
     * Saca los colectores de emision individual
     * solo los indinviduales
     * POR EJEMPLO MULTAS, LAVANDERIA, RESERVAS 
     */
    public function getCboColectorNoMasivo($idedificio){
         $colec= \frontend\modules\sigi\models\VwSigiColectores::find()
                 ->select(['idcolector','descargo'])
                 ->where(['edificio_id'=>$idedificio,'individual'=>'1'])->asArray()->all();
         return ArrayHelper::map($colec,'idcolector','descargo'); 
    }
    
    /*
     * Saca los colectores de emision masiva
     * solo los imasivas Y ADEMAS  NO presuspuestos 
     * 
     * YA NO MULTAS SOLO RECOBOS DE AGUA, CUOTAS EXTRAPORDINARIAS ETC 
     * 
     */
    public function getCboColectorMasivo($idedificio){
         $colec= \frontend\modules\sigi\models\VwSigiColectores::find()
                 ->select(['idcolector','descargo'])
                 ->where(['edificio_id'=>$idedificio])
                 ->andWhere(['=','montofijo','0'])
                // ->andWhere(['<>','regular','1'])
                  ->andWhere(['=','individual','0'])
                 ->asArray()->all();
         
         /*echo  \frontend\modules\sigi\models\VwSigiColectores::find()
                 ->select(['idcolector','descargo'])
                 ->where(['edificio_id'=>$idedificio])
                 ->andWhere(['=','montofijo','0'])
                // ->andWhere(['<>','regular','1'])
                  ->andWhere(['=','individual','0'])->createCommand()->getRawSql();DIE();
         */
                  return ArrayHelper::map($colec,'idcolector','descargo'); 
    }
    
    
    
     public function getCboColectores($idedificio){
         $colec= \frontend\modules\sigi\models\VwSigiColectores::find()
                 ->select(['idcolector','descargo'])
                 ->where(['edificio_id'=>$idedificio,/*'individual'=>'1'*/])->asArray()->all();
         return ArrayHelper::map($colec,'idcolector','descargo'); 
    }
    
      public static function getCboUnitsByEdificio($id_edificio){
     
          return ArrayHelper::map(
                          \frontend\modules\sigi\models\SigiUnidades::find()
                  ->where(['edificio_id'=>$id_edificio])
                   ->andWhere(['imputable'=>'1'])->
                  all(),
                'id','numero'); 
     
    }
    
    
    public static function getCboUnitsNotImputables($id_edificio){
     
          return ArrayHelper::map(
                          \frontend\modules\sigi\models\SigiUnidades::find()
                  ->where(['edificio_id'=>$id_edificio])
                  ->andWhere(['not',['imputable'=>'1']])->all(),
                'id','numero'); 
      
       
    }
}


