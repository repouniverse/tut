<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\models\Aluriesgo;
use frontend\modules\sta\models\UserFacultades;
use frontend\modules\sta\models\Talleresdet;
use frontend\modules\sta\models\Rangos;
use common\models\masters\Trabajadores;
use common\models\masters\Trabajadores AS Psicologo;
use yii\helpers\ArrayHelper;
use Yii;
use common\interfaces\rangeInterface;
use common\helpers\h;
USE \yii2mod\settings\models\enumerables\SettingType;
   use \common\traits\timeTrait;
   USE common\helpers\RangeDates;
use Carbon\Carbon;
/**
 * This is the model class for table "{{%sta_talleres}}".
 *
 * @property int $id
 * @property string $codfac
 * @property string $codtra
 * @property string $codtra_psico
 * @property string $fopen
 * @property string $fclose
 * @property string $codcur
 * @property string $activa
 * @property string $codperiodo
 * @property string $electivo
 * @property int $ciclo
 *
 * @property StaMaterias $codcur0
 * @property StaFacultades $codfac0
 * @property StaPeriodos $codperiodo0
 */
class Talleres extends \common\models\base\DocumentBase implements rangeInterface
{
 use timeTrait;
    public $dateorTimeFields=[
       'fopen'=> self::_FDATE,
         'fclose'=> self::_FDATE,
        'finicitas'=> self::_FDATE,
       ];
   //public $hardFields=['codfac','codperiodo'];
    public $_rangesArray=[];
   
    
    
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_talleres}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ciclo'], 'integer'],
             [['descripcion','duracioncita','codfac','codperiodo','codtra','codtra_psico','fopen'], 'required'],
            [['codfac'], 'string', 'max' => 8],
            [['descripcion'], 'string', 'max' => 40],
            [['tolerancia','duracioncita'], 'safe'],
            // [['descripcion'], 'string', 'max' => 40],
            [['codtra', 'codtra_psico', 'codperiodo'], 'string', 'max' => 6],
            [['fopen', 'fclose', 'codcur'], 'string', 'max' => 10],
            [['activa', 'electivo'], 'string', 'max' => 1],
           // [['codcur'], 'exist', 'skipOnError' => true, 'targetClass' => Materias::className(), 'targetAttribute' => ['codcur' => 'codcur']],
            [['codfac'], 'exist', 'skipOnError' => true, 'targetClass' => Facultades::className(), 'targetAttribute' => ['codfac' => 'codfac']],
            [['codperiodo'], 'exist', 'skipOnError' => true, 'targetClass' => Periodos::className(), 'targetAttribute' => ['codperiodo' => 'codperiodo']],
         [['detalles','finicitas'], 'safe','on'=>'default'],
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'codfac' => Yii::t('sta.labels', 'Facultad'),
            'numero' => Yii::t('sta.labels', 'Número'),
             'descripcion' => Yii::t('sta.labels', 'Descripción'),
            'codtra' => Yii::t('sta.labels', 'Responsable'),
            'codtra_psico' => Yii::t('sta.labels', 'Tutor Adjunto'),
            'fopen' => Yii::t('sta.labels', 'F Inicio'),
            'fclose' => Yii::t('sta.labels', 'F Cierre'),
            'codcur' => Yii::t('sta.labels', 'Codcur'),
            'activa' => Yii::t('sta.labels', 'Activa'),
            'codperiodo' => Yii::t('sta.labels', 'Periodo'),
            'electivo' => Yii::t('sta.labels', 'Electivo'),
            'ciclo' => Yii::t('sta.labels', 'Ciclo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getCodcur0()
    {
        return $this->hasOne(Materias::className(), ['codcur' => 'codcur']);
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
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

    /**
     * {@inheritdoc}
     * @return TalleresQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TalleresQuery(get_called_class());
    }
    
    /*
     * Cargalos alumnos de la lista de entregas 
     * em riesgo 
     */
    public function loadStudents(){
        $data=$this->studentsInRiskForThis();
        
        $cantidad=count($data);
       // ECHO $cantidad; die();
        $contador=0;
       foreach($data as $fila){
          IF(Talleresdet::firstOrCreateStatic([
               'talleres_id'=>$this->id,
               'codalu'=>$fila['codalu'],
              'codfac'=>$this->codfac,
           ], Talleresdet::SCENARIO_BATCH ))
          $contador++;        
       }
       return ['total'=>$cantidad,'contador'=>$contador];
    }
    
    pUBLIC function studentsInRiskForThis(){
         $query=Aluriesgo::studentsInRiskQuery();
        
        $query->andWhere([
               'codfac'=>$this->codfac,
               'codperiodo'=>$this->codperiodo
                   ]);
         /*echo $query->createCommand()->getRawSql();die();
         /*
        if(count(UserFacultades::filterFacultades())==1){
          $data=$query->asArray()->all();
        }else{
           $data=$query->where([
               'codfac'=>$this->codfac,
               'codperiodo'=>$this->codperiodo
                   ])->asArray()->all();
        }*/
        return $query->asArray()->all();
    }
    
    /*
     * Detecta si hay nuevos estudiantes en riesgo este periodo 
     * Consultando la tabla ALURIESGO
     */
    public function newStudentsInRisk(){
       return Aluriesgo::studentsInRiskQuery()->
                 andWhere([
               'codfac'=>$this->codfac,
               'codperiodo'=>$this->codperiodo
                   ])->
                andWhere(['not in',
              'codalu',$this->codesStudents()
               ])->all();
      
    }
    
   public function addPsico($codtra){
       
       
   }
   /*
    * Obtiene la cantidad de alumnos asignados
    * de tutor dentro del programa
    */
   public function busyStudents(){
      return  Talleresdet::find()->where(['talleres_id'=>$this->id])->
          andWhere(['not', ['codtra' => null]])        
          ->all();
       
   }
   
   /*
    * Obtiene la cantidad de alumnos libres
    * de tutor dentro del programa
    */
   public function freeStudents(){
      return  Talleresdet::find()->where(['talleres_id'=>$this->id])->
          andWhere(['codtra' => null])        
          ->all();
       
   }
   
   /*
    * Esta funcion devuelve las cantidades de alunos or turor
    */
   public function countStudentsByTutor($tutor){
      return  Talleresdet::find()->where(['talleres_id'=>$this->id])->
          andWhere(['codtra' => $tutor])        
          ->count();
       
   }
   
   /*
    * Esta funcion devuelve las cantidades de alunos or turor
    */
   public function countStudentsFree(){
      return  Talleresdet::find()->where(['talleres_id'=>$this->id])->
          andWhere(['codtra' => null])        
          ->count();
       
   }
   
   
   
   /*
    * esta funcion sincroniza las cantidades con 
    * las cantidades en la  tabla TALLER_PSICO
    * Especialmente cuando se agregan o se retiran alumns del programa 
    */
   public function sincronizeCant(){
       foreach($this->tutores as $filaTutor){
           $filaTutor->setScenario($filaTutor::SCENARIO_CANTIDAD);
           $filaTutor->nalumnos=$this->countStudentsByTutor($filaTutor->codtra);
          if(!$filaTutor->save())yii::error($filaTutor->getFirstError(),__METHOD__);
       }
   }
   
   public function beforeSave($insert) {
       
        if($insert){
            //$this->prefijo=$this->codfac;
           $this->resolveCodocu();
           IF(empty($this->tolerancia))
               $this->tolerancia='0.1';
            $this->numero=$this->correlativo('numero');
        }
        
        return parent::beforeSave($insert);
       
    }
    
    public function afterSave($insert,$changedAttributes) {
       
        if($insert){
            //$this->prefijo=$this->codfac;
           $this->refresh();
            $this->createRangos($this->id); //Llena la tabla rangos por unica vez 
        
         }
        
        return parent::afterSave($insert,$changedAttributes);
       
    }
    
    
    /*
     * Funcion que crea los rnago u horarios para los 7 días 
     * de la semana
     */
    public function createRangos($id){
        $attributes=[];
        foreach(\common\helpers\timeHelper::daysOfWeek() as $key=>$day){
            $attributes=[
                        'nombredia'=>$day,
                         'talleres_id'=>$id,
                        'dia'=>$key,
                        'hinicio'=> h::getIfNotPutSetting('sta','horainicio','09:00', SettingType::STRING_TYPE),
                        'hfin'=> h::getIfNotPutSetting('sta','horafin','17:00', SettingType::STRING_TYPE),
                        'tolerancia'=> h::getIfNotPutSetting('sta','tolerancia',0.1, SettingType::FLOAT_TYPE),
                         'activo'=>(!in_array($key,[0,6]))?false:true,//SI ES SABADO O DOMINGO POR DEFAULT ES FALSE 
                ];
         Rangos::firstOrCreateStatic($attributes);
            //yii::error($attributes);
        }
       return true;
    }
    
    
    /*
     * Esta funcion extrae los rangos de JORNADAS 
     * validos para programar las citas dentros de ellos 
     * dveulve:
     * array de oBJETOS RangeDate
     * Representando todos los rangos a
     */
    
    
    public function rangesToDates(){
        $carbones=[];
        $CarbonInicio=$this->toCarbon('finicitas');
       $rangos=$this->rangesArray();
         $nsemanas=h::getIfNotPutSetting('sta','nSemanasParaCitas',3,SettingType::INTEGER_TYPE);
       $periodo=\Carbon\CarbonPeriod::create(
                $this->swichtDate('finicitas', false),
                $CarbonInicio->addWeek($nsemanas)->format('Y-m-d'));
          foreach($periodo as $CarbonP){              
              if($rangos[$CarbonP->dayOfWeek]['activo']=='1' &&
                  !$this->isHolyDay($CarbonP)){
                  $hinicio=(integer)substr($rangos[$CarbonP->dayOfWeek]['hinicio'],0,2);
                  $minicio=(integer)substr($rangos[$CarbonP->dayOfWeek]['hinicio'],3,2);
                   $hfinal=(integer)substr($rangos[$CarbonP->dayOfWeek]['hfin'],0,2);
                   $mfinal=(integer)substr($rangos[$CarbonP->dayOfWeek]['hfin'],3,2);
                  $carbones[]=new RangeDates([
                      $CarbonP->hour($hinicio)->minute($minicio)->copy(),
                      $CarbonP->hour($hfinal)->minute($mfinal)->copy()
                  ]);
                 }
              }
         return $carbones;           
      
    }
      
    
    
    
    
    
      /*dEVUELVE LAS HORAS HINICIA Y FINAL DENTRO DEL
       * RANGO ADJUNTO , SE LE PAS EL NUMERO DE DIA 
       * 0 DOMINO, LUNES 1, MARTES 2 
       */
      private function hoursInRange($ndia){
         
      }
      
      private function rangesArray(){
          if(empty($this->_rangesArray)){
              foreach($this->ranges as $filaRange){
               $this->_rangesArray[$filaRange->dia]=[
                         'hinicio'=>$filaRange->hinicio,
                         'hfin'=>$filaRange->hfin,
                         'activo'=>$filaRange->activo,
                         ];
              }
          }
          return $this->_rangesArray;
      }
      
      
      /*Esta funcion hace un par de carbones 
       * dada una fecha  un carbnon con la fecha-hora de inicio
       * y tro Carbsn la fecha hora termino d edia 
       * Dando solo una fecha 
       * var : $fecha   Carbon
       * Ojo: solo busca dentro de los dias marcados como activos 
       */
      public function  range($fecha=null){
           ///Solo los dias o jornadas  activos , ooj verifique bien 
          //la programacion
           $rangos=$this->rangesArray();
           //Si el dia cae dentro del rango
           if(array_key_exists($fecha->dayOfWeek, $rangos)){
               $hinicio=substr($rangos[$fecha->dayOfWeek]['hinicio'],0,2)+0;
                $hfinal=substr($rangos[$fecha->dayOfWeek]['hfin'],0,2)+0;
                $minicio=substr($rangos[$fecha->dayOfWeek]['hinicio'],3,2)+0;
                $mfinal=substr($rangos[$fecha->dayOfWeek]['hfin'],3,2)+0;
                /*yii::error('hora inicio '.$hinicio);
                 yii::error('hora final '.$hfinal);
                  yii::error($fecha->hour($hinicio)->copy());
                  yii::error($fecha->hour($hfinal)->copy());*/
               //$carbonInicio=$fecha->hour()->
                $rang=new \common\helpers\RangeDates([
                  $fecha->hour($hinicio)->minute($minicio)->copy(),
                 $fecha->hour($hfinal)->minute($mfinal)->copy() 
                  ]);
           }else{
              $rang=null;
           }
         unset($carbon);
            return $rang;
      }
      
      
      
    
     
     private function codesStudents(){
        return ArrayHelper::getColumn($this->studentsInRiskForThis(),'codalu');
     }
      
     
     /*
      * Codes: Cualquier lista de codigos, que satisfagan un criterio 
      * por ejemplo todos los codigos : funcion codesStudents()
      */
     public function listMailStudents($codes=null){
         if(is_null($codes))
           $codes=$this->codesStudents ();
        return Alumnos::listMailFromField('correo',
          ['in','codalu',$codes]);
     }
      
     
     public function citasPendientesQuery(){
        return  Citas::find()->where([
            'talleres_id'=>$this->id])->andWhere([
            '>','fechaprog',date('Y-d-m')
            ]);
     }
     
     public function citasRealizadasQuery(){
        return  Citas::find()->where([
            'talleres_id'=>$this->id,
            'asistio'=>'1'])->andWhere([
            '<=','fechaprog',date('Y-d-m')
            ]);
     }
     public function citasForTodayQuery(){
        return  Citas::find()->where([
            'talleres_id'=>$this->id,
            'asistio'=>'0'])->andWhere([
             'between',
             'fechaprog',
             date('Y-d-m'),
            date('Y-d-m H:i:s',time()+3600*24-1)
                        ]);
     }
     
     public function citasForThisWeekQuery(){
         $dia=date('w');
        return  Citas::find()->where([
            'talleres_id'=>$this->id,
            'asistio'=>'0'])->andWhere([
             'between',
             'fechaprog',
             date('Y-d-m'),
            date('Y-d-m H:i:s',time()+3600*24*(7-$dia))
                        ]);
     }
   
 public function nAlumnos(){
   return Aluriesgo::studentsInRiskByFacQuery($this->codfac)->count();  
   
 } 
 
/*
 * Funciones para KPI
 * Estas funciones deben de ser cacheadas
 */
 
 
 /*Alunos que por lo menos tienen una aistencia */
private function kp_nAlusConAsistencia(){
    $citasAsistidas=array_column(Citas::find()->
            select('talleresdet_id')->distinct()
            ->where(['talleres_id'=>$this->id])
            ->andWhere(['asistio'=>'1'])
            ->asArray()->all(),'talleresdet_id');
  return Talleresdet::find()->where([
      'in','id',$citasAsistidas
  ])->count();
    
}

/*Alunos que han  contestado a alguan llamada o aviso  */
private function kp_nAlusRespondieron(){
    $idtes=array_column($this->getAlumnos()->
            select('id')->distinct()           
           ->asArray()->all(),'id');
    /*var_dump($idtes);*/
    $convocatorias=array_column(StaConvocatoria::find()->
            select('talleresdet_id')->distinct()
            ->where(['in','talleresdet_id',$idtes])
            ->andWhere(['resultado'=>'1']) //contestaron la llamada o aviso 
            ->asArray()->all(),'talleresdet_id');
    /*var_dump(StaConvocatoria::find()->
            select('talleresdet_id')->distinct()
            ->where(['in','talleresdet_id',$idtes])
            ->andWhere(['resultado'=>'1'])->createCommand()->getRawSql());die();*/
  return Talleresdet::find()->where([
      'in','id',$convocatorias
  ])->andWhere([
      'not in','id',
      array_column(Citas::find()->
            select('talleresdet_id')->distinct()
            ->where(['talleres_id'=>$this->id])
            ->andWhere(['asistio'=>'1'])
            ->asArray()->all(),'talleresdet_id')
            ])->count();
    
}

public function kp_contactados(){
   $nalumnos=$this->nAlumnos();
   $conAsistencia=$this->kp_nAlusConAsistencia();
    $respondieron=$this->kp_nAlusRespondieron();
    $sincontacto=$nalumnos-$conAsistencia-$respondieron;
    return [
        Talleresdet::CONTACTO_CON_CITA=>($nalumnos >0)?round(100*$conAsistencia/$nalumnos,1):0,
         Talleresdet::CONTACTO_CON_RESPUESTA=>($nalumnos >0)?round(100*$respondieron/$nalumnos,1):0,
         Talleresdet::CONTACTO_SIN_RESPUESTA=>($nalumnos >0)?round(100*$sincontacto/$nalumnos,1):0,
            ];
}
public static function kp_contactadosEmpty(){
   return [
        Talleresdet::CONTACTO_CON_CITA=>0,
         Talleresdet::CONTACTO_CON_RESPUESTA=>0,
         Talleresdet::CONTACTO_SIN_RESPUESTA=>0,
            ];
}

public function codPsicologos($except=[]){
    $codigos=Tallerpsico::find()->where(['talleres_id'=>$this->id])->
    select('codtra')->column();
    return array_diff($codigos,$except);
}

     
    }

