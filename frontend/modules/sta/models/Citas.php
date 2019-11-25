<?php

namespace frontend\modules\sta\models;
use common\traits\timeTrait;
use Yii;
use common\interfaces\rangeInterface;
use common\helpers\RangeDates;
use common\helpers\h;
use common\models\masters\Trabajadores;
use frontend\modules\sta\staModule;
/**
 * This is the model class for table "{{%sta_citas}}".
 *
 * @property int $id
 * @property int $talleresdet_id
 * @property int $talleres_id
 * @property string $fechaprog
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
    use timeTrait;
    public $dateorTimeFields=[
        'fechaprog'=>self::_FDATETIME,
         'finicio'=>self::_FDATETIME,
        'ftermino'=>self::_FDATETIME
    ];
   public $booleanFields=['asistio'];
    public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios[self::SCE_CREACION_BASICA] = ['talleres_id','talleresdet_id','duracion','fechaprog','codtra'];
        $scenarios[self::SCENARIO_ASISTIO] = ['asistio'];
        return $scenarios;
    }
    
    
    
    public function range($fecha){
        $this->resolveDuration();
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
            [['talleresdet_id', 'talleres_id', 'codtra'], 'required'],
            [['talleresdet_id', 'talleres_id', 'duracion'], 'integer'],
            [['detalles'], 'string'],
             [['duracion'], 'safe'],
            [['fechaprog', 'finicio', 'ftermino'], 'string', 'max' => 19],
            [['codtra'], 'string', 'max' => 6],
            [['fingreso', 'codaula'], 'string', 'max' => 10],
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
            'fechaprog' => Yii::t('sta.labels', 'Fechaprog'),
            'codtra' => Yii::t('sta.labels', 'Codtra'),
            'finicio' => Yii::t('sta.labels', 'Finicio'),
            'ftermino' => Yii::t('sta.labels', 'Ftermino'),
            'fingreso' => Yii::t('sta.labels', 'Fingreso'),
            'detalles' => Yii::t('sta.labels', 'Detalles'),
            'codaula' => Yii::t('sta.labels', 'Codaula'),
            //'nalumnos' => Yii::t('sta.labels', 'Nalumnos'),
            //'fregistro' => Yii::t('sta.labels', 'Fregistro'),
            //'calificacion' => Yii::t('sta.labels', 'Calificacion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTallerdet()
    {
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
        return new CitasQuery(get_called_class());
    }
    public function beforeSave($insert) {
       if($insert){
          $this->duracion=0;
          $this->asistio=false;
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
            $this->validateFieldTalleres();
            $stringHora= $this->tallerProg()->duracioncita;
           //yii::error('stringhora : '.$stringHora);            
            $hora=(integer)substr($stringHora,0,2);
             $minuto=(integer)substr($stringHora,3,2);
             $carbonF=$this->toCarbon('fechaprog')->hour(0)->minute(0);
             $carbonD= $carbonF->copy();
             $carbonD->hour($hora)->minute($minuto);
            // yii::error('LÑA duracion es : '.$carbonD->diffInMinutes($carbonF));
             $this->duracion= $carbonD->diffInMinutes($carbonF);
        }
    }
    
    /*Funcionque verifica que tiene ambas fechas llenas 
     *  finicio  y ftermino      
     *      */
    
    private function hasBothDates(){
        return (!empty($this->finicio) &&  !empty($this->ftermino));
    }
    
    /*ActiveQuery para filtrar 
     * las citas del dia */
    public static function citasActiveQueryForDay(){
       return  static::find()->where(['>','fechaprog',$this->beginDay()])->
               andWhere(['<=','fechaprog',$this->endDay()]);
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
         if($this->isRangeIntoOtherRange($this->range(null), $fecha)){
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
           if($this->isRangeIntoOtherRange($this->range($fecha),$rango)){
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
           if($this->isRangeIntoOtherRange($this->range($fecha),$rango)){
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
    private function isInJourney($fecha){
         if(!$this->isRangeIntoOtherRange(
               $this->range($fecha),
               $this->tallerProg()->range($fecha)
               )){
           $this->addError('fechaprog',
          yii::t('La cita no está dentro de las jornada establecida')); 
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
           $rangos[]=$row->range($fecha);
       }
       return $rangos;
    }
    
     /*DEVUELVE el grupo de rangos en ese dia coupados por el tutor
      * OJO NOS E FILTRA  talleres_id porque un turor puede participar 
      * en mas de un programa, el filtro es general en toda la universidad 
      *  */
    private function rangesInDayByTutor($fecha){
         $rowsCitas=$this->citasActiveQueryForDay()->                 
              andWhere(['codtra'=>$this->codtra])->
               all();
       $rangos=[];
       foreach($rowCitas as $row){
           $rangos[]=$row->range($fecha);
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
           $rangos[]=$row->range($fecha);
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
        $formatDB=h::gsetting(self::_FORMATBD, self::_FDATETIME); // = "Y-m-d H:i:s"
        return [
            'title'=>$this->tallerdet->codalu,
            'start'=>$this->swichtDate('fechaprog', false),
            'end'=>date($formatDB, strtotime($this->swichtDate('fechaprog', false))+60*$this->duracion),
            'color'=>'#5cb85c',
        ];
    }
    
    
     public function citasPendientes()
    {
        return Citas::find()->where(
                [ 'talleres_id'=>$this->talleres_id,
                    'codtra'=>$this->codtra,
                    'asistio'=>'0',
                   // 'finicio'=> timeHelper::getDateTimeInitial(),
                    
                    ])->all(); 
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
    $this->find()->min()->where([
        
      ]);
        
        
    }
}
