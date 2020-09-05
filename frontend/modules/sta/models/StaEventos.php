<?php

namespace frontend\modules\sta\models;
use common\models\masters\Trabajadores;
use frontend\modules\import\models\ImportCargamasiva;
use frontend\modules\sta\models\Talleres;
use frontend\modules\sta\models\Citas;
use frontend\modules\sta\models\Talleresdet;
use common\helpers\h;
use yii\validators\EmailValidator;
use frontend\modules\import\components\CSVReader as MyCSVReader;
use Yii;
use common\traits\timeTrait;
use common\behaviors\FileBehavior;
/**
 * This is the model class for table "{{%sta_eventos}}".
 *
 * @property int $id
 * @property int $talleres_id
 * @property string $descripcion
 * @property string $numero
 * @property string $fechaprog
 * @property string $tipo
 * @property string $codtra
 *
 * @property Trabajadores $codtra0
 * @property StaTalleres $talleres
 */
class StaEventos extends \common\models\base\modelBase
{
   use timeTrait;
    public $prefijo='97';
    private $_codes=[];
    public $dateorTimeFields=['fechaprog'=>self::_FDATETIME];
    public $hardFields=['tipo','fechaprog'];
    private $_csv=null;
    
     
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_eventos}}';
    }
public function behaviors()
         {
                return [
		'fileBehavior' => [
			'class' => FileBehavior::className()
		],
		/*'fileBehavior' => [
			'class' => '\frontend\modules\attachments\behaviors\FileBehaviorAdvanced' 
                               ],*/
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
            [['talleres_id', 'descripcion', 'fechaprog', 'tipo', 'codtra'], 'required'],
            [['talleres_id','semana'], 'integer'],
            [['descripcion'], 'string', 'max' => 40],
            [['codfac','semana','detalle','objetivo','clase','grupo'], 'safe'],
            
             [['fechaprog'], 'validateFecha'],
            [['fechaprog'], 'string', 'max' => 19],
            [['tipo'], 'integer'],
            [['codtra'], 'string', 'max' => 6],
            [['codtra'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajadores::className(), 'targetAttribute' => ['codtra' => 'codigotra']],
            [['talleres_id'], 'exist', 'skipOnError' => true, 'targetClass' =>Talleres::className(), 'targetAttribute' => ['talleres_id' => 'id']],
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
            'descripcion' => Yii::t('sta.labels', 'Descripcion'),
            'numero' => Yii::t('sta.labels', 'Número'),
            'fechaprog' => Yii::t('sta.labels', 'F prog.'),
            'tipo' => Yii::t('sta.labels', 'Taller o etapa'),
            'codtra' => Yii::t('sta.labels', 'Responsable'),
             'objetivo' => Yii::t('sta.labels', 'Objetivo del Taller'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTalleres()
    {
        return $this->hasOne(Talleres::className(), ['id' => 'talleres_id']);
    }
    
    public function getFlujo()
    {
        return $this->hasOne(StaFlujo::className(), ['id' => 'tipo']);
    }
    
     public function getDetalles()
    {
        return $this->hasMany(StaEventosdet::className(), ['eventos_id'=>'id']);
        //return $this->hasMany(Examenes::className(), ['citas_id' => 'id']);
    }
    
    public function getSesiones()
    {
        return $this->hasMany(StaEventosSesiones::className(), ['eventos_id'=>'id']);
        //return $this->hasMany(Examenes::className(), ['citas_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return StaEventosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaEventosQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        if($insert){
             $this->clase= \frontend\modules\sta\staModule::CLASE_RIESGO;
            $this->numero=$this->correlativo('numero');
        }
        return true ;
    }
    
    public function afterSave($insert, $changedAttributes) {
        if($insert){           
         // $this->addAlumnos();  
           if(!$this->isTallerEvaluacion()){
            $this->refresh();              
              $this->createSesion();   
           }  
        }
       return parent::afterSave($insert, $changedAttributes);
    }
    
    
    private function freshCodes(){
        //Obteniendo los codigos totales del rporgegna
      $codes=$this->talleres->codeStudents();
     $codesEventos= StaEventosdet::find()->select(['codalu'])->
              andWhere(['talleres_id'=>$this->talleres_id/*,'asistio'=>'0'*/])->column();
    $cantidad= h::gsetting('sta','NumeroAlumnosPorGrupo');
    $codesListos=array_diff($codes,$codesEventos);
    RETURN array_slice($codesListos,0,$cantidad);
    }
    
    
    
    public function addAlumnos(){
       // $contador=0;
        $info=[];
        foreach ($this->freshCodes() as $key=>$code){
          $info[]=$this->creaDetalle($code);  
          //$contador++;
        }
       return $info;
    }
    
    
    pUBLIC function creaDetalle($code){
        /*
         * Debemos asegurarnos que este alumno no 
         * este registrado en otros eventos de la misma 
         * "semana" al decir semana no quiere decir semana cronologica,
         * quiere decir numero de semana referencial para agrupar 
         * todos los eventos en un mismo grupo 
         */
        $errores=[];
        if(!$this->codeInPrograma($code)){
            return ['error'=>yii::t('sta.labels','El alumno "{codigo}" no está dentro del programa',['codigo'=>$code])];
        }
                
        if(!$this->codeIsFree($code)){
           return ['error'=>yii::t('sta.labels','El alumno "{codigo}" ya está dentro de otro evento {evento}',['codigo'=>$code,'evento'=>$this->getFirstError()])];
         }
        
         
         // var_dump($this->isTallerEvaluacion(),$this->hasCodeExamen($code));die();
         /*
          * Si es un taller  y no ha pasado evaluacion
          */
       /* if(!$this->isTallerEvaluacion() && !$this->hasCodeExamen($code)){
          return ['error'=>yii::t('sta.labels','El alumno "{codigo}" no ha pasado evaluación',['codigo'=>$code])];
           
        }*/
         
        if($this->isTallerEvaluacion()){
          $currentSesion= StaEventosdet::SESION_INICIO_LIBRE;  
        }ELSE{
           $currentSesion= $this->activeSesion()-1;   //UBICA LA SESION ACTUAL pero le resta unoo para que ssea potencialmente activable  
        }
        //var_dump($this->id);die();
       $tallerdet= Talleresdet::find()->andWhere([ 
           'codalu'=>$code,
           'talleres_id'=>$this->talleres_id,
       ])->One(); 
       $alumno=$tallerdet->alumno;
       $nombres=substr($alumno->fullName(false),0,60);
       $attributes=[
           'eventos_id'=>$this->id,
           'talleresdet_id'=>$tallerdet->id,
           'talleres_id'=>$tallerdet->talleres_id,
           'codalu'=>$code,
           'nombres'=>$nombres,
            'celulares'=>$alumno->celulares,
           'asistio'=>'0',
           'libre'=>'0',
           'current_sesion'=>$currentSesion,
           'detalle'=>'Convocatoria masiva',
            'codfac'=>$tallerdet->codfac,
           'codcar'=>$alumno->codcar,
           'correo'=>$alumno->correo,
       ];
       unset($alumno);unset($tallerdet);
       $verifyAttributes=[
           'eventos_id'=>$this->id,
           'codalu'=>$code,
       ];
    if(StaEventosdet::firstOrCreateStatic($attributes, null, $verifyAttributes)){
        return ['success'=>yii::t('sta.labels','El alumno "{codigo}" Se agregó al evento',['codigo'=>$code])];
    }else{
        return ['error '=>yii::t('sta.labels','El alumno "{codigo}" Ya estaba en el  evento',['codigo'=>$code])];
    }
       
       
    }
    
   /*
    * RECOPILA LAS DIRECCIONES DE LOS CORREOS 
    * DE LOS MUCHAHOS DENTRO DEL EVENTO
    */
    public function correos(){
      $correos= $this->getDetalles()->select(['correo'])->andWhere(['not',['correo'=>null]])->column();
      $correosValidos=[];
      $validador=New EmailValidator();
      foreach($correos as $key=>$correo){
          if($validador->validate($correo))
          $correosValidos[]=$correo;
      }
      
      return $correosValidos;
   } 
   
   /*notifica citas */
   public function notificaCitas(){
       $mensajes=[];
      if($this->isTallerEvaluacion()){ 
      if(!$this->isDateConfirmed()){
         $mailer = new \common\components\Mailer();
        $message =new  \yii\swiftmailer\Message();
            $message->setSubject('Tienes una cita programada')
            ->setFrom([\common\helpers\h::gsetting('mail', 'userservermail')=>'Oficina Tutoría Psicológica UNI'])
            ->setTo($this->correos())
           ->setCc($this->talleres->listMailsFromTutores())
            //->setTo('hipogea@hotmail.com')
           /*
            * Borrar esta linea si hay algun error
            */
             ->setReplyTo($this->talleres->listMailsFromTutores())      
            /*
             * Din de la iena a borar
             */
            ->SetHtmlBody("Buenas Tardes  <br>"
                    . "La presente es para notificarle que tiene "
                    . "una cita  programada VIRTUAL . <br> para el día ".$this->fechaprog."<br>"
                    . "  ");
                return $mailer->sendSafe($message); 
                }else{
                return ['error'=>yii::t('sta.errors','Ya no puede notificar, está próximo a cumplirse el evento')];
       
              }        
       
      } else{//Si es un taller coge los emnsajes de las sesiones
         /* $mensaje=[];
          FOREACH($this->sesiones as $sesion){              
             // $mensaje=$sesion->notificaCitas(); 
              if(array_key_exists('error', $mensaje)){
                  return ['error'=>$mensaje['error']];
              }
          }
         return ['success'=>$mensaje['success']];*/
      }
       
      
    }

   
public function validateFecha($attribute, $params)
    {
      /* if($this->isHolyDay($this->toCarbon('fechaprog'))){
        $this->addError('fechaprog',yii::t('sta.errors','La fecha se encuentra en un día no laborable'));
          }*/
       if(!$this->isNewRecord){
          if($this->hasChanged('fechaprog')){
             if($this->isDateConfirmed())
              $this->addError('fechaprog',yii::t('sta.errors','No puede modificar la fecha, sólo puede hacerlo con  {horas} horas de anticipación',['horas'=>h::gsetting('sta','nhorasantesevento')]));
              
            //no puede cambiar fecha si ya tiene  detalles con aistencia
           /* if($this->isDateConfirmed()){
                //return ['error'=>yii::t('sta.errors','Ya no puede agregar grupos de alumnos, sólo puede hacerlo con  {horas} horas de anticipación',['horas'=>h::gsetting('sta','nhorasantesevento')])]; 
      
               $this->addError('fechaprog',yii::t('sta.errors','No puede modificar la fecha, sólo puede hacerlo con  {horas} horas de anticipación',['horas'=>h::gsetting('sta','nhorasantesevento')]));
              
            }*/
            if($this->hasAsistencias()){
              $this->addError('fechaprog',yii::t('sta.errors','No puede modificar la fecha, ya hay asistentes'));
             } 
            
            if(!$this->isOkFechasFromSesiones()){
               $this->addError('fechaprog',yii::t('sta.errors','Revise las fechas de sus sesiones, alguna de ellas quedaron fuera del rango de este evento'));
              
            }
             
       
                        }  
          } 
      if($this->isNewRecord) {
         if($this->toCarbon('fechaprog')->lessThan(self::CarbonNow())) {
           $this->addError('fechaprog',yii::t('sta.errors','La fecha se encuentra en el pasado '));
                  } 
                  
          /*
         $cita=New Citas();
         $cita->talleres_id=$this->talleres_id;
          $cita->fechaprog=$this->fechaprog;
          $cita->codtra=$this->codtra;
          
          if(!$cita->isInJourney()){
               $this->addError('fechaprog',yii::t('sta.errors','La fecha está fuera del horario de trabajo, verifique los horarios del programa'));
            
          }*/
           
      }   
       
    }    
  
    
public function hasAsistencias(){
   return $this->getDetalles()->andWhere(['asistio'=>'1'])->exists();
    
}    

/*
 * Retorna codigos de alumnos que no aistieron en citas aneriores
 * Pero estos codigos solo de eventos anteriores a este evento
 * que no han sido marcados como asistencia
 */
private function freshCodeRezagados(){
   $eventosId=StaEventos::find()->select(['id'])->where([
        'talleres_id'=>$this->talleres_id/*,'asistio'=>'0'*/,
       '<','fechaprog',$this->swichtDate('fechaprog',false)
       ])->column();
  $codesRezagados= StaEventosdet::find()->select(['codalu'])->
              andWhere([
                  'talleres_id'=>$this->talleres_id/*,'asistio'=>'0'*/,
                  'asistio'=>'0',
                  'eventos_id'=>$eventosId,
                  ]                    
                      )->column();
 $codesInThis=$this->codesInThis();
 return array_diff($codesRezagados,$codesInThis);
}

public function codesInThis(){
    return $this->getDetalles()->select(['codalu'])->column();
}

/*
 * Retorna inserta los alumnos que no asisitieron en citas anteriores
 */
public function addAlumnosRezagados(){
       $info=[];
        foreach ($this->freshCodeRezagados() as $key=>$code){
          $info[]=$this->creaDetalle($code);  
        }
       return $info;
    }
   /*
    * Determina sie le vento ya esta cofirmado  y ya no puede mover fechas
    * ni agregar alum,nos en masa
    * se califica automaticamente 24 horas antes de la fecha progarmada 
    * configruacion en settings
    */     
   public function isDateConfirmed(){
       //return false;
       
       return self::CarbonNow()->greaterThan( $this->toCarbon('fechaprog')->subHours(h::gsetting('sta','nhorasantesevento')));
   } 
   
   /*
    * califica cuando llega la fecha del evento en adelante
    * 
    * se califica autoamticmente con una hora de anticipacion y pude hacer lo hasta 24 horas despues
    */
   public function isDateToWork(){
    // return true;
    if($this->isTallerEvaluacion()){
       return  (self::CarbonNow()->greaterThan( $this->toCarbon('fechaprog')->subHours(1)) && 
             self::CarbonNow()->lessThan($this->toCarbon('fechaprog')->addHours(1650))); 
    }else{
        $horas=h::gsetting('sta', 'nhorasreprogramacion');
        //var_dump($this->toCarbon('fechaprog')->format('Y-m-d H:i:s'),self::CarbonNow()->subHours(1)->format('Y-m-d H:i:s'),$this->toCarbon('fechaprog')->addHours($horas)->format('Y-m-d H:i:s'),$horas);die();
      return  self::CarbonNow()->between($this->toCarbon('fechaprog'),
         $this->toCarbon('fechaprog')->addHours($horas*17)); 
    }
     
   }
   
   
   public function closeEvento(){
       $detalles=$this->getDetalles()->andWhere(['asistio'=>'0'])->all();
       foreach($detalles as $detalle){
           $detalle-> updateLibre(); 
         if($this->isTallerEvaluacion()){
              
         }else{/*Si es un taller tenosq ue cerrar las citas de las sesiones con inasistencias*/
             
         }
        
         
         //yii::error('recorriendo el for',__FUNCTION__);
          //$cita=$detalle->createCita($this->codtra,$this->fechaprog,$this->tipo,false); 
        /* if(!is_null($cita)){
             yii::error('Cita creada',__FUNCTION__);
            $numeroCita=$cita->numero;
            $detalle-> updateNumeroCita($numeroCita); 
             $detalle-> updateLibre($numeroCita); 
          
         }else{
            yii::error('NO se ha creado, mire lose rrores arriba',__FUNCTION__); 
         }
        */
       }
   }
  
     public function getCsv(){
     //var_dump($this->firstLineTobegin());die();
        //yii::error('primera linea para importar:  '.$this->firstLineTobegin(),__METHOD__);
      $path=$this->pathFileCsv();
      //var_dump($path);die();
         if(is_null($this->_csv) && !is_null($path)){
        // var_dump($this->pathFileCsv());die();
          $this->_csv= New MyCSVReader( [
                 'filename' => $path,
              'startFromLine' =>1,//$this->firstLineTobegin(),
                 'fgetcsvOptions' => [ 
                                     'delimiter' => h::gsetting('import', 'delimiterCsv'),
                                       ] 
                                ]);
          return $this->_csv;
      }else{
       return $this->_csv;   
      }
    } 
    public function pathFileCsv(){
    $registros=$this->getFilesByExtension(ImportCargamasiva::EXTENSION_CSV);
    if(count($registros)>0){
        return $registros[0]->getPath();
    }else{
        return null;
        //$this->addError('numero',yii::t('import.errors','No hay ningún archivo adjunto para efectuar la importación'));
    } 
       
   }
   
   /*
     * Obtiene el array de datos a cargar, lee 
     * el archivo csv de disco 
     * USa la libreria MyCSVrEADER , que no es nada del otro mundo
     * solo para ahora trabajo de leer un formato csv 
     */
    public function dataToImport(){
      //yii::error('comenzando a leer el csv',__METHOD__);
      if($this->hasFileCsv()){
         $datos= $this->csv->readFile();  
      }else{
        $datos=[];   
      }
    /* if(h::userId()==7){
         var_dump($datos);die();
     }*/
     
      //$this->total_linea=count($datos);
      return $datos;
  }  
  
   public function hasFileCsv(){
    $registros=$this->getFilesByExtension(ImportCargamasiva::EXTENSION_CSV);
      $tiene= (count($registros)>0)?true:false; 
       if(!$tiene){
           $this->addError('numero',yii::t('import.errors','Este registro no tiene adjuntado ningun archivo '.ImportCargamasiva::EXTENSION_CSV));
           return false;   
       }
       return true;
   }  
   
  public function addCodesFromCsv(){
      $info=[];
     foreach($this->dataToImport() as $filaDato){
          $code=trim($filaDato[0]);
          $info[]=$this->creaDetalle($code);
      }
      return $info;
  }
  
 public function codes(){
     if(count($this->_codes)==0){
         return $this->talleres->codeStudents();
     }else{
         return $this->_codes;
     }
 } 
  
 public function codeInPrograma($code){ 
     $code=trim($code);
     $codigos=array_map('trim',$this->codes());
     
  /*  asort($codigos);
     var_dump($code,$codigos,in_array(trim($code),$codigos));die();
    yii::error($code);
     yii::error($codigos);
    
      yii::error(in_array($code,$codigos));*/
   return  in_array(trim($code),$codigos);
 } 
 
public function codeIsFree($code){
    /*
     * Si es un taller grupal de fernete es verdadero
     * el alumno puede repetir 
     */
    
    if(!$this->isTallerEvaluacion())
     return true;
    
    
    $idsEventos=self::find()->select(['id'])->
    andWhere(['tipo'=>$this->tipo])->column();
    
    /*Si esta convocado, quiere decir que esta registrado en algun 
     * evento de este tipo
     * cualquiera sea su situacion  */
    $convocado= StaEventosdet::find()->select(['id'])->andWhere([
         'eventos_id'=>$idsEventos,
         'codalu'=>$code,
        // 'asistio'=>'1'
     ])->exists();
    
    /*
     * Si asistio a un evento del tipo en cuestion 
     */
    if($asistio=StaEventosdet::find()->select(['id'])->andWhere([
         'eventos_id'=>$idsEventos,
         'codalu'=>$code,
         'asistio'=>'1'          
     ])->exists()){
    $NumeroEventoAsistio=StaEventosdet::find()->andWhere([
         'eventos_id'=>$idsEventos,
         'codalu'=>$code,
         'asistio'=>'1'
     ])->one()->evento->numero; 
    }
  
    /*
     * Si esta comprometido con otro evento 
     * es decir no ha asistido pero tampoco se ha liberado
     */
    if($esclavizado=StaEventosdet::find()->select(['id'])->andWhere([
         'eventos_id'=>$idsEventos,
         'codalu'=>$code,
         'libre'=>'0'
     ])->exists()){
      $NumeroEventoEsclavizado=StaEventosdet::find()->andWhere([
         'eventos_id'=>$idsEventos,
         'codalu'=>$code,
         'libre'=>'0'
     ])->one()->evento->numero; 
    }
    
     
    
    
    
    if(!$convocado){
        return true;
    }else{
        if($asistio){
           $this->addError('id',yii::t('sta.errors','El alumno ya se proceso en el evento '.$NumeroEventoAsistio));
            return false;
        }else{
          // if($esclavizado){
               //$this->addError('id',yii::t('sta.errors','El alumno ya está en el evento '.$NumeroEventoEsclavizado));
           
              // return false;
           //}else{
               //return true;
           //}
            return true;
        }
    }
   
 }
 
 /*El evento esta cerrado siempre y cuando porlo 
  * menos haya un registro detalle con el flag libre 
  * esto quiere decir qeu ya se proceso masivamente
  */
 public function isClosed(){
     if(!$this->isNewRecord){
        $existe=$this->getDetalles()->select(['id'])->andWhere(['libre'=>'1'])->exists();
     $cienporcien=($this->nAsistencias()==$this->getDetalles()->count());
    // $queryDetalles=$this->getDetalles();
     //$cuantos=$queryDetalles->count();
    // $asistieron=$queryDetalles->select(['id'])->andWhere(['asistio'=>'1'])->count();
     if($this->isTallerEvaluacion()) {
       return (($this->toCarbon('fechaprog')->lessThan(self::CarbonNow()->subHours(450))) /*OR( /*($existe*/ /*or $cienporcien*//*) and $this->nAlumnos() >0)*/);  
     }else{
       return (
               ($this->toCarbon('fechaprog')->
               lessThan(self::CarbonNow()->
                       subHours(h::gsetting('sta', 'nhorasreprogramacion')*17))) 
               OR(($existe /*or $cienporcien*/) and $this->nAlumnos() >0));    
     }
   }else{
         return false;
   }
     }
 
 public function nAsistencias(){
    if($this->isTallerEvaluacion()){
        return $this->getDetalles()->where(['asistio'=>'1'])->count();
    }else{
        $IdsSesiones=$this->getSesiones()->select(['id'])->column();
        return Citas::find()->andWhere(['codaula'=>$IdsSesiones,'asistio'=>'1'])->count();
    }
     
 }
 public function nAlumnos(){
    return $this->getDetalles()->count(); 
 }
 
 public function hasIncompleteExamen(){
     $valor=false;
     foreach($this->detalles as $detalle){
         $cita=$detalle->cita();
         if(!is_null($cita)){
             //Si hay una cita con bolita roja//
             if(!($cita->hasPerformedTest() && !$cita->isTokenActive())){
                 $valor=true; //EECTIVAMENTE HAY UNA EXAMNE INCOMPLETO
                 break;
             }
         }
     }
     return $valor;
 }
 
 /*
  * CERA UNA SESION PARA EL EVENTO
  */
 public function createSesion(){
     $model=New StaEventosSesiones();
     $this->refresh();
     //var_dump($this->id);die();
     $attributes=[
         'eventos_id'=>$this->id,
         'fecha'=>$this->fechaprog,
         //'tipo'=>
         'tema'=>'Tema a trabajar en esta sesión',  
          //'secuencia'=>'Tema a trabajar en esta sesión',  
     ];
     $model->setAttributes($attributes);
     //var_dump($this->id,$attributes);
    if(!$model->save()){
        print_r($model->getErrors());die();
        
    }
 }
 
 public function firstIdSesion(){
    $idSesiones= StaEventosSesiones::find()->select(['id'])->
     where(['eventos_id'=>$this->id])->orderBy('id asc')->column();
    IF(count($idSesiones)>0)
    return $idSesiones[0];
    return null;
 }
 public function lastIdSesion(){
    $idSesiones= StaEventosSesiones::find()->select(['id'])->
     where(['eventos_id'=>$this->id])->orderBy('id desc')->column();
    IF(count($idSesiones)>0)
    return $idSesiones[0];
    return null;
 }
 
 
 /*
  * aGREGA CODIFOS DESDE UNA SESION DE PHP */
  
 public function addCodesFromSesion(){
      $info=[];
      $sesion=h::session();
      if($sesion->has(h::SESION_MALETIN)){
          foreach($sesion[h::SESION_MALETIN] as $code){
                    $code=trim($code);
                     $info[]=$this->creaDetalle($code);
               }
           $sesion[h::SESION_MALETIN]=[];
          return $info;
      }else{
       return [['error'=>yii::t('sta.errors','No hay datos en el maletín')]];   
      }
     
  }
  
  
  
  /*
   * SE FIJA SI EL TALLER ES UNA EVALUACION 
   * COMPARA SI EL  TIPO == flujo con masivo=1 y examen =1 
   */
 public function isTallerEvaluacion(){
     return in_array($this->tipo,\frontend\modules\sta\models\StaFlujo::idsFlujosEvaluaciones() );
    /*return ($this->tipo== \frontend\modules\sta\models\StaFlujo::find()
            ->Where(['esevento'=>'1','examen'=>'1'])->one()->actividad);*/
 } 
  
/*Verifica que las fechas de las sesiones se encuentren dentro del rango 
 * del evento 
 * Y cual es el rango del evento ?
 * El rango es la fecha de programacion + h::gsetting('sta', 'nhorasreprogramacion') horas o 
 */
 private function  isOkFechasFromSesiones(){
     $ok=true;
     if($this->isTallerEvaluacion()){ /*Si es evaluacion siempre sera ok*/
         return true;
     }else{
         foreach($sesiones as $sesion){
             if(!($sesion->toCarbon('fecha')->
                   between($this->toCarbon('fechaprog'),
                $this->toCarbon('fechaprog')->
               addHours(h::gsetting('sta', 'nhorasreprogramacion')*7)))){
                 $ok=false;
                 break;
             }
         }
       return $ok;
     }
 }
 /*
  * Ubica la sesión activa
  * criterio: 
  * 
  */
 public function activeSesion(){
     $nSesiones=$this->getSesiones()->count();
     if($nSesiones==0){
       return StaEventosdet::SESION_INICIO_LIBRE;   
     }else{
         $sesionActiva=$this->getSesiones()->select(['secuencia'])->
            where(['cerrado'=>'0'])->orderby('secuencia asc')->one();
            if(!is_null($sesionActiva)){
           return  $sesionActiva->secuencia;
        }else{/* Queire deicr ue ya no encuentra sesiones abiertas todas se han cerrado*/
         return StaEventosdet::SESION_FINAL_LIBRE;
      }
     }
 }
/*Actualiza la secuencia de sesiones*/
 public function updateSecuenciaSesion($idRef){
     StaEventosSesiones::updateAll(
             ['secuencia'=>new \yii\db\Expression("secuencia+1")],
              [ ['>','id',$idref],
              'eventos_id'=>$this->id
               ]
             );
  }
  
  
public function hasCodeExamen($codig){
   
   //$codperiodo=$this->talleres->codperiodo;
   $tallerDet=Talleresdet::find()->
           where([/*'codperiodo'=>$codperiodo,*/
               'talleres_id'=>$this->talleres_id,
               'codalu'=>$codig
               ])->one();
  if(!is_null($tallerDet)){
    return $tallerDet->hasPerformedFirstExamen();  
  }else{
     return false; 
  }
   
}
  
public function currentSesion(){
   RETURN $this->getSesiones()->andWhere(['cerrado'=>'0'])->orderby('secuencia ASC')->one();
}

public function OrdenTaller(){
    if(!$this->isTallerEvaluacion()){
         $idFlujos=\frontend\modules\sta\models\StaFlujo::find()->select(['actividad'])->
      Where(['esevento'=>'1','examen'=>'1'])->column();
        yii::error(self::find()->andWhere(['talleres_id'=>$this->talleres_id])
        ->andWhere(['<=','numero',
            $this->numero,
           
            ])->andWhere(['not in', 'tipo',$idFlujos])->createCommand()->getRawSql());
        
      
      return  self::find()->andWhere(['talleres_id'=>$this->talleres_id])
        ->andWhere(['<=','numero',
            $this->numero,
           
            ])->andWhere(['not in', 'tipo',$idFlujos])->count();
    }else{
       return -1; 
    }
}

public function refreshIndicadores(){
    if(!$this->isTallerEvaluacion()){
        foreach($this->detalles as $detalle ){
         foreach($detalle->citas as $cita){
             $cita->registraIndicadorTrabajado();
         }
       }
    }
     
 }   


}
