<?php

namespace frontend\modules\sta\models;
use common\behaviors\FileBehavior;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%sta_eventos_sesiones}}".
 *
 * @property int $id
 * @property int $eventos_id
 * @property string $fecha
 * @property string $tema
 * @property string $objetivos
 * @property string $detalles
 *
 * @property StaEventos $eventos
 */
class StaEventosSesiones extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    const SCENARIO_CLOSE='cerrado';
    public static function tableName()
    {
        return '{{%sta_eventos_sesiones}}';
    }
 public $dateorTimeFields=[
        'fecha'=>self::_FDATETIME,
        
    ];
 public $booleanFields=['cerrado'];
  public function behaviors()
         {
                return [
		
		'fileBehavior' => [
			'class' => FileBehavior::className()
		],
                    'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
		
                    ];
        }
     public function scenarios()
    {
        $scenarios = parent::scenarios(); 
         $scenarios[self::SCENARIO_CLOSE] = ['cerrado'];
        return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['eventos_id','fecha'], 'required'],
            [['eventos_id'], 'integer'],
            [['detalles'], 'string'],
             [['eventos_id','tipo','url','recurso','pwd','objetivos','secuencia','cerrado','mensajecorreo'], 'safe'],
            [['fecha'], 'validateFecha'],
            [['fecha'], 'string', 'max' => 19],
            [['tema'], 'string', 'max' => 30],
            [['eventos_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaEventos::className(), 'targetAttribute' => ['eventos_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'eventos_id' => Yii::t('sta.labels', 'Eventos ID'),
            'fecha' => Yii::t('sta.labels', 'Fecha'),
            'tema' => Yii::t('sta.labels', 'Tema'),
            'objetivos' => Yii::t('sta.labels', 'Objetivos y apuntes internos'),
            'detalles' => Yii::t('sta.labels', 'Detalles'),
            'url' => Yii::t('sta.labels', 'Url vídeo conferencia'),
            'recurso' => Yii::t('sta.labels', 'Id Conferencia'),
            'pwd' => Yii::t('sta.labels', 'Paswword conferencia'),
            'mensajecorreo' => Yii::t('sta.labels', 'Apuntes a difundir'),
        ];
    }

    /**
     * Gets query for.
     *
     * 
     */
    public function getEventos()
    {
        return $this->hasOne(StaEventos::className(), ['id' => 'eventos_id']);
    }

    /**
     * {@inheritdoc}
     * @return StaEventosSesionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaEventosSesionesQuery(get_called_class());
    }
    
    public function afterSave($insert, $changedAttributes) {
        if(
          !$insert &&(
          in_array('tema',array_keys($changedAttributes))
            or in_array('objetivos',array_keys($changedAttributes) )
                     )
                  ){
           // $idEventosDet= $this->eventos->getDetalles()->select(['id'])->column();
           
            $idSesiones= array_map('strval',
         StaEventosSesiones::find()->select(['id'])->
     where(['eventos_id'=>$this->eventos->id])->
          orderBy('id asc')->column());
            $this->refresh();
         // Citas::up
          $modificados=Citas::updateAll([
               'detalles_secre'=>$this->objetivos,
              'detalles'=>$this->tema,
                   ],
                  ['and',
              ['in',"codaula",$idSesiones], //Usando el artificio
              "asistio='1'",
              "masivo='1'",
              "talleres_id=:tid",
              'flujo_id=:tip'
                  ],[
                    ":tip"=>$this->eventos->tipo,
                     //":vid"=>$this->id.'',
                     ":tid"=>$this->eventos->talleres->id
                  ]);
               // yii::error($modificados,__FUNCTION__);
          
          
        }
        
        /*Creamos el primer indicador*/
        if($this->secuencia==1){
         $this->insertaIndicador();   
        }
        
       return parent::afterSave($insert, $changedAttributes);
    }
    
    private function lastFecha(){
       return static::find()->select(['max(fecha)'])->where(['eventos_id'=>$this->eventos_id])->scalar();
    }
    
    public function validateFecha(){
        
       /* if($this->isNewRecord && $this->toCarbon('fecha')->lt(self::CarbonNow()))
        $this->addError('fecha',yii::t('sta.errors','La fecha está en el pasado'));
         */
       if($this->toCarbon('fecha')->lt($this->eventos->toCarbon('fechaprog'))){
           $this->addError('fecha',yii::t('sta.errors','La fecha es anterior al evento'));
           return;
       }
       
       
       if($this->toCarbon('fecha')->gt($this->eventos->toCarbon('fechaprog')->addHours(h::gsetting('sta', 'nhorasreprogramacion')*7))){
         $this->addError('fecha',yii::t('sta.errors','Ha excedido el plazo máximo para crear una sesión, revise la fecha de creación del evento y observe cuánto tiempo a pasado'));
         return;   
       }
       
       if($this->hasChanged('fecha') && $this->hasAsistencias()){
         $this->addError('fecha',yii::t('sta.errors','No puede cambiar la fecha, ya se registraron asistencias'));
         return ; 
       }
       
       /*Verificando fecha con otras sesiones*/
       $errores=$this->hasCruceFechas();
       if(count($errores)>0){
        $this->addError('fecha',$errores['error']);
        return;
       }
       
        /*Si cambio la fecha y ademas está intentando colocar
         *  una fecha que se cruza con una sesion anterior*/
       /*if($this->hasChanged('fecha') && $this->hasAsistencias()){
         $this->addError('fecha',yii::t('sta.errors','No puede cambiar la fecha, ya se registraron asistencias'));
         return ; 
       }*/
       
       /* $cita=New Citas();
         $cita->talleres_id=$this->eventos->talleres->id;
          $cita->fechaprog=$this->fecha;
          $cita->codtra=$this->eventos->codtra;
          if(!$cita->isInJourney() && $this->toCarbon('fecha')->gt(self::CarbonNow()))
           $this->addError('fecha',yii::t('sta.errors','La fecha está fuera del horario de trabajo, verifique los horarios del programa'));
         */  
    }
    
    public function notificaCitas(){
   
        
       //var_dump($this->correos());die();
        if($this->toCarbon('fecha')->gt($this->CarbonNow()->addHours(1))){
              $mensajes=[];
       $mailer = new \common\components\Mailer();
        $message =new  \yii\swiftmailer\Message();
        
        
        /*
         * Adjuntando los archivos
         * 
         */
        foreach ($this->files as $file){
            $message->attach($file->path);
        }
        $cid='';
        foreach($this->getImages() as $fileImagen){
            $cid .= '<img src="' . $message->embed($fileImagen->path) . '" alt="Image" />';
        }
        foreach($this->getMedia() as $fileVideo){
            //echo "murio";die();
            $cid.="<video autoplay loop muted><source src='".$message->embed($fileVideo->path)."'></video>";
            
           // $cid .= '<img src="' . $message->embed($fileImagen->path) . '" alt="Image" />';
        }
       //echo $cid; die();
        if(empty($this->mensajecorreo)){
          $cuerpo="Buenas Tardes  <br>"
                    . "La presente es para notificarle que tiene "
                    . "un taller programado VIRTUAL . <br> para el día ".$this->fecha."<br>"
                    . " "                    
                    . "  ";   
        }else{
           $cuerpo=$this->mensajecorreo;  
        }
       
       
        if(!empty($this->url) or !empty($this->pwd) or !empty($this->recurso)){
            $url=(empty($this->url))?'':$this->url;
            $pwd=(empty($this->pwd))?'':$this->pwd;
             $recurso=(empty($this->recurso))?'':$this->recurso;
            $adicional=" Recursos de conferencia :<br><br>  Url :     <a href='".$url."'>".$url."</a> <br><br> Id de reunión :        ".$recurso." <br><br> Password :        ".$pwd."<br><br><br>";
        }else{
            
            $adicional="<br>";
        }
        $pie= " Esperamos contar con tu presencia<br> Muchas gracias por tu atención ".$cid;
        
            $message->setSubject('Tienes una sesión programada')
            ->setFrom([\common\helpers\h::gsetting('mail', 'userservermail')=>'Oficina de Tutoría Psicológica'])
           ->setTo($this->eventos->correos())
           ->setCc($this->eventos->talleres->listMailsFromTutores())
          //->attach($fileName, $mensajes)
          //->setTo('neotegnia@gmail.com')       
           /*
            * Borrar esta linea si hay algun error
            */
             ->setReplyTo($this->eventos->talleres->listMailsFromTutores())      
            /*
             * Din de la iena a borar
             */
            ->SetHtmlBody($adicional.$cuerpo.$pie);
           
   
        
           $mensajes = $mailer->sendSafe($message);
           
           
        }else{
            $mensajes['error']=yii::t('sta.errors','NO se envió ningún mensaje. Debe notificar con anticipación.');
        }
      
    return $mensajes;
    }
    
  public function beforeSave($insert){
      if($insert){
          $this->secuencia=$this->eventos->getSesiones()->count()+1;
          $this->cerrado='0';
      }
      return parent::beforeSave($insert);
  } 
  /*
   * Ubica que sesion le corresponde
   * OSEA NO NECESARIAMENTE ES EL VALOR DEL CAMPO current_sesion 
   * ES UNA COMPARACION EN ENTRE LA SESION ACTULA DEL EVENTO
   *  (evento->funcion activeSesion())  compara con $this->current_sesion y devuelve el mayor
   */
  public function obtieneSesionActual(){
      
  }
  
  public function updateSesionActual(){
      
  }
  
  public function isFirstSesion(){
      $primeraSesion=$this->eventos->firstIdSesion();
      if(is_null($primeraSesion)) return true;
      return ($this->id==$primeraSesion->id);
  }
  public function isLastSesion(){
      $ultimaSesion=$this->eventos->lastIdSesion();
      if(is_null($ultimaSesion)) return true;
      return ($this->id==$ultimaSesion->id);
  }
 
  
  public function existenSesionesPreviasSinCerrar(){
  return StaEventosSesiones::find()->
            andWhere( ['<','secuencia',$this->secuencia])->
          andWhere([
              'eventos_id'=>$this->eventos_id,
                'cerrado'=>'0'
                    ])
            ->exists(); 
  }
  
  
  /*Cierra la sesion*/
  public function closeSesion(){      
     if($this->existenSesionesPreviasSinCerrar()){
         return ['error'=>yii::t('sta.errors','No puede cerrar esta sesión, cierre las sesiones previas primero')];
     }else{
         $this->setScenario(self::SCENARIO_CLOSE);
      $this->cerrado=true;
      /*ACTUALIZAR TODOS LOS CURRENT_SESION DEL EVENTO*/  
      $transa=$this->getDb()->beginTransaction();
      StaEventosdet::updateAll(['current_sesion'=>$this->secuencia],
              ['eventos_id'=>$this->eventos_id]);
      $this->save();
      $transa->commit();
       return ['success'=>yii::t('sta.errors','Se ha cerrado la sesión con secuencia {secuencia}',['secuencia'=>$this->secuencia])];
     }     
  }
  
  public function hasAsistencias(){
     return Citas::find()->andWhere(['not',"codaula=''"])->andWhere(['codaula'=>$this->id.''])->exists();
  }
 
  
  private function hallarSecuencia(){
   return ($this->isNewRecord)?($this->eventos->getSesiones()->count()+1):$this->secuencia;
   
  }
  
  
  
  
  public function hasCruceFechas(){
     /*Verificando que la fecha no se am enor a before Sesion*/
      $SesionAnterior=$this->beforeSesion();
       $SesionPosterior=$this->afterSesion();
      if(!is_null($SesionAnterior)){
         if( $this->toCarbon('fecha')->lt($SesionAnterior->toCarbon('fecha'))  )
          return ['error'=>yii::t('sta.errors','Ya hay una sesión anterior con una fecha {fechaant} y esta fecha que intenta colocar tiene que ser mayor ',['fechaant'=>$SesionAnterior->fecha])];
      }
      if(!is_null($SesionPosterior)){
         if( $this->toCarbon('fecha')->gt($SesionPosterior->toCarbon('fecha'))  )
          return ['error'=>yii::t('sta.errors','Ya hay una sesión posterior con una fecha {fechapost} y esta fecha que intenta colocar tiene que ser mayor ',['fechapost'=>$SesionPosterior->fecha])];
      }
     return [];
  }
  
  
  public function unCloseSesion(){
      //Primero verificamos que la sesion sea la última 
      if(!$this->existenSesionesPosterioresCerradas()){
          //leugo verificamos que si hay sesion posterior abierta 
          // esta no tenga asistencias confirmadas con sus secuencia
          //por ejemplo si usted quiere desbloquear una sesion con secuencia 1
          //Y hay una sesion con secuencia 2 desbloqueada , hasta ahi todo bien
          //pero que pasa si esta sesion con secuencia 2 tiene algun alumno
          //Con asistencia en la sesiosn con secuecnia 2.... tendría que deshacer la
          //asistencia primero....!
          
          //Verificando esto
        if(!$this->nextSesionHasAsistencias()){
             /*Obtener el Id anterior de la sesion*/
          $secuencia_anterior=$this->beforeSecuencia();
          yii::error('secuencia anteriro '.$secuencia_anterior);
         /*Obtener el grupo de detalles que y verificar quienes 
          * tienen asistencia con esta sesión que se quiere desbloquear
          * Se detectan estos detalles y se coloca curren_sesion atrasada ($secuencia_anterior)
          * para dar el mismo efecto anterior de los botones , antes de 
          * cerrar esta sesión
          */ 
         
          /*Buscamos en las citas como testigos de la asisdtecia */
          $IdsTalleresCitas=Citas::find()->select(['talleresdet_id'])->andWhere([
              //'talleresdet_id' => $talleresdet_id,
            'flujo_id' => $this->eventos->tipo,
            'codaula'=>''.$this->id,
          ])->column();
           yii::error('Consulta de citas ');
          yii::error(Citas::find()->select(['talleresdet_id'])->andWhere([
              //'talleresdet_id' => $talleresdet_id,
            'flujo_id' => $this->eventos->tipo,
            'codaula'=>''.$this->id,
          ])->createCommand()->getRawSql());
          
          
  $IdsDetalleConAsistenciaEnEstaSesion=StaEventosdet::find()->select(['id'])->
       andWhere(['talleresdet_id'=> $IdsTalleresCitas,'eventos_id'=>$this->eventos_id])->column();
                    
           yii::error('Id detalles eventos scon secuecnia anteriro ');
          yii::error( $IdsDetalleConAsistenciaEnEstaSesion);
           
          $idsDetalles=$this->eventos->getDetalles()->select(['id'])->column();
          $diferencia= array_diff($idsDetalles, $IdsDetalleConAsistenciaEnEstaSesion);
           yii::error('diferencia ');
          yii::error( $diferencia);
           $this->setScenario(self::SCENARIO_CLOSE);
            $this->cerrado=false;
             $transa=$this->getDb()->beginTransaction();
      StaEventosdet::updateAll(['current_sesion'=>$secuencia_anterior],
              ['id'=>$diferencia]
              );
      $this->save();
      $transa->commit();
           return ['warning'=>yii::t('sta.errors','Se ha desbloqueado la sesión con secuencia {secuencia}',['secuencia'=>$this->secuencia])];
      
        }else{
          return ['error'=>yii::t('sta.errors','Hay una sesión posterior a ésta y tiene asistencias, primero deshaga las asistencias')]; 
        
        }
        
          
          }else{
          return ['error'=>yii::t('sta.errors','Hay una sesión posterior a ésta con secuencia {secuencia} y se encuentra cerrada, abrála primero ',['secuencia'=>$this->secuencia])]; 
      }
      
  }
  
   public function existenSesionesPosterioresCerradas(){
  return StaEventosSesiones::find()->
            andWhere( ['>','secuencia',$this->secuencia])->
          andWhere([
              'eventos_id'=>$this->eventos_id,
                'cerrado'=>'1'
                    ])
            ->exists(); 
  }
  
  public function nextSesion(){
     return self::find()->andWhere([ 'eventos_id'=>$this->eventos_id])
       ->andWhere(['>','secuencia',$this->secuencia])->orderby('secuencia ASC')->one();
  }
  public function beforeSesion(){
     return self::find()->andWhere([ 'eventos_id'=>$this->eventos_id])
       ->andWhere(['<','secuencia',$this->secuencia])->orderby('secuencia DESC')->one();
     
  }
  public function afterSesion(){
     return self::find()->andWhere([ 'eventos_id'=>$this->eventos_id])
       ->andWhere(['>','secuencia',$this->secuencia])->orderby('secuencia ASC')->one();
     
  }
   public function nextSecuencia(){
     $next= $this->nextSesion();
    return (!is_null($next))?$next->secuencia:StaEventosdet::SESION_FINAL_LIBRE;
   }
   public function beforeSecuencia(){
     $before= $this->beforeSesion();
    return (!is_null($before))?$before->secuencia:StaEventosdet::SESION_INICIO_LIBRE;
   }
  
 public function nextSesionHasAsistencias(){
     $next=$this->nextSesion();
     IF(is_null($next)){
         return false;
     }else{
        return StaEventosdet::find()->andWhere(
                 [
                     'eventos_id'=>$this->eventos_id,
                     'current_sesion'=>$next->secuencia,
                     'asistio'=>'1',
                     ]
                 )->exists();
     }
 }  
 
public function nAsistencias(){
   return  Citas::find()->andWhere(['codaula'=>''.$this->id,'asistio'=>'1'])->count();
}

public function insertaIndicador(){
    $model=new StaIndisesiones();
    $model->setAttributes([
        'codfac'=>$this->eventos->codfac, 
         'sesiones_id'=>$this->id,
        'eventos_id'=>$this->eventos_id,
         'indicador_id'=>$this->eventos->flujo->indicador_id,
        'detalles'=>'', 
         'relevancia'=>1,
    ]);
    return $model->save();
    
}

public function indicadoresId(){
        return StaIndisesiones::find()->andWhere(['sesiones_id'=>$this->id])->select(['indicador_id'])->column();
    }

    
 
    
 
}
