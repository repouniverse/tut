<?php

namespace frontend\modules\sta\models;
use common\helpers\RangeDates;
use common\models\masters\Trabajadores;
use frontend\modules\sta\models\Talleresdet;
use frontend\modules\sta\models\Citas;
use Yii;
use Carbon\Carbon;
use common\interfaces\rangeInterface;
use common\helpers\timeHelper;
use common\helpers\h;
/**
 * This is the model class for table "{{%sta_tallerpsico}}".
 *
 * @property int $id
 * @property int $talleres_id
 * @property string $codtra
 * @property string $calificacion
 *
 * @property StaTalleres $talleres
 */
class Tallerpsico extends \common\models\base\modelBase 
{
    /**
     * {@inheritdoc}
     */
    const  SCENARIO_CANTIDAD='cantidad';
    const  SCENARIO_STATUS='estado';
    const  SCENARIO_PERSONALIZACION='per';
    const  SCENARIO_CAMBIO='cambio';
    public $booleanFields=['calificacion','programar_libre'];
   // public $codtra2=null; //camo auxiliar
    public $cantidad_transferir=null;
    public static function tableName()
            
    {
        return '{{%sta_tallerpsico}}';
    }

    
   public function extraFields()
    {
        return ['codtra2',];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['talleres_id', 'codtra','nalumnos'], 'required'],
            [['talleres_id','nalumnos'], 'integer'],
            [['codtra'], 'string', 'max' => 6],
             [['codtra'], 'validateCambio','on'=>self::SCENARIO_CAMBIO], //auxiliar 
            [['codtra'], 'validateFacultad'], //auxiliar 
            [['codtra'], 'unique',
                'targetAttribute' => ['codtra', 'talleres_id'],
                'message'=>yii::t('sta.labels','Este tutor ya está registrado'),
                'except'=>self::SCENARIO_CAMBIO
                ],
            
            [['cantidad_transferir','programar_libre'], 'safe'],
             //[['calificacion'], 'string', 'max' => 1],
             [['nalumnos','calificacion'], 'safe'],
            [['nalumnos'], 'validateCantidades','on'=>'default'],
            [['talleres_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleres::className(), 'targetAttribute' => ['talleres_id' => 'id']],
        ];
    }

     public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios[self::SCENARIO_CANTIDAD] = ['nalumnos'];
        $scenarios[self::SCENARIO_STATUS] = ['calificacion','nalumnos'];
         $scenarios[self::SCENARIO_CAMBIO] = ['codtra','cantidad_transferir'];
          $scenarios[self::SCENARIO_PERSONALIZACION] = ['programar_libre'];
       // $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];
        return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'talleres_id' => Yii::t('sta.labels', 'Talleres ID'),
            'codtra' => Yii::t('sta.labels', 'Tutor'),
            'calificacion' => Yii::t('sta.labels', 'Calificacion'),
            'nalumnos' => Yii::t('sta.labels', 'Cant. Alumnos'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaller()
    {
       
        
        return $this->hasOne(Talleres::className(), ['id' => 'talleres_id']);
    }

    
   
    /*public function getCitas()
    {
        return $this->hasMany(Citas::className(), ['talleres_id'=>'id','codtra'=>$this->codtra]);
    }*/
    
     
    
    /*
     * Pendientes solo del futuro
     */
    public function citasPendientesQuery()
    {
         $horas=h::gsetting('sta', 'nhorasreprogramacion');
       $limite=self::CarbonNow()->subHours($horas)->format(timeHelper::formatMysql());
    
       return Citas::find()->
              andWhere(['>=','fechaprog',$limite])->andWhere(['codfac'=>$this->codfac])
              ->andWhere([ 
                  /* 'talleres_id'=>$this->talleres_id,*/
                 // 'codtra'=>$this->codtra,
                  //'masivo'=>'0',
                  'asistio'=> '0',
                  ]);
        /* var_dump(Citas::find()->where( 
                [
                    'codtra'=>$this->codtra,
                    'asistio'=> '0',
                    
                    ])->andWhere([
             'between',
             'fechaprog',
             $this->CarbonNow()->endOfDay()->subWeek()->format(
               h::gsetting('timeBD','datetime')
               ),
             $this->CarbonNow()->addWeek()->format(
               h::gsetting('timeBD','datetime')
               )
                        ])->createCommand()->getRawSql());die();*/
        return Citas::find()->where( 
                [ /* 'talleres_id'=>$this->talleres_id,*/
                    'codtra'=>$this->codtra,
                    'asistio'=> '0',
                    
                    ])->andWhere(['>','fechaprog', $this->CarbonNow()->endOfDay()->subWeek()->subWeek()->format(
               h::gsetting('timeBD','datetime')
               )])
                
                
                /*andWhere([
             'between',
             'fechaprog',
             $this->CarbonNow()->endOfDay()->subWeek()->subWeek()->subWeek()->format(
               h::gsetting('timeBD','datetime')
               ),
             $this->CarbonNow()->addWeek()->addWeek()->addWeek()->format(
               h::gsetting('timeBD','datetime')
               )
                        ])*/;
       
    }
    
    
    public function citasRealizadasQuery()
    {
        return Citas::find()->where( 
                [  'talleres_id'=>'id',
                    'codtra'=>$this->codtra,                    
                    ])->andWhere(['>','finical',timeHelper::getDateTimeInitial()]);
    }
    
    
    public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }
    /**
     * {@inheritdoc}
     * @return TallerpsicoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TallerpsicoQuery(get_called_class());
    }
    
    /*Asigan estudiantes aleatoriamente segun la cantidad de 
     * de los mismos 
     */
    public function assignStudentsByRandom(){
        $cantidad=$this->nalumnos;
        if($cantidad >0 && !empty($cantidad)){
          $studentsFree=$this->taller->freeStudents();
       $i=1;
       foreach($studentsFree as $student){
           if($i <= $cantidad){
               $student->codtra=$this->codtra;           
                $student->save();
                    $i++;
           }else{
              break;
           }
         }//fin del for 
        }
       
       return true;
     }
     
      public function validateCantidades($attribute, $params)
    {
          $talleres=Talleres::findOne($this->talleres_id);
          $disponible=count($talleres->freeStudents());
          unset($talleres);
          
          if($this->nalumnos > $disponible){
              $this->addError('nalumnos',yii::t('sta.errors','Imposible esta cantidad , ya no hay más alumnos. Sólo quedan ({cantidad}) alumnos ' ,['cantidad'=>$disponible]));
          return;
              
          }
      
    }
     /*DESASOCIA LE TUTOR*/
    public function dettachTutor(){
        /*verifica priero si tiene alumnos
         * Si no los tiene se borra nada mas
         * Si los tuviese, se descativa 
         */
        
        $cantidad=$this->detachStudents();//desacoplar estudiantes
        //$this->addMessage(self::MESSAGE_SUCCESS,yii::t('import.messages',' {numero} Alumnos fueron desafiliados con este tutor',['numero'=>$cantidad]));
        
        if($this->hasCitas()){
        //$this->addMessage(self::MESSAGE_WARNING,yii::t('import.messages','Este tutor ya tenía citas programadas o efectuadas, sólo es posible desactivarlo '));
      
         $this->disabled();//desactivarlo
         $this->addMessage(self::MESSAGE_SUCCESS,yii::t('import.messages','Este tutor ya tenía citas, y sólo ha sido desactivado '));
      
      }else{
          $this->delete();
           $this->addMessage(self::MESSAGE_SUCCESS,yii::t('import.messages','El tutor ha sido desactivado '));
                
      }
      $this->taller->sincronizeCant();
    }
    
    
    /*Verifica si el tutor tiene asignado alumnos
     * 
     */
    public function hasStudents(){
      return ($this->taller->countStudentsByTutor($this->codtra)>0)?true:false; 
    }
    
    /*Desactiva o ambia el estado a desactivado*/
    public function disabled(){
        $old=$this->getScenario();
        $this->setScenario(self::SCENARIO_STATUS);
        $this->calificacion=false;
        $f=$this->save();
        $this->setScenario($old);
        yii::error($this->getFirstError(),__METHOD__);
        return $f;
    }
    
    
    /*Active Query para gestionar las citas
     * 
     */
    
    private function AQueryForCitas(){
        return Citas::find()->where(['talleres_id'=>$this->talleres_id,
           'codtra'=>$this->codtra]);
    }
    
    /*Verifica que ha tenido citas */
    
    public function hasCitas(){
       $ncitas=$this->AQueryForCitas()->count();
        return ($ncitas>0)?true:false;
    }
    /*
     * Esta funcion determina la cantidad de citas 
     * totales
     */
     public function nTotalCitas(){
       $ncitas=$this->AQueryForCitas()->count();
    }
    
    /*
     * Esta funcion determina la cantidad de citas 
     * Hechas
     */
     public function nDoneCitas(){
       $ncitas=$this->AQueryForCitas()->count();
    }
    
    /*
     * Desafilia de los alumnos
     * tabla Tallerdet colocar null 
     * en codtra
     */
    public function detachStudents() {
        return Talleresdet::updateAll(['codtra'=>null], ['codtra'=>$this->codtra]);
    }
    
    public function beforeSave($insert) {
      
        if($insert){
            //$this->prefijo=$this->codfac;
           
            $this->calificacion=true;
        }else{
            
            if($this->hasChanged('codtra')){
                $this->transfiereAlus($this->oldAttributes['codtra'],$this->codtra);
                $this->calificacion=true;
               //Tallerpsico::updateAll(['calificacion'=>true], $condition);
            }
        }
        
        return parent::beforeSave($insert);
       
    }
    
    
    /*
     * FUncion que posterga una cita 
     */
    
   public function postergaCita(\Carbon\Carbon $newDate){
       
   }
   
   /*
    * HACE UNA CITA DADO UN ALUMNO
    */
   public function makeCita($codalu,$fecha){
     if(is_string($codalu)){
         $attributes=[
             'talleresdet_id'=>$talleresdet_id,
             'talleresdet_id'=>$talleresdet_id,
             'fechaprog'=>$fecha,
             'codtra'=>$codtra,
             
             ];
        
        
     }
     
     
       
   }
   
  /*UBICA LA PRIMAER AULA LIBRE
     * SI NO LA UBICA RETONA NULL
     */
   public function nextFreeAula($fecha,$duration=null){
     Citas::find()->max('fechaprog')->where();
   } 
   
   
   
   
    public function makeMassiveCitas(){
         
         $busyStudents=$this->taller->busyStudents();
         $fechainicio=$this->taller->finicitas;
         foreach($busyStudents as $student){
             $rangodiario=$this->taller->range($fechainicio);
             $model=New Citas();
                $model->setAttributes([
                    'talleres_id'=>$this->talleres->id,
                    'talleresdet_id'=>$this->id,
                    'fechaprog'=>$rangodiario->initialDate->format(h::gsetting('timeBD','datetime')),
                    'duracion'=>$this->taller->duracioncita,
                    'codtra'=>$this->codtra,
                    'codaula'=>$this->codtra,
                    
                ]);
         }
         
         $rangos=$this->rangesToDates();
         foreach($rangos as $rangodiario){            
             $period = CarbonPeriod::since(
                     $rangodiario->initialDate->format(h::gsetting('timeBD','datetime'))
                     )->minutes($this->duracioncita)->
                     until(
                          $rangodiario->finalDate->format(h::gsetting('timeBD','datetime'))
                      );
          
           foreach($period as $moment){
                $model=New Citas();
                $model->setAttributes([
                    'talleres_id'=>$this->id,
                    
                ]);
               
           }
            
             
         }
     } 
   
     
  /*fUNCION QUE DEVUELVE UN REGISTRO DE TALLERESDET 
   * solo con le id de este modelo y el codigo de una alumno
   * 
   */   
     public  function modelTalleresdet($codalu){
         //yii::error($this->talleres_id);
         //yii::error($codalu);
          return Talleresdet::find()->where([
              'talleres_id' => $this->talleres_id,
              'codalu'=>$codalu,
              ])->one();
                ;
     }
     
     
     /*
    Un array con eventosd pendientes
     * deriva del citasPendientesQuery
     *      */
    public function eventosPendientes(){
        $eventos=[];
        $filas=$this->citasPendientesQuery()->all();
        //var_dump(timeHelper::getDateTimeInitial(),$filas);die();
        foreach($filas as $filaCita){
            $eventos[]=$filaCita->evento();
        }
        return $eventos;
    }
    
     /*
    Un array con eventosd pendientes
     * deriva del citasPendientesQuery
     *      */
    public function alumnosPendientes($nveces=null){
        $items=[];
        $consulta=Talleresdet::except()->select('[[codalu]]')->
        where(['talleres_id'=>$this->talleres_id])->asArray()->all();
        foreach($consulta as $row){
            $items[]=['name'=>$row['codalu'],'color'=>'#234564'];
        }
        
        
       
        
        return $items;
       
         





//print_r(array_flip($consulta,'colorete'));die();
       // echo count($consulta); die();
        
        return array_combine(array_column($consulta,'colorete'),array_column($consulta,'rgb'));
        return array_merge(
        array_combine(array_column($consulta,'colorete'),array_column($consulta,'rgb')),
        array_combine(array_column($consulta,'nombre'),array_column($consulta,'codalu')));
        
       // return $eventos;
    }
    
 public function putColorThisCodalu($events,$codalu,$color="#ff0000"){
       // $codalu=$this->tallerdet->codalu;
    $tutores= array_unique(array_column($events,'codtra'));
   
    $colores=['#31B404','#FFBF00','#AEB404','#848484','#084B8A','#071418'];
    $colores=array_slice($colores,0,count($tutores));
   //yii::error($tutores,__FUNCTION__);
  //yii::error($colores);
    $colores=array_combine($tutores,$colores);
     
      //$codtraaux='';
       foreach($events as $index=>$event) {
           if(trim(strtoupper($codalu))==trim(strtoupper($event['title']))){
             $events[$index]['color']=$color;  
           }else{
              $events[$index]['color']=$colores[$event['codtra']];
           }
       }
       return $events;
    }    
    
    
   public function tallerDet(){
       return  TallerDet::find()->where(
                [
                   // 'codtra'=>$this->codtra,
                    'codtra'=>$this->codtra,
                    'talleres_id'=>$this->talleres_id,
                ]
                )->one();
    } 
    /*
     * Transfiere alumnos a un piscologo y otro 
         Codtra : COdigo del trabajador destino
     *      */
    
   public function transfiereAlus($oldCodtra,$newCodtra,$cantidad=null){
       if($cantidad < $this->nalumnos){
           $alumnos=Talleresdet::find()->where(['talleres_id'=>$this->taller->id])->
            andWhere(['codtra'=>$oldCodtra])->limit($cantidad)->all();
           foreach($alumnos as $alumno){
               $alumno->setScenario($alumno::SCENARIO_PSICO_PSICO);
               $alumno->codtra=$newCodtra;
               $alumno->save();
           }
       }else{
          return Talleresdet::updateAll(['codtra'=>$newCodtra],
               [
                   'talleres_id'=>$this->talleres_id,
                   'codtra'=>$oldCodtra
                   //'codfac'=>$this->codfac,
               ]); 
       }
       
     
   } 
   
    public function validateCambio($attribute, $params)
    {
      if(!$this->hasChanged('codtra'))
        $this->addError('codtra',yii::t('sta.errors','Escoja un nuevo psicólogo'));
      
        if(!($this->cantidad_transferir >0)){
            //var_dump($this->cantidad_transferir); die();
            $this->addError('codtra',yii::t('sta.errors','Cantida debe de ser mayor a cero'));
     
        }else{
           if(($this->cantidad_transferir >$this->nalumnos))
            $this->addError('codtra',yii::t('sta.errors','Cantidad a transferir debe de ser menor o igual a la cantidad original'));
       
        }
            
         
        
    }
   public function validateFacultad($attribute, $params)
    {
       if(!($this->nalumnos > 0)) 
          $this->addError ('codtra',yii::t('sta.errors','cantidad debe ser mayor a cero'));  
          
      if(!($this->talleres_id > 0))
      $this->addError ('codtra',yii::t('sta.errors','Talleres_id es obligatorio'));
    //verficamos que este trabajador tenga bei puesot sus datros de usuario
   // \yiiunit\gii\Profile::UserIdByTrabajador($codtra);
      $profile=Profile::UserIdByTrabajador($this->codtra);
      if(is_null($profile))
      $this->addError ('codtra',yii::t('sta.errors','Este psicólogo no está registrado cion cuenta de usuario, revise el profile'));
           
      
      //$this->codtra 
      
     // var_dump(UserFacultades::filterFacultades($profile->user_id),$this->taller->codfac);die();
      if( !in_array($this->taller->codfac, UserFacultades::filterFacultades($profile->user_id))){
        $this->addError ('codtra',yii::t('sta.errors','Este psicólogo no está registrado en esta facultad, verifique que sus cuenta de usuario tenga afiliada la facultad'));   
       }
        
    }
    
    public function rangeByDay(Carbon $fecha){
     $model=Rangos::findOne([
           'talleres_id'=>$this->talleres_id,
           'codtra'=>$this->codtra,
           'dia'=>$fecha->dayOfWeek,          
           ]); 
     
     if(!is_null($model))
      return $model->Range($fecha); 
     return null;      
    }
    
    /*
     * Devuelve un array de model de 
     * todas las citas dentoe de un rango determinado
     */
   public function citasByRange(RangeDates $range){
       $citas=Citas::find()->andWhere([
             'between',
             'fechaprog',             
             $range->initialDate->format(timeHelper::formatMysqlDateTime()),
             $range->finalDate->format(timeHelper::formatMysqlDateTime())
                        ])->andWhere(['codtra'=>$this->codtra])->orderBy(['fechaprog'=>SORT_ASC])->all();
       
      return $citas;
   }
   
   /*
    * Devuelvce unnrango de una fecha espcifica 
    * relleno de subrangos en ese dia
    * si no encuetra atenciones del psicolog ese dia devuleve null
    */
   
   public function rangesByDay(Carbon $fecha){
       $rango=$this->rangeByDay($fecha);
       
       if(is_null($rango))
        return null;
       $citas=$this->citasByRange($rango);
       //var_dump(count($citas));die();
       foreach($citas as $cita){
           yii::error('intentando cita '.$cita->fechaprog);
           $rango->pushRange($cita->range());
       }
      return $rango;
   }
   
   
   /*
    * Esta funcion devuelve  un rango 
    * 
    */
   public function nextHorarioLibre($since=null){
       if(is_null($since) or $since->lt(self::CarbonNow()->endOfDay())){
           $carbon=self::CarbonNow()->endOfDay();
       } else{
           $carbon=$since->endOfDay();
       } 
       $ranguitoLibre=null;
       $rangosDia=$this->rangesByDay($carbon);
          if(IS_NULL($rangosDia)){ 
              yii::error('Fue nulo rangos dia en  '.$carbon->format('Y-m-d'));
              yii::error('Ahora probando recursivamente con '.$carbon->addDay(1)->format('Y-m-d'));
               return $this->nextHorarioLibre($carbon->addDay(1));
          }else{
               yii::error('Se encontro rangosdia en  '.$carbon->format('Y-m-d'));
              
              $ranguitoLibre=$rangosDia->findFirstFreePlace(30);
              yii::error('Hallanod ranguitoLibre en rangosdia  '.$carbon->format('Y-m-d'));
             
             if(IS_NULL($ranguitoLibre)){
                 yii::error('NO se hallo ranguitoLibre en rangosdia, probando recursovamente   '.$carbon->addDay(1)->format('Y-m-d'));
             
                return $this->nextHorarioLibre($carbon->addDay(1));
             }else{
                  yii::error('Chevere se encontr ranguito libre  y ahi te lo devuelvo '.$carbon->format('Y-m-d'));
                yii::error($ranguitoLibre);
                yii::error('rere');
             
                return $ranguitoLibre;
             }
              
          }
          yii::error('llegando alfinal '.$carbon->format('Y-m-d'));
           yii::error($ranguitoLibre);
       return $ranguitoLibre;
   }
   
   
   
    
}
