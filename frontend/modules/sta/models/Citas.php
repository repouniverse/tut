<?php

namespace frontend\modules\sta\models;
use common\traits\timeTrait;
use Yii;
use common\interfaces\rangeInterface;
use common\helpers\RangeDates;
use common\helpers\h;
use common\models\masters\Trabajadores;
use frontend\modules\sta\staModule;
use yii\helpers\Url;
/**
 * This is the model class for table "{{%sta_citas}}".
 *
 * @property int $id
 * @property int $talleresdet_id
 * @property int $talleres_id
 * @property string $$maximafechafechaprog
 * @property string $codtra
 * @property string $finicio
 * @property string $ftermino
 * @property string $fingreso
 * @property string $detalles
 * @property string $codaula
 * @property int $nalumnos
 * @property string $fregistro
 * @property string $calificacion
 *
 * @property StaTalleresdet $talleresdet
 * @property StaTalleres $talleres
 * @property Trabajadores $codtra0
 * @property StaExamenes[] $staExamenes
 */
class Citas extends \common\models\base\modelBase implements rangeInterface
{
   
    /*public $nombreAlumno='';
     public $nombrePrograma='';
     public $nombrePsicologo='';
     public $nombreFacultad='';
     public $numeroPrograma='';*/
     
    const SCE_CREACION_BASICA='crea_basica';
    const SCENARIO_ASISTIO='asistio';
    const SCENARIO_ACTIVO='activo';
    const SCENARIO_REPROGRAMA='reprograma';
    use timeTrait;
    public $dateorTimeFields=[
        'fechaprog'=>self::_FDATETIME,
         'finicio'=>self::_FDATETIME,
        'ftermino'=>self::_FDATETIME
    ];
    
    
    
   public $booleanFields=['asistio','activo','masivo'];
   
   public function behaviors()
         {
                return [
		
		/*'fileBehavior' => [
			'class' => '\frontend\modules\attachments\behaviors\FileBehaviorAdvanced' 
                               ],*/
                    'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
		
                    ];
        }
    
   
   
   
    public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios[self::SCE_CREACION_BASICA] = ['talleres_id','talleresdet_id','duracion','fechaprog','codfac','codtra','asistio'];
        $scenarios[self::SCENARIO_ASISTIO] = ['asistio'];
         $scenarios[self::SCENARIO_ACTIVO] = ['activo'];
          $scenarios[self::SCENARIO_REPROGRAMA] = ['fechaprog','duracion','finicio','ftermino'];
        return $scenarios;
    }
    
    
   /*
    * PARAMETRO FECHA SOLO PARA CUMPLIR LE FORAMTO DE LA INTERFAZ
    */ 
    public function range($fecha=null){
       // $this->resolveDuration();
         $carbon1=$this->toCarbon('fechaprog');
        RETURN New RangeDates([
             $carbon1,
            $carbon1->copy()->addMinutes($this->duracion)
        ]);
    }
    
   /*
    * Retorna una cadena con la fecha tope del dia
    * por ejemplo 
    * 25/08/2019 14:55 
    * retorna   
    * 2019-08-25 23:59:59
    * Esto para comparar en sentencias SQL
    */
    public function beginDay(){
       return $this->toCarbon('fechaprog')->endOfDay()->subDay()->format(
               h::gsetting('timeBD','datetime')
               );
              
    }
    
    /*
    * Retorna una cadena con la fecha tope del dia
    * por ejemplo 
    * 25/08/2019 14:55 
    * retorna   
    * 2019-08-25 23:59:59
    * Esto para comparar en sentencias SQL
    */
    public function endDay(){
       return $this->toCarbon('fechaprog')->endOfDay()->format(
               h::gsetting('timeBD','datetime')
               );
    }
    
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_citas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['talleresdet_id', 'talleres_id', 'codtra','fechaprog', 'finicio', 'ftermino'], 'required'],
            [['talleresdet_id', 'talleres_id', 'duracion'], 'integer'],
            [['detalles'], 'string'],
             [['detalles_secre','detalles_tareas_pend','detalles_indicadores','duracion','codfac','asistio','activo','numero'], 'safe'],
            
            [['fechaprog', 'finicio', 'ftermino'], 'string', 'max' => 19],
            ['fechaprog', 'validateDispo'],
                [['masivo'], 'safe'],
            [['codtra'], 'string', 'max' => 6],
            [['fingreso', 'codaula'], 'string', 'max' => 10],
            [['fechaprog','duracion','finicio','ftermino'],'safe','on'=>self::SCENARIO_REPROGRAMA],
           // [['calificacion'], 'string', 'max' => 1],
            [['talleresdet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleresdet::className(), 'targetAttribute' => ['talleresdet_id' => 'id']],
            [['talleres_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleres::className(), 'targetAttribute' => ['talleres_id' => 'id']],
            [['codtra'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajadores::className(), 'targetAttribute' => ['codtra' => 'codigotra']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'talleresdet_id' => Yii::t('sta.labels', 'Talleresdet ID'),
            'talleres_id' => Yii::t('sta.labels', 'Talleres ID'),
            'fechaprog' => Yii::t('sta.labels', 'F Prog'),
            'codtra' => Yii::t('sta.labels', 'Psicólogo'),
            'finicio' => Yii::t('sta.labels', 'F inic'),
            'ftermino' => Yii::t('sta.labels', 'F term'),
            'fingreso' => Yii::t('sta.labels', 'Fingreso'),
            'detalles' => Yii::t('sta.labels', 'Detalles'),
            'codaula' => Yii::t('sta.labels', 'Codaula'),
            'detalles_indicadores' => Yii::t('sta.labels', 'Indicador trabajado'),
            'detalles_tareas_pend' => Yii::t('sta.labels', 'Pendientes'),
            'detalles_secre' => Yii::t('sta.labels', 'Observaciones'),
            'detalles' => Yii::t('sta.labels', 'Actividades realizadas'),
            //'calificacion' => Yii::t('sta.labels', 'Calificacion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTallerdet()
    {
      /* echo  $this->hasOne(Talleresdet::className(), ['id' => 'talleresdet_id'])->createCommand()
          ->getRawSql();die();*/
        return $this->hasOne(Talleresdet::className(), ['id' => 'talleresdet_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaller()
    {
        return $this->hasOne(Talleres::className(), ['id' => 'talleres_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPsicologo()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExamenes()
    {
        return $this->hasMany(Examenes::className(), ['citas_id' => 'id']);
    }
    
     

    /**
     * {@inheritdoc}
     * @return CitasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \frontend\modules\sta\components\ActiveQueryCitas(get_called_class());
    }
    public static function findFree()
    {
        return new CitasQueryFree(get_called_class());
    }
    
    public function beforeSave($insert) {
       if($insert){            
          $this->resolveDuration();
          if(is_null($this->asistio) or $this->asistio=='0')
           $this->asistio=false;
          $this->activo=true;
         $this->numero=$this->correlativo('numero', 8);
         
       }
           
        //$this->resolveDuration();
        return parent::beforeSave($insert);
       
    } 
   
  
    private function validateFieldTalleres(){
         if(empty($this->talleres_id))
            throw new \yii\base\Exception(Yii::t('base.errors', 'El campo \'talleres_id\' está vacío'));
       
     }
    /*
     * SE ASREGURA DE QUE DURACION SIEMPRE TENGIA UN VALOR RAZOBNABLE Y NO SE A NULO
     */
    private function resolveDuration(){
        if($this->hasBothDates()){
            $this->duracion=$this->toCarbon('ftermino')->
                    diffInMinutes($this->toCarbon('finicio'));
        }else{
            //yii::error('buscanco');
           // $this->validateFieldTalleres();
            $stringHora= $this->tallerProg()->duracioncita;
           //yii::error('stringhora : '.$stringHora);            
            $hora=(integer)substr($stringHora,0,2);
             $minuto=(integer)substr($stringHora,3,2);
             $carbonF=$this->toCarbon('fechaprog')->hour(0)->minute(0);
             $carbonD= $carbonF->copy();
             $carbonD->hour($hora)->minute($minuto);
             //yii::error('El caroon final es : '.$carbonD);
             $this->duracion= $carbonD->diffInMinutes($carbonF);
             $this->finicio=$this->fechaprog;
             $this->ftermino=$this->toCarbon('fechaprog')->addMinutes($this->duracion)->format($this->formatToCarbon(self::_FDATETIME));
        }
    }
    
    /*Funcionque verifica que tiene ambas fechas llenas 
     *  finicio  y ftermino      
     *      */
    
    private function hasBothDates(){
        return (!$this->withoutFinicio() &&  !empty($this->ftermino));
    }
    
    /*ActiveQuery para filtrar 
     * las citas del dia */
    public  function citasActiveQueryForDay(){
       return  $this->find()->andWhere(['>','fechaprog',$this->beginDay()])->
               andWhere(['<=','fechaprog',$this->endDay()]);
    } 
    
    
    /*
     * funcion npar aver si el psicolog esta disponibleo se cruiza*/
    public function isFreeForPsico(){
       //Si no esta dentro de ningun rango del tutor ese dia esta libre 
      return !$this->isRangeInOtherGroupRanges($this->range(), $this->rangesInDayByTutor());
    }
     
    
    
    /*funcion para verificar la siponibilida de una s citas
     * 
     * 1) Verificar que esta dentro del rango de la jornada
     * es decir compara con el range de Talleres   9:00  17::00
     * 
     * 2)Verificar la dsponibilidad del horario con las citas ya establecidas
     * 
     * 
     *  */
    
    public function verifyDispoCita($fecha){  
      if($fecha instanceof RangeDates){
         if($this->isRangeIntoOtherRange($this->range(), $fecha)){
               $this->addError('fechaprog',
                yii::t('La cita no está dentro de las jornada establecida')); 
             return false;
         } 
      }elseIf($fecha instanceof \Carbon\Carbon){
          return false;
      }
      else{
        if(!$this->isInJourney($fecha)) 
         return false;  
      }
      
      
      
     /*
      * Ahora verificamos que el Tutor tiene disponiiblidad ese dia
      */  
      $rangos=$this->rangesInDayByTutor($fecha);       
       $seTraslapa=false;
       foreach($rangos as $rango){
           if($this->isRangeIntoOtherRange($this->range(),$rango)){
                 $this->addError('fechaprog',
          yii::t('El tutor \'{tutor}\' ya tiene asignado una cita en el rango \'{fecha1}\' - \'{fecha2}\' ',[
              'tutor'=>$this->codtra,
              'fecha1'=>$rango->initialDate->format(h::gsetting('timeBD','datetime')),
              'fecha2'=>$rango->finalDate->format(h::gsetting('timeBD','datetime')),
          ])); 
               $seTraslapa=true;
               break;
           }
       }
       if($seTraslapa)return !$seTraslapa;       
    
        /*
      * Ahora verificamos que el Aula tiene disponiiblidad ese dia
      */  
     
      $rangos=$this->rangesInDayByAula($fecha);       
       $seTraslapa=false;
       foreach($rangos as $rango){
           if($this->isRangeIntoOtherRange($this->range(),$rango)){
               $this->addError('fechaprog',
          yii::t('El Aula \'{aula}\' ya tiene asignado una cita en el rango \'{fecha1}\' - \'{fecha2}\' ',[
              'aula'=>$this->codaula,
              'fecha1'=>$rango->initialDate->format(h::gsetting('timeBD','datetime')),
              'fecha2'=>$rango->finalDate->format(h::gsetting('timeBD','datetime')),
          ])); 
               $seTraslapa=true;
               break;
           }
       }
        if($seTraslapa)return !$seTraslapa; 
        
       return true; 
        
    }
    
    /*
     * Verifica que esta dentro del rango de la jornada 
     */
    public function isInJourney(){
         $taller=$this->tallerProg();
         /* yii::error('rangos');
         yii::error($this->range());
           yii::error($taller->range($this->toCarbon('fechaprog')));
         */
         if(!$this->isRangeIntoOtherRange(
               $this->range(),
               $taller->range($this->toCarbon('fechaprog'))
               )){
           $this->addError('fechaprog',
          yii::t('sta.errors','La cita no está dentro del horario predefinido')); 
           return false;
               }
         return true;
    }
    
    /*DEVUELVE el grupo de rangos en ese dia */
    private function rangesInDay($fecha){
         $rowsCitas=$this->citasActiveQueryForDay()->
               andWhere(['codaula'=>$this->codaula])->andWhere(['codtra'=>$this->codtra])->
               all();
       $rangos=[];
       foreach($rowCitas as $row){
           $rangos[]=$row->range();
       }
       return $rangos;
    }
  /*
   * Verifica que el dia de la cita 
   * esta dentro de los dias aprobados en el programa
   * ademas valida si es sferiado feriado 
   */
    public function esFeriado(){
        ///ECHO "AQUI";DIE();
        
        if($this->isHolyDay($this->toCarbon('fechaprog'))){
           // ECHO "Sie s feriado ";DIE();
          $this->addError('fechaprog',yii::t('sta.errors','El día programado es no laborable'));
          return true;
        }else{
         // ECHO "NO es hliday ";DIE(); 
        }
       return false;
        
    }
    
     /*DEVUELVE el grupo de rangos en ese dia coupados por el tutor
      * OJO NOS E FILTRA  talleres_id porque un turor puede participar 
      * en mas de un programa, el filtro es general en toda la universidad 
      *  */
    private function rangesInDayByTutor(){
         $rowsCitas=$this->citasActiveQueryForDay()->                 
              andWhere(['codtra'=>$this->codtra])->
               all();
       $rangos=[];
       foreach($rowsCitas as $row){
           $rangos[]=$row->range();
       }
       return $rangos;
    }
    
    /*DEVUELVE el grupo de rangos en ese dia coupados por el aula
      * Ojo aqui si se filtra por taller porque para cada taller existe 
     * un grupo de aulas unico
      *  */
    private function rangesInDayByAula($fecha){
         $rowsCitas=$this->citasActiveQueryForDay()-> 
              andWhere(['talleres_id'=>$this->talleres_id])-> 
              andWhere(['codaula'=>$this->codaula])->
               all();
       $rangos=[];
       foreach($rowCitas as $row){
           $rangos[]=$row->range();
       }
       return $rangos;
    }
        
        
    
    
    public function tallerProg(){
        if(!$this->isNewRecord){
                 return $this->taller;
            }else{
              return Talleres::findOne($this->talleres_id);  
            }
    }
    
     
    public function createBasic($campos){
        $oldScenario=$this->getScenario();
        $this->setScenario(self::SCE_CREACION_BASICA);
        $this->setAttributes($campos);  
        $this->save();
        $this->setScenario($oldScenario);
        return $this->getErrors($attribute);
    }
    
    /*
     * Genera un evento FullCalendar 
     * com los datos del mismo registro
     */
    public function evento(){
        $tallerdet=$this->tallerdet;
        if(is_object($tallerdet)){
         $title=$tallerdet->codalu;  
    }else{
       $title='------';  
    }
        //echo $this->id;die();
        $formatDB=h::gsetting(self::_FORMATBD, self::_FDATETIME); // = "Y-m-d H:i:s"
        return [
            'id'=>$this->id,
            'title'=>$title,
            'start'=>$this->swichtDate('fechaprog', false),
            'end'=>date($formatDB, strtotime($this->swichtDate('fechaprog', false))+60*$this->duracion),
            'color'=>'#5cb85c',
        ];
    }
    
    
     public function citasPendientes()
    {
        return Citas::find()->andWhere( 
                [ /* 'talleres_id'=>$this->talleres_id,*/
                    'codtra'=>$this->codtra,
                    //'asistio'=> '0',
                    
                    ])->andWhere(['>','fechaprog', $this->CarbonNow()->endOfDay()->subWeek()->subWeek()->format(
               h::gsetting('timeBD','datetime')
               )])->all();
    }
    
    public function eventosPendientes()
    {
        $eventos=[];
      $citas= $this->citasPendientes();
      foreach ($citas as $cita){
          $eventos[]=$cita->evento();
      }
      return $eventos;
    }
   
    public function putColorThisCodalu($events,$color='#ff0000'){
        $codalu=$this->tallerdet->codalu;
       foreach($events as $index=>$event) {
           if(trim(strtoupper($codalu))==trim(strtoupper($event['title'])))
            $events[$index]['color']=$color;
       }
       return $events;
    }
  
    
    /*Ubica la cita inmediatamente superior
     * en tiempo , segun el alumno
     * Return : id de la siguiente cita
     */
    public function nextCitaByStudent(){
       /*echo $this->find()->select('id')->andWhere([
        'talleresdet_id'=>$this->talleresdet_id,        
      ])->andWhere(['>','fechaprog',$this->fechaprog])->
           orderBy('fechaprog ASC')->createCommand()->getRawSql();
       die();*/
   return  $this->find()->select('id')->andWhere([
        'talleresdet_id'=>$this->talleresdet_id,        
      ])->andWhere(['>','fechaprog',$this->swichtDate('fechaprog',false)])->
           orderBy('fechaprog ASC')->limit(1)->scalar();
        
        
    }
    
    public function previousCitaByStudent(){
       /* echo $this->find()->select('id')->where([
        'talleresdet_id'=>$this->talleresdet_id,        
      ])->andWhere(['<','fechaprog',$this->fechaprog])->
           orderBy('fechaprog DESC')->createCommand()->getRawSql();
       die(); */
   return  $this->find()->select('id')->andWhere([
        'talleresdet_id'=>$this->talleresdet_id,        
      ])->andWhere(['<','fechaprog',$this->swichtDate('fechaprog',false)])
           ->orderBy('fechaprog DESC')->limit(1)->
           scalar();
    } 
    
     public function lastCitaByStudent(){
     $maximafecha=  $this->find()->select('max(fechaprog)')->andWhere([
        'talleresdet_id'=>$this->talleresdet_id,        
      ])->scalar();
     if($maximafecha===false)return $maximafecha;
   return  $this->find()->select('id')->andWhere([
        'talleresdet_id'=>$this->talleresdet_id,        
      ])->andWhere(['fechaprog'=>$maximafecha])->scalar();
           
    }
     public function firstCitaByStudent(){
     $minimafecha=  $this->find()->select('min(fechaprog)')->andWhere([
        'talleresdet_id'=>$this->talleresdet_id,        
      ])->scalar();
     if($minimafecha===false)return $minimafecha;
   return  $this->find()->select('id')->andWhere([
        'talleresdet_id'=>$this->talleresdet_id,        
      ])->andWhere(['fechaprog'=>$minimafecha])->scalar();
           
    }
    
    public function breadCrumbsByStudent(){
        return [
            yii::t('sta.labels','Primera cita')=>$this->firstCitaByStudent(),
            yii::t('sta.labels','Cita Previa')=>$this->previousCitaByStudent(),
            yii::t('sta.labels','Siguiente Cita')=>$this->nextCitaByStudent(),
            yii::t('sta.labels','Ultima cita')=>$this->lastCitaByStudent(),
        ];
    }
    
    public function providerByAlumno(){
        
    }
    
    /*
     * Funcion que genera el bando de preguntas 
     * dentro de esta cita 
     * 
     */
    public function generaExamenes(){
        $valor=false;
        foreach($this->examenes as $examen){
           $valor=$examen->creaExamen();
          if($valor==false){
              break;
          }
        }
          return $valor;  
        }
    /*
     * Funcion que devuelve los dataprovidesr de las preguntas 
     * de los examenes
     */
    public function providersExamenes(){
        $proveedores=[];
        //var_dump($this->codExamenes());die();
        foreach($this->codExamenes() as $codexamen){
            $proveedores[$codexamen]= VwStaExamenesSearch::searchByExamenCode($this->id,$codexamen);
        }
        
        return $proveedores;
    }
    
    public function codExamenes(){
       return array_column(Examenes::findFree()->select(['codtest'])
                ->where(['citas_id'=>$this->id])->asArray()->all(),'codtest'); 
    }
    
    public function numeroPreguntas(){
        $ids=(new \yii\db\Query())
    ->select('id')
    ->from('{{%sta_examenes}}')
    ->where(['citas_id'=>$this->id])->column();
      
         return (new \yii\db\Query())
    ->select('count(*)')
    ->from('{{%sta_examenesdet}}')
    ->where(['examenes_id'=>$ids])->scalar();
    }
    
    
    
    public function canInactivate(){
        return (!$this->hasChilds() && !$this->asistio)?true:false;
    }
    
    public function canChangeAsistio(){
        //Debe de estar en el presente o pasado 
         if($this->toCarbon('fechaprog')->greaterThan(self::CarbonNow())){
             $this->addError('asistio',yii::t('sta.errors','La fecha programada está en el futuro'));
              return false; 
             }
       
        return true;    
    }
    public function canRevertAsistencia(){
        //SE PEUDE REVERTIR LA ASISTENCIA
        //Si no se ha enera
    }
    
    /*Si tiene el banoc de preguntyas comleto */
    public function hasCompletePreguntas(){
       $completo=true;
        foreach($this->examenes as $examen){
           if($examen->getExamenesDet()->count()==0){
              $complete=false;break; 
           }
         return $completo;  
        }
       //return $this->isBateriaCompleta();
    }
    
    
    
    
    
    
    
    
    public function withoutFinicio(){
       /* return ($this->finicio== \common\helpers\timeHelper::getDateTimeInitial() or 
             empty($this->finicio))?true:false;*/
    }
     
   
  
  
  public function isInPast(){
     return $this->toCarbon('fechaprog')->lessThanOrEqualTo(self::CarbonNow());
  }
  
  public function isVencida(){
     $horas=h::gsetting('sta', 'nhorasreprogramacion');
     return $this->toCarbon('fechaprog')->lessThanOrEqualTo(self::CarbonNow()->subHours($horas));
  }
  /*
   * Reporgarma la cita 
   * fechatermino: cadena en formato Y-m-d
   * fechainicio : cadena en formato Y-m-d
   */
  public function reprograma($fechaInicio,$fechaTermino=null){
    if(!$this->asistio && !$this->isVencida()){
        $CfechaInicio= \Carbon\Carbon::createFromFormat(\common\helpers\timeHelper::formatMysql(),$fechaInicio);
        if(!is_null($fechaTermino)){
          $CfechaTermino= \Carbon\Carbon::createFromFormat(\common\helpers\timeHelper::formatMysql(),$fechaTermino);        
          $this->duracion=$CfechaTermino->diffInMinutes($CfechaInicio); 
        }
          //var_dump($CfechaInicio->format($this->formatToCarbon(self::_FDATETIME)));die();    
        $this->fechaprog=$CfechaInicio->format($this->formatToCarbon(self::_FDATETIME));
        $this->finicio=$this->fechaprog;
        $this->ftermino=$CfechaInicio->addMinutes($this->duracion)->format($this->formatToCarbon(self::_FDATETIME));
                    $oldScenario=$this->getScenario();
                        $this->setScenario(self::SCENARIO_REPROGRAMA);
                            $grabo=$this->save();
                      if(!$grabo){
                          $this->addError('fechaprog',yii::t('sta.errors',$this->getFirstError()));                          
                          return false;
                      }                       
                            $this->setScenario($oldScenario);
                return $grabo;
    }else{
      if($this->isVencida())
       $this->addError('fechaprog',yii::t('sta.errors','La cita se encuentra en el pasado, es mejor que cree una nueva')); 
     if($this->asistio)
       $this->addError('fechaprog',yii::t('sta.errors','Esta cita ya tiene asistencia')); 
     
      return false;
       
    }
      
  }
  
  
  public function validateDispo($attribute, $params)
    {
       IF($this->esFeriado()){
        $this->addError('fechaprog',yii::t('sta.errors','La fecha se encuentra en un día no laborable'));
          }
       if(!$this->isNewRecord){
           if($this->toCarbon('finicio')->greaterThan($this->toCarbon('ftermino'))){
           $this->addError('finicio',yii::t('sta.errors','La fecha de inicio es mayor que la fecha de termino '));
          
       if($this->isVencida())
       $this->addError('fechaprog',yii::t('sta.errors','La cita se encuentra en el pasado, es mejor que cree una nueva')); 
     if($this->asistio)
       $this->addError('fechaprog',yii::t('sta.errors','Esta cita ya tiene asistencia')); 
     
           
           } 
          
          
       }
      
     
      //$this->isInJourney();
      //if($this->isInPast())
     // $this->addError('fechaprog',yii::t('sta.errors','La fecha de inicio se encuentra en el pasado'));

      
    }
  
    
    public function agregaBateria($codbateria){
       $pruebas= Test::find()->where(['codbateria'=>$codbateria])->orderBy('orden asc')->all();
       foreach($pruebas as $prueba){
           $this->addTest($prueba->codtest);
       }
       $this->generaExamenes();
    }
    
    private function addTest($codtest){
        $attributes=[
            'citas_id'=>$this->id,
            'codtest'=>$codtest,
            'codfac'=>$this->codfac,
            'user_id'=>h::userId(),
            'reporte_id'=> staModule::REPORTE_TEST,
            'virtual'=>'1'
        ];
        $verifyAttributes=[ 'citas_id'=>$this->id,
            'codtest'=>$codtest,];
        Examenes::firstOrCreateStatic($attributes, null, $verifyAttributes);
    }
  
    
    public function examenesId(){        
       return Examenes::find()->select(['id'])
                ->andWhere(['citas_id'=>$this->id])->column(); 
    
    }
    
    
    
    /*
     * Verifiac que todas las preguntas de los 
     * examens ya han sido contestadas
     * YA NO HAY NECEISDAD DE NOTIFICAR
     * por correo */
    
  public function isBateriaCompleta(){
    /*yii::error(StaExamenesdet::find()->andWhere(['valor'=>null])->
      andWhere(['examenes_id'=>$this->examenesId()])->createCommand()->getRawSql());
    */return  !StaExamenesdet::find()->andWhere(['valor'=>null])->
      andWhere(['examenes_id'=>$this->examenesId()])->exists();
  } 
  
  /*
   * Ejecuta los resultados 
   * segun las respuestas
   */
  public function makeResultados(){
      foreach($this->examenes as $examen){
          $examen->makeResultados();
      }
     return true;
  }
  
  
 public function marcadorStatus(){
     if(!$this->isVencida()){ //futuro
          if($this->asistio){
             return ['success'=>Yii::t('sta.labels','EFECTUADA')]; 
         }else{
            return ['warning'=>Yii::t('sta.labels','PROGRAMADA')];  
         }
     }else{ //presenet y pasado
         if($this->asistio){
             return ['success'=>Yii::t('sta.labels','EFECTUADA')]; 
         }else{
            return ['danger'=>Yii::t('sta.labels','VENCIDA')];  
         }
        
     }
 } 
 
 public function eliminaCita(){
     $this->clearErrors();
     $this->setScenario(self::SCENARIO_ACTIVO);
     $this->activo=false;
     if($this->asistio){
          $this->addError ('asistio',yii::t('sta.errors','Esta cita ya tiene asistencia'));
         return $this->getErrors();;
     }
     if($this->isVencida()){
          $this->addError ('fechaprog',yii::t('sta.errors','Esta cita ya está vencida'));
         return $this->getErrors();;
     }
     $this->save();
     return $this->getErrors();
 }
 
 public function notificaCorreoExamen(){
     $mensajes=[];
     $alumno=$this->tallerdet->alumno;
      $token=  \common\components\token\Token::create('citas', 'token_'.$this->id, null, time());       
     $link= Url::to(['/sta/citas/examen-banco','id'=>$this->id,'token'=>$token->token],true);
        $mailer = new \common\components\Mailer();
        $message =new  \yii\swiftmailer\Message();
            $message->setSubject('Notificacion de Examen')
            ->setFrom(['neotegnia@gmail.com'=>'Tutoría UNI'])
            ->setTo($alumno->correo)
            ->SetHtmlBody("Buenas Tardes".  $alumno->fullName()." <br>"
                    . "La presente es para notificarle que tienes "
                    . "una examen  programado. <br> Presiona el siguiente link "
                    . "para acceder a la prueba: <br>"
                    . "    <a  href=\"".$link."\" >Presiona aquí </a>");
           
    try {
        
           $result = $mailer->send($message);
           return true;
          $mensajes['success']='Se envió el correo, invitando al examen, el Alumno tiene que responder ';
    } catch (\Swift_TransportException $Ste) {      
         $mensajes['error']=$Ste->getMessage();
    }
    return $mensajes;
    }
 
 
}
