<?php
/*
 * Esta clase extiende la clase original
 * pero adicionalmetne devuelve los data
 * para los combos  
 * FACULTADES
 * CARRERAS
 * CARRERAS POR FACULTAD
 */
namespace frontend\modules\sta\helpers;
use common\helpers\ComboHelper as Combito;
use yii\helpers\ArrayHelper;
class comboHelper extends Combito
{
     public static function getCboFacultades(){
        return ArrayHelper::map(
                        \frontend\modules\sta\models\Facultades::find()->all(),
                'codfac','desfac');
    }
    
    public static function getCboPeriodos(){
        return ArrayHelper::map(
                        \frontend\modules\sta\models\Periodos::find()->all(),
                'codperiodo','periodo');
    }
    
    public static function getCboCarreras(){
        return ArrayHelper::map(
                        \frontend\modules\sta\models\Carreras::find()->all(),
                'codcar','descar');
    }
    
    public static function getCboCarrerasByFac($codfac){
        return ArrayHelper::map(
                \frontend\modules\sta\models\Carreras::find()->
                where(['codfac'=>$codfac])->all(),
                'codcar','descar');
    }
    /*
     * Dvel todos los piscologos dentro de una programa
     */
     public static function getCboTutoresByProg($id,$except=[]){
         $psicologos= \frontend\modules\sta\models\Tallerpsico::find()
                 ->select(['codtra'])
                 ->where(['talleres_id'=>$id])->asArray()->all();
 $codigos=ArrayHelper::getColumn($psicologos, 'codtra');
 //var_dump($id,$codigos,'o');die();
 $codigos=array_diff($codigos,$except);
 $trabajadores=\common\models\masters\Trabajadores::find()->select(['codigotra','ap','am','nombres'])->
                where(['in',
              'codigotra', $codigos
               ])->asArray()->all();
 $compilado=[];
//var_dump($trabajadores);die();
 foreach($trabajadores as $trabajador){
    // $compilado[]=[$trabajador['codigotra']=>$trabajador['ap'].$trabajador['am'].$trabajador['nombres']];
     $compilado[$trabajador['codigotra']]=$trabajador['codigotra'].'-'.$trabajador['ap'].'-'.$trabajador['am'].'-'.$trabajador['nombres'];
 }
  
 return $compilado;
        
    }
    
    /*
     * Devuelve todos los testPiscologicos
     */
     public static function getCboTests($idprograma=null){
         
       if($idprograma===null){
           return ArrayHelper::map(
           \frontend\modules\sta\models\Test::find()->all(),
                'codtest','descripcion');
       }else{
           /*return ArrayHelper::map(
           \frontend\modules\sta\models\Test::find()->
                where([])->   
                   all(),
                'codtest','descripcion'); */
       }
         
        }

        
    public static function getCboTestByPrograma($idtaller){
        $tests= \frontend\modules\sta\models\StaTestTalleres::find()
                 ->select(['codtest'])
                 ->where(['taller_id'=>$idtaller])->asArray()->all();
        $codigos=ArrayHelper::getColumn($tests, 'codtest');
        return ArrayHelper::map(
               \frontend\modules\sta\models\Test::find()->
                where(['in',
              'codtest', $codigos
               ])->all(),
                'codtest','descripcion');
    
    }    
  
    public static function geCboRankTutor(){
        return ['A'=>'Buena asistencia y Rendimiento',
                 'B'=>'Buen Rendimiento e Inasistencias',
                 'C'=>'Con inasistencias'];
    }
    
   public static function baterias(){
     return [
         'F17'=>'BATERIA DE EVALUACION PSICOLOGICA F17',
     ];
 }
   
  public static function geCboGruposTest($codtest){
     return ArrayHelper::map( \frontend\modules\sta\models\StaTestdet::find()-> 
      where(['codtest'=>$codtest])->all(),
            'grupo','grupo'); 
    }  
  
    /*
     * Saca las citas que tienen evaluaciones para 
     * ese alumno en ese programa
     * $id: El id del la tala StaDocuAlu
     */
   public static function geCboCitasWithTests($talleresdet_id){
        $query= (new \yii\db\Query())->select(['count(b.citas_id)','a.id','a.numero'])->
    from(['{{%sta_citas}} a'])->
      where([
          'talleresdet_id'=>$talleresdet_id,
          
              ])->innerJoin('{{%sta_examenes}} b','a.id=b.citas_id')
             ->groupBy(['id','numero']);
          
     return ArrayHelper::map($query->all(),
            'id','numero');  
    }
}


