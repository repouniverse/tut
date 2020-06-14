<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\staModule;
use frontend\modules\sta\models\StaDocuAlu;
use frontend\modules\sta\models\Citas;
use frontend\modules\sta\models\Examenes;
use frontend\modules\sta\models\StaResultados;
use frontend\modules\sta\models\StaPercentiles;
use common\models\masters\Trabajadores;
use \common\helpers\FileHelper;
use common\behaviors\FileBehavior;
use common\behaviors\AccessDownloadBehavior;
use Yii;
 use common\helpers\timeHelper;
  use common\helpers\h;
 
/**
 * This is the model class for table "{{%sta_talleresdet}}".
 *
 * @property int $id
 * @property int $talleres_id
 * @property string $codalu
 * @property string $fingreso
 * @property string $detalles
 * @property string $codtra
 *
 * @property StaTalleres $talleres
 * @property StaAlu $codalu0
 */
class Talleresdet extends \common\models\base\modelBase
{
    
    const SCENARIO_BATCH='batch';
    const SCENARIO_PSICO='psico';
    const SCENARIO_TUTOR='tutor';
    
    const CONTACTO_SIN_RESPUESTA='danger';
    const CONTACTO_CON_RESPUESTA='warning';
    const CONTACTO_CON_CITA='success';
    const SCENARIO_PSICO_PSICO='mipsico';
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_talleresdet}}';
    }

     public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_BATCH] = ['talleres_id','codalu','codfac','status','codtra'];
        $scenarios[self::SCENARIO_PSICO] = ['codtra_psico'];
        $scenarios[self::SCENARIO_TUTOR] = ['rank_tutor','detalle_tutor'];
        $scenarios[self::SCENARIO_PSICO_PSICO] = ['codtra'];
       // $scenarios[self::SCENARIO_BATCH] = [ 'codcar', 'ap', 'am', 'nombres', 'dni','domicilio','correo','celulares','fijos'];
       // $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];
        return $scenarios;
    }
    
    public function behaviors()
         {
                return [
		'AccessDownloadBehavior' => [
			'class' => AccessDownloadBehavior::className()
		],
		'fileBehavior' => [
			'class' => FileBehavior::className()
		],
                    'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
		
                    ];
        }
    
    
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['talleres_id', 'codalu'], 'required'],
            [['talleres_id'], 'integer'],
            [['detalles'], 'string'],
            [['rank_psico','rank_tutor','status','codtra','clase','codocu'], 'safe'],
            [['codalu'], 'string', 'max' => 14],
            [['fingreso'], 'string', 'max' => 10],
            [['codtra'], 'string', 'max' => 6],
            [['talleres_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleres::className(), 'targetAttribute' => ['talleres_id' => 'id']],
            [['codalu'], 'exist', 'skipOnError' => true, 'targetClass' => Alumnos::className(), 'targetAttribute' => ['codalu' => 'codalu']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'talleres_id' => Yii::t('sta.labels', 'Talleres ID'),
            'codalu' => Yii::t('sta.labels', 'Codalu'),
            'fingreso' => Yii::t('sta.labels', 'Fingreso'),
            'detalles' => Yii::t('sta.labels', 'Detalles'),
            'codtra' => Yii::t('sta.labels', 'Codtra'),
            'detalle_tutor' => Yii::t('sta.labels', 'Detalles'),
            'rank_tutor' => Yii::t('sta.labels', 'Calificación'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTalleres()
    {
        return $this->hasOne(Talleres::className(), ['id' => 'talleres_id']);
    }
public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }
    
     public function getDocumentos()
    {
        return $this->hasMany(StaDocuAlu::className(), ['talleresdet_id' => 'id']);
    }
    
     public function getCitas()
    {
        return $this->hasMany(Citas::className(), ['talleresdet_id' => 'id']);
    }
    
     public function getConvocatorias()
    {
        return $this->hasMany(StaConvocatoria::className(), ['talleresdet_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno()
    {
        return $this->hasOne(Alumnos::className(), ['codalu' => 'codalu']);
    }

    /**
     * {@inheritdoc}
     * @return TalleresdetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TalleresdetQuery(get_called_class());
    }
    
    public function lastCita(){
        
    }
    
    public function tallerPsico(){
       return  Tallerpsico::find()->where(
                [
                    'codtra'=>$this->codtra,
                    //'codtra'=>$this->codtra,
                    'talleres_id'=>$this->talleres_id,
                ]
                )->one();
    }
    /*
     * cREA REGISTROS DE DOCUMENTOS 
     */
    public function generaDocumentos(){
        
   $orden=(StaDocuAlu::find()->where([
        'talleresdet_id'=>$this->id,
       // 'codocu'=>$this->codocu,
        ])->count()>0)?2:1;

        $codes=staModule::docCodes();
       
        foreach($codes as $code){
           if(!($orden==2 && $code==104)){
              StaDocuAlu::firstOrCreateStatic([
                'talleresdet_id'=>$this->id,
                'codocu'=>$code,
                'orden'=>$orden,
                 'codfac'=>$this->codfac,
                 'status'=>Aluriesgo::FLAG_NORMAL,
                    ]); 
           }
            
        }
        
    }
    
    /*
     * fUNCIONQ UE DEVUELVE EL ESTADO DEL ALUMNO 
     * EN FUNCION DE COMO HA RESPONDIDO A LA CONVOCARTORIA 
     * SUCCESS= ALUMNO YA ASISTIO POR LO MENOS A SU ROIEMRA CITA 
     */
    public function statusContact(){
        if($this->hasFirstCita()){
           return self::CONTACTO_CON_CITA; 
        }else{
          if($this->hasFirstAnswer()){
            return self::CONTACTO_CON_RESPUESTA;   
          }else{
            return self::CONTACTO_SIN_RESPUESTA;     
          }   
        }
    }
    
  public function hasFirstCita(){
     return ($this->getCitas()->andWhere(['asistio'=>'1'])->count() > 0)?true:false; 
  }
  
  public function hasFirstAnswer(){
    return($this->getConvocatorias()->andWhere(['resultado'=>'1'])->count()>0)?true:false; 
  }
  
  public function isNotContacted(){
    return(!$this->hasFirstCita() && !$this->hasFirstAnswer())?true:false;
  }
  
  public function inasistencias(){
      
      return $this->citasPasadasQuery()->
              andWhere(['asistio'=>'0'])->
              count();
  }
  
  public function asistencias(){
      
      return $this->citasPasadasQuery()->
              andWhere(['asistio'=>'1'])->
              count();
  }
  
  public function porcentajeAsistencias(){
      $nasistencias=$this->asistencias();
      $totales=$this->citasPasadasQuery()->count();
      if($totales>0)
      return round((100*($nasistencias/$totales)),0);
      return 0;
  }
  
  private function citasPasadasQuery(){
       $horas=h::gsetting('sta', 'nhorasreprogramacion');
       $limite=self::CarbonNow()->subHours($horas)->format(timeHelper::formatMysql());
      return $this->getCitas()->
              andWhere(['<','fechaprog',$limite]);
  }
  
  private function citasPendientesQuery(){
       $horas=h::gsetting('sta', 'nhorasreprogramacion');
       $limite=self::CarbonNow()->subHours($horas)->format(timeHelper::formatMysql());
      return $this->getCitas()->
              andWhere(['>=','fechaprog',$limite])->
              andWhere(['asistio'=>'0'/*,'masivo'=>'0'*/]);
  }
  
  
  
  
  public function cambiaPsicologo($nuevo){
      $oldScenario=$this->getScenario();
      $this->setScenario(self::SCENARIO_PSICO_PSICO);
      $this->codtra=$nuevo;
      $this->save();
      $this->talleres->sincronizeCant();
      $this->setScenario($oldScenario);
      
  }
  
  public function examenesTomados(){
      $citasId=$this->getCitas()->select(['id'])->column();
      $examenesCods=Examenes::find()->select(['codtest'])->distinct()->where(
              ['citas_id'=>$citasId
                  ]);
     return Test::find()->where(['codtest'=>$examenesCods])->asArray()->all();
      
  }


public function indicadores(){
    $arreglo=[];
    $citasId=Citas::find()->select(['id'])->
      andWhere(['talleresdet_id'=>$this->id,'asistio'=>'1'])->column();
   $examenesId=Examenes::find()->select(['id'])->distinct()->
      andWhere(['citas_id'=>$citasId])->column();
    $resultados=StaResultados::find()->select(['categoria','b.nombre','b.id','b.invertido'])->join('INNER JOIN','{{%sta_testindicadores}} b','indicador_id=b.id')->andWhere(['examen_id'=>$examenesId])->asArray()->all();
   foreach( $resultados as $filaResultado){
    
    if($filaResultado['invertido']=='1'){
       // yii::error('esta invertido '.$filaResultado['nombre']);
        $categoria=$filaResultado['categoria'];
        if($categoria==\frontend\modules\sta\models\StaPercentiles::CALIFICACION_ALTO){
            //yii::error('cambiando la caegoria de '.$categoria.'  a   '.\frontend\modules\sta\models\StaPercentiles::CALIFICACION_BAJO);
           $categoria=\frontend\modules\sta\models\StaPercentiles::CALIFICACION_BAJO; 
        }else{
          if($categoria==\frontend\modules\sta\models\StaPercentiles::CALIFICACION_BAJO){
           $categoria=\frontend\modules\sta\models\StaPercentiles::CALIFICACION_ALTO; 
          }  
        }
        
        //yii::error('La categoria inical era '.$filaResultado['categoria']);
        //yii::error('La categoria final queda '.$categoria);
        $arreglo[$categoria][]=$filaResultado['nombre'];
    }else{
      $arreglo[$filaResultado['categoria']][]=$filaResultado['nombre'];  
    }
    
   }
   // yii::error($arreglo);
  return $arreglo;
  
}

public function textoIndicadores($calificacion){
    $arreglo=$this->indicadores();
    $cadena='';
    $contador=1;
    if(!array_key_exists($calificacion,$arreglo)){
        return '';
    }
    foreach($arreglo[$calificacion] as $clave=>$nombre){
        $cadena.=ucfirst(mb_strtolower($nombre,'UTF-8')).',  ';
        //$cadena.='('.$contador.')'.$nombre.'  |  ';
        $contador++;
    }
    return $cadena;
}

public function hasInformeEditado(){
    return $this->getDocumentos()->andWhere(['>','cita_id',0])->exists();
}
public function nInformeEditado(){
    return $this->getDocumentos()->andWhere(['>','cita_id',0])->count();
}


/*
 * Funcion que retira o eliminar retiro 
 * del programa de tutoria, 
 * En realidad solo modfica le FLAG: 'N' 'R'
 * @retiro : true   Retiro /  false  Deshacer retiro
 */
public function retiraDelPrograma($retiro=true){  
    $flag=($retiro)?Aluriesgo::FLAG_RETIRADO: Aluriesgo::FLAG_NORMAL;
    YII::ERROR('eL FALG ES  '.$flag);
    $flagCita=($retiro)?'0':'1';
    $codperiodo=$this->talleres->codperiodo;
    $citasid=$this->idCitas();
    yii::error($citasid);
 if($codperiodo == staModule::getCurrentPeriod()){
       $transaccion=$this->getDb()->beginTransaction(\yii\db\Transaction::SERIALIZABLE);
    /*Mofiicando latabla ALurieso*/
     Aluriesgo::updateAll(
            ['status'=> $flag],
            ['codalu'=>$this->codalu,'codperiodo'=>$codperiodo]);
    /*Mofiicando latabla Tallerdet*/ 
    self::updateAll(
            ['status'=> $flag],
            ['codalu'=>$this->codalu]);
    /*Mofiicando latabla Citas*/ 
     Citas::updateAll(
            ['activo'=> $flagCita],
            [
                'talleresdet_id'=>$this->id,
              
              ]);
     /*Modificando la hoja de asistencia*/
              StaResumenasistencias::deleteAll(['codalu'=>$this->codalu]);
      /*Modificando la tabla de informes*/              
              StaDocuAlu::updateAll(['status'=> $flag], ['talleresdet_id'=> $this->talleres_id]);
    //ECHO Examenes::find()->complete()->select(['id'])->andWhere(['citas_id'=>$citasid])->createCommand()->getRawSql();
    
    /*Sacando el id de los examenes, observe que
     * se usa la funcion complete de activeQueryStatus
     * Esto para evitar el filtro de 'R' cuando querramos 
     * revertir un retiro
     */
    $idExamenes=Examenes::find()->complete()->select(['id'])->andWhere(['citas_id'=>ARRAY_MAP('intval',$citasid)])->column();
      /*Actualizando la tabla Examenes*/
    
      YII::ERROR($idExamenes);
     Examenes::updateAll( ['status'=> $flag], ['id'=>$idExamenes]);
      /*Actualizando la tabla Detalle examenes*/
     StaExamenesdet::updateAll(['status'=> $flag], ['examenes_id'=>$idExamenes]);
       /*Actualizando la tabla Resultados*/
       StaResultados::updateAll(['status'=> $flag], ['examen_id'=>$idExamenes]);
     
    $transaccion->commit();
    return true;
 }else{
   $this->addError('codalu',yii::t('sta.errors','Sólo puede retirar alumnos en el periodo activo'));
 }
   
}




 public static function except(){
    return  self::find()->andWhere(['<>','status', Aluriesgo::FLAG_RETIRADO]);
 }
 
 
 public function idCitas(){
    // VAR_DUMP($this->getCitas()->select(['id']));DIE();
     return $this->getCitas()->select(['id'])->column();
 }
 
public function hasPerformedFirstExamen(){
    /*
     * Ubicando el flujo id de la primera evaluacion
     */
  $haRendido=false;
    $flujo=Staflujo::find()->andWhere(['examen'=>'1',
      'codperiodo'=>$this->talleres->codperiodo
          ])->orderBy('gactividad asc')->one();
    
  if(!is_null($flujo)){
      $flujo_id=$flujo->actividad;
      //var_dump($flujo_id);
      /*Filtrando las citas que corresponde a este flujo de primer examen*/
      $citas=Citas::find()->andWhere([
          'flujo_id'=>$flujo_id,
          'asistio'=>'1',
          'talleresdet_id'=>$this->id
          ])->all();
      /*Recorriéndolas y detectando en cual ha redndio examen*/
      foreach($citas as $cita){
          //var_dump($cita->numero);
         if($cita->hasPerformedTest()){
            // echo "ESTA CITA SI TINENE EXAMEN<BR>";
             $haRendido=true;
             break;
         }
        }
     return $haRendido;
  }else{
      throw new BadRequestHttpException(yii::t('base.errors','Por favor defina la estructura del fujo de trabajo para la priemra evaluacion'));  
  }
  
}
 

public function beforeSave($insert) {
        parent::beforeSave($insert);
        if($insert){
            $this->codocu='411';
             $this->clase= \frontend\modules\sta\staModule::CLASE_RIESGO;
            
        }
        return true ;
    }

/*
 * Zipea los adjuntos de STADOCUENTOS 
 * Y LO GUARAD COO AFJUNTO 
 */
    
public function zipea(){
    $zip=New \ZipArchive();  
    $rutaTemp=\yii::getAlias('@frontend/web/img_repo/temp/'. uniqid().'.zip');
    $zip->open($rutaTemp, \ZipArchive::CREATE);
    foreach ($this->documentos as $documento){
       If(!is_null($model->rutaZip())){
            $zip->addFile($model->rutaZip()); 
        }
    }
    $zip->close();
    return $rutaTemp;
}
    
    
}