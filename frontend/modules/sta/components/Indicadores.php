<?php
/*Numero de atenciones por alumno */
/*SELECT COUNT(a.id),a.talleresdet_id,a.codfac,b.codalu  
from 7av4v_sta_citas a,7av4v_sta_talleresdet b
 where a.talleresdet_id=b.id
  and  flujo_id in (2,3)  and a.asistio='1' 
  group by a.talleresdet_id,a.codfac,b.codalu  order by 
  COUNT(a.id),b.codfac desc*/
  


/*Numero de atenciones por psicologo por acultad */
 /* SELECT COUNT(a.id),a.codtra,a.codfac
from 7av4v_sta_citas a
 where flujo_id in (2,3)  and a.asistio='1' 
  group by a.codtra,a.codfac  order by 
  COUNT(a.id),a.codtra desc*/




  /*Numero de atenciones por psicologo  */
    /*SELECT COUNT(a.id),a.codtra
from 7av4v_sta_citas a
 where flujo_id in (2,3)  and a.asistio='1' 
  group by a.codtra order by 
  COUNT(a.id) desc*/


namespace frontend\modules\sta\components;
use common\helpers\h;
use common\models\base\modelBase;
use common\helpers\timeHelper;
use yii;
use frontend\modules\sta\models\Citas;
class Indicadores {
    
private static function queryCitasCount(){   
       RETURN Citas::find()->select('count(*)');
   }
 

private static function queryCitasCountByFacu(){
  return Citas::find()->select(['count(codfac) as ncitas','codfac']);
}



public static function nCitasTotales($codperiodo=null,$codfac=null){
   if(!is_null($codperiodo) && !is_null($codfac)){
     return self::queryCitasCount()->
         andWhere([/*'activo'=>'1',*/'codperiodo'=>$codperiodo,'codfac'=>$codfac])->scalar();  
   }
   return self::queryCitasCount()->scalar();
}

/*Asitencias globales por Periodo y facultad*/
public static function nAsistencias($codperiodo=null,$codfac=null){
    $horas=h::gsetting('sta', 'nhorasreprogramacion');
     $carbonAtras= modelBase::CarbonNow()->subHours($horas); 
    $queryOriginal=self::queryCitasCount()->andWhere(['asistio'=>'1'])->
            andWhere(['<','fechaprog',$carbonAtras->format(timeHelper::formatMysqlDateTime())]);
    
    if(!is_null($codperiodo) && !is_null($codfac)){
       return $queryOriginal->andWhere([/*'activo'=>'1',*/'codperiodo'=>$codperiodo,'codfac'=>$codfac])->scalar();
    }
  return  $queryOriginal->scalar();
}

/*Indicador de asistencia Globarl por periodo*/
public function asistenciaGlobal($codperiodo=null,$codfac=null){     
        $totales=self::nCitasTotales($codperiodo,$codfac);
    if($totales>0)
    return self::nAsistencias($codperiodo,$codfac)/$totales;
    return 0;
}
/*
 * Devuelve un array con los siguientes valores
 *    [
 *              'FIM'=>32,
 *              'FIA'=>56,
 *              'FIIS'=>78 *
 *     ]
 * Claves:  Codigos de facultad, cantidad de citas totales hechas
 */
public static function citasFacultades(){
  // echo self::queryCitasCountByFacu()->groupBy('codfac')->createCommand()->getRawSql();die();
   $filas= self::queryCitasCountByFacu()->groupBy('codfac')->asArray()->all();
  
   /*echo self::queryCitasCountByFacu()->groupBy('codfac')->createCommand()->getRawSql()."<br><br>";
   yii::error(self::queryCitasCountByFacu()->groupBy('codfac')->createCommand()->getRawSql());
   yii::error( array_column($filas,'codfac'));
    yii::error($filas);
   yii::error(array_column($filas,'ncitas')); 
   return [];
   */
   return array_combine(
          array_column($filas,'codfac'),
          array_column($filas,'ncitas')
          );
}

/*
 * Devuelve un array con los siguientes valores
 *    [
 *              'FIM'=>32,
 *              'FIA'=>56,
 *              'FIIS'=>78 *
 *     ]
 * Claves:  Codigos de facultad, cantidad de citas ASISTIDAS
 */
public static function asistenciasFacultades(){
  $horas=h::gsetting('sta', 'nhorasreprogramacion');
     $carbonAtras= modelBase::CarbonNow()->subHours($horas);
  $filas= self::queryCitasCountByFacu()->
 andWhere([
    // 'activo'=>'1',
     'asistio'=>'1',     
     ] )->
     andWhere([
         '<',
         'fechaprog',$carbonAtras->format(timeHelper::formatMysqlDateTime())
      ])->groupBy('codfac')->asArray()->all();
 yii::error(self::queryCitasCountByFacu()->
 andWhere([
    // 'activo'=>'1',
     'asistio'=>'1',     
     ] )->
     andWhere([
         '<',
         'fechaprog',$carbonAtras->format(timeHelper::formatMysqlDateTime())
      ])->groupBy('codfac')->createCommand()->getRawSql());
 /*echo  self::queryCitasCountByFacu()->
 andWhere([
    // 'activo'=>'1',
     'asistio'=>'1',     
     ] )->
     andWhere([
         '<',
         'fechaprog',$carbonAtras->format(timeHelper::formatMysqlDateTime())
      ])->groupBy('codfac')->createCommand()->getRawSql()."<br><br>";
 yii::error( array_column($filas,'codfac'));
 yii::error( array_column($filas,'ncitas'));
 
 return [];*/
  return array_combine(
          array_column($filas,'codfac'),
          array_column($filas,'ncitas')
          );
}

/*
 * Esta función devuelve un array con los valores de asistencias 
 *    [
 *            'FIM'=>[
 *                      'ncitas'=>456,
 *                      'nasistencias'=>340,
 *                      'pasistencias'=>65.3 %,
 *                      ],
 *          'FIC'=>[
 *                      'ncitas'=>156,
 *                      'nasistencias'=>240,
 *                      'pasistencias'=>15.3 %,
 *                      ],
 *     ]
 */
public static function IAsistenciasPorFacultad(){
    $asistencias=self::asistenciasFacultades(); 
    $citas=self::citasFacultades();
    $facultadesTotales=\frontend\modules\sta\models\Facultades::find()->select(['codfac'])->column();
   
    $faltanFacultadesCitas=array_diff($facultadesTotales,array_keys($citas));
    foreach($faltanFacultadesCitas as $codfacultad){
        $citas[$codfacultad]=0;
    }
    
    
    $faltanFacultadesAsistencias=array_diff(array_keys($citas),array_keys($asistencias));
    foreach($faltanFacultadesAsistencias as $codfacultad){
        $asistencias[$codfacultad]=0;
    }
    
    $indicador=[];
    foreach($citas as $codfac=>$numerocitas){
        $indicador[$codfac]['ncitas']=$numerocitas;
        $indicador[$codfac]['nasistencias']=$asistencias[$codfac]+0;
         $indicador[$codfac]['pasistencias']=(($numerocitas+0)>0)?round($asistencias[$codfac]*100/($numerocitas+0),1):0;
    }
  return $indicador;  
}

/*
 * Devuelve un ActiveQuery  para trabajarlo cuon cualquier Where 
 * Es una select de todos los resultados
 */
public static function queryResultadosBase(){
    
    return \frontend\modules\sta\models\StaResultados::find()->
            select(['puntaje_total','percentil','categoria','b.nombre','b.nemonico'])->
            join('INNER JOIN','{{%sta_testindicadores}} b','indicador_id=b.id')->
            orderBy('b.ordenabs ASC');
           
   
    }

    



public static function queryResultadosByFac($codfac){
    return static::queryResultadosBase()->andWhere(['codfac'=>$codfac]);
}


public static function queryCountCategoriasResultadosBase(){
   
  return \frontend\modules\sta\models\StaResultados::find()->
            select(['count(categoria) as ncategoria','categoria','b.nombre'])->
            join('INNER JOIN','{{%sta_testindicadores}} b','indicador_id=b.id')->
            groupBy(['categoria','b.nombre'])->
            orderBy('b.ordenabs, categoria ASC');   
}
public static function queryNIndicadoresBase(){
  return \frontend\modules\sta\models\StaResultados::find()->
            select(['count(indicador_id) as nindicador','b.nombre'])->
            join('INNER JOIN','{{%sta_testindicadores}} b','indicador_id=b.id')->
            groupBy(['b.nombre'])->
            orderBy('b.ordenabs ASC');   
}

public static function  queryCategoriasFaltantes(){
 return \frontend\modules\sta\models\StaResultados::find()->
            select(['count(b.nombre) as nindi','categoria'])->
            join('INNER JOIN','{{%sta_testindicadores}} b','indicador_id=b.id')->
            groupBy(['categoria'])->having(['<','count(b.nombre)',3]);      
}

public static function queryCountCategoriasResultadosBaseFilter($codfac,$codperiodo){
    /*
     * Sacado los retirados
     */
    $IdsExamenes= \frontend\modules\sta\models\Examenes::find()->
            withRetired()->select(['id'])->
            andWhere(['status'=> \frontend\modules\sta\models\Aluriesgo::FLAG_RETIRADO,'codfac'=>$codfac])->column();
    return static::queryCountCategoriasResultadosBase()->
           andWhere(['not in','examen_id',$IdsExamenes])-> 
            andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo]);
}
public static function queryNIndicadoresBaseFilter($codfac,$codperiodo){
    return static::queryCountCategoriasResultadosBase()->andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo]);
}

public static function  queryCategoriasFaltantesByFac($codfac,$codperiodo){
 return static::queryCategoriasFaltantes()->andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo]);    
}

public static function expresionColumna(){
  return new yii\db\Expression("SUBSTR(c_1,1, 1) >='0' and SUBSTR(c_1,1, 1) <>'@'");  
}

public static function IndiAvances($codperiodo=null,$codfac=null,$codtra=null){
  if(is_null($codperiodo)) {
     $codperiodo= \frontend\modules\sta\staModule::getCodPeriod();
  }
 $query= \frontend\modules\sta\models\StaResumenasistencias::
     find()->andWhere(['codperiodo'=>$codperiodo]);
 if(!is_null($codfac)){
    $query->andWhere(['codfac'=>$codfac]); 
 }
 if(!is_null($codtra)){
    $query->andWhere(['codtra'=>$codtra]); 
 }

 
 $totales=$query->select(['count(*) as ntotal','codfac'])->
    groupBy('codfac')->asArray()->all();
    
    $exp = self::expresionColumna();
     $examenes=$query->select(['count(c_1) as nexam'])->
            andWhere($exp)
            ->groupBy('codfac')->asArray()->all();
   $informes=$query->select(['count(n_informe) as ninforme'])->
            andWhere(['>=','n_informe',3])->groupBy('codfac')->
            asArray()->all();
  // echo $query->select(['count(*) as ntotal','codfac'])->
   // groupBy('codfac')->createCommand()->getRawSql();
    
     return [
        'facultades'=>array_column($totales,'codfac'),
        'ntotales'=>array_map('intval',array_column($totales,'ntotal')),
         'informes'=>array_map('intval',array_column($informes,'ninforme')),
        'examenes'=>array_map('intval',array_column($examenes,'nexam'))
        ];
    
}


public function IndiAvanceByFac($codperiodo,$codfac){
    $indicadoresTodos=self::IndiAvances($codperiodo,$codfac);
    
    
    $indice= array_search($codfac, $indicadoresTodos['facultades']);
   return [
       'facultades'=>[$indicadoresTodos['facultades'][$indice]],
        'ntotales'=>[$indicadoresTodos['ntotales'][$indice]],
         'informes'=>[$indicadoresTodos['informes'][$indice]],
        'examenes'=>[$indicadoresTodos['examenes'][$indice]],
    ];
}



public function IndiAvanceByPsico($codperiodo,$codfac,$codtra){
    $indicadoresTodos=self::IndiAvances($codperiodo,$codfac,$codtra);
   if(count($indicadoresTodos['facultades'])>0){
     $indice= array_search($codfac, $indicadoresTodos['facultades']);
          return [
       'facultades'=>[$indicadoresTodos['facultades'][$indice]],
        'ntotales'=>[$indicadoresTodos['ntotales'][$indice]],
         'informes'=>[$indicadoresTodos['informes'][$indice]],
        'examenes'=>[$indicadoresTodos['examenes'][$indice]],
           ];  
    }else{
         return [
       'facultades'=>0,
        'ntotales'=>0,
         'informes'=>0,
        'examenes'=>0,
           ];  
    }
    
}

public function pesos(){
    
}

public function porcAvanceGrupo($idGrupo){
    
}


public static function IndicadorAvance($codperiodo=null,$codfac=null,$codtra=null){
    $exp=self::expresionColumna();
    $query=\frontend\modules\sta\models\StaResumenasistencias::
     find()->where(['codperiodo'=>self::codperiodo($codperiodo)]);
     if(!is_null($codfac)){
       $query->andWhere(['codfac'=>$codfac]);
   }
   if(!is_null($codtra)){
       $query->andWhere(['codtra'=>$codtra]);
   }
    /*Caluclando el porcentaje de la evaluaion inicial*/
$totalAlumnos=self::ntotalAlumnosPrograma($codperiodo=null,$codfac=null,$codtra=null);
$examenes=$query->select(['count(c_1) as nexam'])->andWhere($exp)->count();
$informes=$query->select(['count(n_informe) as ninforme'])->andWhere(['>=','n_informe',3])->count();



//$totalTutorias=$totalAlumnos*

    
    
}

Public static function  codperiodo($codperiodo=null){
   return (is_null($codperiodo))?\frontend\modules\sta\staModule::getCurrentPeriod():$codperiodo;
}

public static function ntotalAlumnosPrograma($codperiodo=null,$codfac=null,$codtra=null){
    $query= \frontend\modules\sta\models\VwAlutaller::find()
        ->completeFacultades()->andWhere(['codperiodo'=>self::codperiodo($codperiodo)]);
   if(!is_null($codfac)){
       $query->andWhere(['codfac'=>$codfac]);
   }
   if(!is_null($codtra)){
       $query->andWhere(['codtra'=>$codtra]);
   }
   //echo $query->createCommand()->getRawSql();
    return $query->count();   
}

public static function cantidades($codperiodo){
   return \frontend\modules\sta\models\StaResumenasistencias::find()-> 
    select(['count(codalu) as nalumnos','codfac'])
    ->andWhere(['codperiodo'=>$codperiodo])-> 
    groupBy(['codfac'])->asArray()->all();
}

public static function cantidadesNoEvaluadas($codperiodo){
    $exp=self::expresionColumna();
   return \frontend\modules\sta\models\StaResumenasistencias::find()-> 
    select(['count(codalu) as nalumnos','codfac'])
    ->andWhere(['codperiodo'=>$codperiodo])->andWhere($exp)->
    groupBy(['codfac'])->asArray()->all();
}

public static function cantidadesExamenes($codperiodo=null){
   
$idsBlancos= \frontend\modules\sta\models\StaExamenesdet::find()-> 
    select(['examenes_id'])
    ->andWhere(['not',['valor'=>null]])->column();
return \frontend\modules\sta\models\Examenes::find()-> 
    andWhere(['not in','id',$idsBlancos])->count();
}

public static function cantidadAtenciones($codperiodo){
    $asistencias=\frontend\modules\sta\models\StaResumenasistencias::find()
    ->select(['sum(tmarzo) as marzo','sum(tabril) as abril ','sum(tmayo) as mayo','sum(tjunio) as junio','sum(tjulio) as julio','sum(tagosto) as agosto','sum(c_21) as total'])->
            andWhere(['codperiodo'=>$codperiodo])->asArray()->all();
   return $asistencias;
    
}




/*Metricas de un alumno en riesgo*/

/*Numero de asistencias a tutorias
    @asistencia=true  filtro='1'   da el numero de asitencia
 *  @asistencia=false no hay filtro   da el numero total de citas
 *  */
public static function nAsistenciasTutoriaAlumno($asistencias=true){
   $ids= \frontend\modules\sta\models\StaFlujo::idsFlujosNoEventos($codperiodo);
   $query=Citas::find()->andWhere([
       'talleresdet_id'=>$talleresdet_id,
       'flujo_id'=>$ids,
       //'asistio'=>'1'
   ]);
   if($asistencias){
       return $query->andWhere(['asistio'=>'1'])->count();
   }else{
       return $query->count();
   }
}


/*Primero la asistencia como cumplimiento*/
public static function IAlumno_asistencias($talleresdet_id,$codperiodo){
  
   
}



}

?>

