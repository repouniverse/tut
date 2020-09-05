<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\models\StaFlujo;
use Yii;
USE yii\db\Transaction;

/**
 * This is the model class for table "{{%sta_eventosdet}}".
 *
 * @property int $id
 * @property int $eventos_id
 * @property int $talleresdet_id
 * @property int $talleres_id
 * @property string $codalu
 * @property string $asistio
 * @property string $nombres
 * @property string $detalle
 * @property string $correo
 *
 * @property StaAlu $codalu0
 * @property StaEventos $eventos
 * @property StaTalleres $talleres
 * @property StaTalleresdet $talleresdet
 */
class StaEventosdet extends \common\models\base\modelBase
{
   const SCENARIO_NUMERO_CITA='numerocita';
   const SCENARIO_ASISTENCIA='asistencia';
   
   CONST SCENARIO_AGREGA_ALUMNO='agregaalumno';
   CONST SCENARIO_SESION='sesion';
   CONST SCENARIO_LIBRE='libre';
   CONST SESION_INICIO_LIBRE=0; /* NUMERO DE SESION INICIO CUANDO NO HAY NINGUAN SESION*/
   CONST SESION_FINAL_LIBRE=99; /*NUMERO DE SESION FINAL CUANDO YA HA PASADO POR TODAS LAS SESIONES EXISTENTES*/
   public $booleanFields=['asistio','libre'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_eventosdet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['eventos_id', 'talleresdet_id', 'talleres_id', 'codalu', 'asistio', 'nombres'], 'required'],
            [['eventos_id', 'talleresdet_id', 'talleres_id'], 'integer'],
            [['detalle'], 'string'],
            [['codfac','celulares','numerocita','asistio','libre','current_sesion'], 'safe'],
            [['codalu'], 'validateAluSolo', 'on' =>self::SCENARIO_AGREGA_ALUMNO],
            [['codalu'], 'string', 'max' => 14],
             [['correo'], 'email'],
             [['libre','asistio','codcar','clase'], 'safe'],
            ['codalu', 'unique', 'targetAttribute' => 
                 ['codalu','eventos_id'],
              'message'=>yii::t('sta.errors',
                      'Esta combinacion de valores {codalu}-{evento} ya existe',
                      ['codalu'=>$this->getAttributeLabel('codalu'),
                        'evento'=>$this->eventos_id]
                      )],
            
            
            
           // [['asistio'], 'string', 'max' => 1],
            [['nombres', 'correo'], 'string', 'max' => 60],
            [['codalu'], 'exist', 'skipOnError' => true, 'targetClass' => Alumnos::className(), 'targetAttribute' => ['codalu' => 'codalu']],
            [['eventos_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaEventos::className(), 'targetAttribute' => ['eventos_id' => 'id']],
            [['talleres_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleres::className(), 'targetAttribute' => ['talleres_id' => 'id']],
            [['talleresdet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleresdet::className(), 'targetAttribute' => ['talleresdet_id' => 'id']],
        ];
    }
    
 public function behaviors()
         {
                return [
		 'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
                    ];
        }
       
public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios[self::SCENARIO_NUMERO_CITA] = ['numerocita'];
         $scenarios[self::SCENARIO_ASISTENCIA] = ['asistio','libre'];
          $scenarios[self::SCENARIO_AGREGA_ALUMNO] = ['codalu']; 
           $scenarios[self::SCENARIO_SESION] = ['current_sesion','asistio']; 
           $scenarios[self::SCENARIO_LIBRE] = ['libre']; 
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'eventos_id' => Yii::t('sta.labels', 'Eventos ID'),
            'talleresdet_id' => Yii::t('sta.labels', 'Talleresdet ID'),
            'talleres_id' => Yii::t('sta.labels', 'Talleres ID'),
            'codalu' => Yii::t('sta.labels', 'Cod. Alumno'),
            'asistio' => Yii::t('sta.labels', 'Asistio'),
            'nombres' => Yii::t('sta.labels', 'Nombres'),
            'detalle' => Yii::t('sta.labels', 'Detalle'),
            'correo' => Yii::t('sta.labels', 'Correo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno()
    {
        return $this->hasOne(Alumnos::className(), ['codalu' => 'codalu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvento()
    {
        return $this->hasOne(StaEventos::className(), ['id' => 'eventos_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTalleres()
    {
        return $this->hasOne(Talleres::className(), ['id' => 'talleres_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTalleresdet()
    {
        return $this->hasOne(Talleresdet::className(), ['id' => 'talleresdet_id']);
    }

    public function getCitas()
    {
        return $this->hasMany(Citas::className(), ['talleresdet_id' => 'talleresdet_id']);
    }
    
    /**
     * {@inheritdoc}
     * @return StaEventosdetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaEventosdetQuery(get_called_class());
    }
    
    public function createCita($codtra,$fechaprog=null,$flujo_id,$asistio=true,$idsesion=null){
        $formatoMySql=\common\helpers\timeHelper::formatMysqlDateTime();
        // yii::error('fechaprog pasada a la funcion create cita : ');
        // yii::error($fechaprog);
        if(is_null($fechaprog)){
            // yii::error('fechaprog es nulo ');
            $fechax=date($formatoMySql);  
        }else{
            // yii::error('fechaprog es '.$fechaprog);
            // yii::error('cambiando el formato');
            $fechax=self::SwichtFormatDate($fechaprog,self::_FDATETIME,false);
            // yii::error('ahorala la fecha es '.$fechax);
        }
      
        //yii::error($fechax);       
        $attributes=[
                'talleres_id'=>$this->talleres_id,
                'talleresdet_id'=>$this->talleresdet_id,
             'fechaprog'=>self::SwichtFormatDate($fechax,self::_FDATETIME,true),//$fechaprog,  
            //'fechaprog'=>$fechaprog,
                'codtra'=>$codtra,
                 'codfac'=>$this->codfac,
                  'codaula'=>$idsesion.'', //ARTIFICIO PARA FILTRAR LUEGO 
                'masivo'=>true,
                 'asistio'=>$asistio,
                  'flujo_id'=>$flujo_id,  
            ];
        /*yii::error(Citas::find()->where([
                'talleres_id'=>$this->talleres_id,
                'talleresdet_id'=>$this->talleresdet_id,
              'asistio'=>'1',
                 'codaula'=>$idsesion.'',
                   ])->andWhere(['between', 'fechaprog',
                self::CarbonNow()->subMinutes(20)->format($formatoMySql),
                self::CarbonNow()->addMinutes(20)->format($formatoMySql)
                           ])->createCommand()->getRawSql());*/
        $query=Citas::find()->where([
                'talleres_id'=>$this->talleres_id,
                'talleresdet_id'=>$this->talleresdet_id,
               'asistio'=>'1',
              //'flujo_id'=>$flujo_id,
                 'codaula'=>$idsesion.'',
                   ])->andWhere(['between', 'fechaprog',
                self::CarbonNow()->subMinutes(20)->format($formatoMySql),
                self::CarbonNow()->addMinutes(20)->format($formatoMySql)
                           ]);
        if(in_array((integer)$flujo_id, array_map('intval',StaFlujo::idsFlujosEvaluaciones()))){
            $query->andWhere(['flujo_id'=>$flujo_id]);
        }
        if(!$query->exists()){ //Evitar crear citas duplicados 
            $model=New Citas();
            $model->setScenario(Citas::SCE_CREACION_BASICA);
            $model->setAttributes($attributes);
            /*
             * Iniciando la transaccion para alta concurrencia de usuarios
             */
            $transaccion=$model->getDb()->beginTransaction(Transaction::SERIALIZABLE);
            //$conexion->beginTransaction(Transaction::SERIALIZABLE);
           if($model->save()){
               //yii::error('grabo');
              $transaccion->commit();
               //yii::error('grabo',__FUNCTION__);
               return $model; 
              //return [];
           }else{
                //yii::error('no grabo');
                $transaccion->rollBack();
              // yii::error($model->getErrors(),__FUNCTION__);
               return ['error'=>$model->getFirstError()];///$model->getErrors();
           }
        } else{
            yii::error('ya existe un registro ');
            return ['error'=>yii::t('sta.errors','Ya hay una cita creada para estos propósitos')];
        }
           // var_dump($fecha,$model::_FDATETIME,$model::SwichtFormatDate($fecha,$model::_FDATETIME,true));die();
           
             
            
    }
    
    public function lastNumberCita(){
            return Citas::find()->select([max('numero')])->andWhere([
                'talleresdet_id'=>$this->talleresdet_id
                    ])->scalar();
      }
    public function updateNumeroCita($numeroCita){
        $this->setScenario(self::SCENARIO_NUMERO_CITA);
        $this->numerocita=$numeroCita;
        return $this->save();
    }
    
    public function updateAsistencia(){
        $this->setScenario(self::SCENARIO_ASISTENCIA);
        $this->asistio=true;
        if(!$this->save()){
            return false;
             print_r($this->getErrors());die();
        }
        
        return $this->save();
    }
    
    public function updateLibre(){
        $this->setScenario(self::SCENARIO_LIBRE);
        $this->libre=true;
        if(!$this->save()){
            return false;
             print_r($this->getErrors());die();
        }
        
        return $this->save();
    }
    
    public function afterSave($insert, $changedAttributes) {
       if(!$insert && in_array('correo',array_keys($changedAttributes))){
           $alumno=$this->alumno;
          $alumno->setScenario($alumno::SCENARIO_CORREO);
          $alumno->correo=$this->correo;
           //throw new NotFoundHttpException(Yii::t('sta.labels', 'Registro no encontrado'));
          $alumno->save();
       }
       
       if(!$insert && in_array('celulares',array_keys($changedAttributes))){
           $alumno=$this->alumno;
          $alumno->setScenario($alumno::SCENARIO_CELULARES);
          $alumno->celulares=$this->celulares;
           //throw new NotFoundHttpException(Yii::t('sta.labels', 'Registro no encontrado'));
          $alumno->save();
       }
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function  validateAluSolo($attribute,$params){
        ///El alumno adicional no debe de estar en la lista
       /* $codesAlready=$this->evento->codesInThis();
       if(in_array($this->codalu, $codesAlready)){
           $this->addError('codalu',yii::t('sta.errors','Este Alumno ya está en el evento'));
       } 
       //El alumno adicional no debe de  estar fuiera del programa
       if(!Talleresdet::except()->andWhere(['codalu'=>$this->codalu])->exists()){
           yii::error(Talleresdet::except()->andWhere(['codalu'=>$this->codalu])->createCommand()->getRawSql());
            $this->addError('codalu',yii::t('sta.errors','Este Alumno no está dentro del programa de tutoría actual'));
       }
       //El alumno no deeb de estar en otro evento activo en el futuro
       $IdsFuture=  StaEventos::find()->select(['id'])->andWhere(['>','fechaprog',$this->evento->swichtDate('fechaprog',false)])->column();
       if(static::find()->andWhere([
           'codalu'=>$this->codalu,
           'eventos_id'=>$IdsFuture,               
       ])->exists()){
           $this->addError('codalu',yii::t('sta.errors','Este Alumno ya está registrado en otro evento a futuro'));
     
       }
       */
         $evento= $this->evento; 
        if(!$evento->codeInPrograma($this->codalu)){
            $this->addError('codalu',yii::t('sta.labels','El alumno "{codigo}" no está dentro del programa',['codigo'=>$this->codalu]));
        }
                
        if(!$evento->codeIsFree($this->codalu)){
          $this->addError('codalu',yii::t('sta.labels',$evento->getFirstError()));
        
        }
      
        if(!$evento->isTallerEvaluacion() && !$evento->hasCodeExamen($this->codalu)){
           $this->addError('codalu',yii::t('sta.labels','El alumno "{codigo}" no ha pasado evaluación',['codigo'=>$this->codalu]));
           
        }
             
        if(!$evento->codeIsFree($this->codalu)){
            $error=$evento->getFirstError();
            $this->addError('codalu',$error);
        
            //$this->addError('codalu',yii::t('sta.labels','El alumno "{codigo}" ya está dentro del evento {numeroevento}',['numeroevento'=>$evento->numero,'codigo'=>$this->codalu]));
        
        }
       
       //debe de estar enter las fechas de trabajo
       /*if(!$this->evento->isDateToWork()){
             $this->addError('codalu',yii::t('sta.errors','    La fecha actual no se encuentra dentro del rango de fechas de trabajo para este evento'));
       }*/
       if($this->evento->isClosed()){
            $this->addError('codalu',yii::t('sta.errors','El evento ya está cerrado'));
    
       }
    }
   
   
  public function cita(){
     return Citas::find()->
             andWhere(['numero'=>$this->numerocita])->
              andWhere(['not',['numero'=>null]])->
             One();
  } 
  
  
   public function updateAsistenciaConCita($idsesion){        
         //Verificando si 
       
       
         /*Ahora creamos las  citas,  */
         $codtra=$this->evento->codtra;
         $fechaprog=$this->evento->fechaprog;
         $flujo_id=$this->evento->tipo;
         /*$sesiones=StaEventosSesiones::find()->
     where(['eventos_id'=>$this->evento->id])->orderby('id asc')->all();*/
        $resultados=[];
        
        $sesion= StaEventosSesiones::findOne($idsesion);
        
              $this->setScenario(self::SCENARIO_SESION);
        $this->asistio=true;
        $this->current_sesion=$sesion->secuencia;    
        $this->save();
        
              if($sesion->toCarbon('fecha')->lt(self::CarbonNow())){
                //$fechita=null; 
                $fechita=$sesion->fecha; 
                $asistio=true;
              } else{
                 $fechita=$sesion->fecha; 
                 $asistio=true;
              } 
           //$asistio=($sesion->toCarbon('fecha')->diffInMinutes($this->evento->toCarbon('fechaprog')) < 2 )?true:false;
                     $resultado=$this->createCita($codtra, $fechita, $flujo_id, $asistio,$sesion->id);
             
            if(is_array($resultado)){
               return $resultado;
            }else{
                if(is_object($resultado)){
                    /*Agrega e indincador trabajado en este taller*/
                    $resultado->registraIndicadorTrabajado(); 
                }
              return $resultado;
                 }    
        
    }
    
    
 
 /*
  * Revierte los efectos de la función anterior UPDATEASISTENCIACONCITA()
  */
 
 public function revertAsistenciaConCita($idcita){
     
 
    /* $sesionActual=$this->currentSesion();
     if(is_null($sesionActual)) return ['error'=>yii::t('sta.errors','No se encontró la sesión para esta secuencia')];
     if($sesionActual->cerrado)
     return ['error'=>yii::t('sta.errors','No puede deshacer porque la sesión actual con secuencia {secuencia} asociada a esta asistencia está cerrada',['secuencia'=>$sesionActual->secuencia])];
     $nextSesion=$this->nextSesion();
     if(!is_null($nextSesion))
      if($nextSesion->cerrado)
      return ['error'=>yii::t('sta.errors','No puede deshacer porque la sesión posterior con secuencia {secuencia} asociada a esta asistencia está cerrada',['secuencia'=>$nextSesion->secuencia])];
     
     if($this->isLastSesionWithAsistencias()){*/
       //$this->setScenario(self::SCENARIO_ASISTENCIA);
        //$this->maxIdCita();
         //$this->asistio=false;
         //$this->current_sesion=$this->current_sesion-1;
         //$this->save();
     
        // $maxIdCita=$this->maxIdCita()+0;
          //var_dump($maxIdCita,$idcita);die();
         if($this->nextSesion()==self::SESION_FINAL_LIBRE){
           
            $this->setScenario(self::SCENARIO_ASISTENCIA);
        //$this->maxIdCita();
         //$this->asistio=false;
           $this->current_sesion=$this->current_sesion-1;
            //var_dump($this->current_sesion-1);die();
            $this->save(); 
         }
         Citas::updateAll(['activo'=>'0'],
                [
                
                'id'=>$idcita
                    ]); 
         return ['success'=>yii::t('sta.errors','Se anuló la asistencia de  '.$this->nombres)];
      
         
    /* }else{
      return ['error'=>yii::t('sta.errors','Esta no es la última asistencia, verifique anule primero la asistencia más reciente')];
      }*/
        
       
    }
    
    
 /*
  * DTERMIAN QUE SESION LE TOCA ,
  */
   
 public function nextSesion(){
    if($this->evento->getSesiones()->count()==0){
      RETURN  self::SESION_INICIO_LIBRE;
    } ELSE{        
       $sesion=$this->evento->getSesiones()->andWhere(['cerrado'=>'0','secuencia'=>$this->current_sesion+1])->one();
       if(is_null($sesion)) {
         RETURN  self::SESION_FINAL_LIBRE;
       }else{
         return $sesion->secuencia;  
       }
    }
 }  
 
 
public function obtenerIdNextSesion(){
   $model= StaEventosSesiones::find()->
            andWhere(['secuencia'=>$this->nextSesion(),'eventos_id'=>$this->eventos_id])
            ->one();
   return(!is_null($model))?$model->id:null;
} 
 
/*Antes de aplicar en la sesion siguietne , verificar que las
 * sneriores esten cerradas
 */
public function existenSesionesPreviasSinCerrar($secuencia){
  return StaEventosSesiones::find()->
            andWhere( ['<','secuencia',$secuencia])->
          andWhere([
              'eventos_id'=>$this->eventos_id,
                'cerrado'=>'0'
                    ])
            ->exists(); 
}

/*
 * Verifica que este detalle  tiene citas con asistencia
 * y ademas es la cita con asitencia mas reciente 
 */
public function isLastSesionWithAsistencias(){
 $idSesiones=array_map('strval',$this->evento->getSesiones()->select(['id'])->column());
 
 
 
 $maxSesion= Citas::find()->select(['max(codaula)'])->andWhere([
             'talleresdet_id' => $this->talleresdet_id,
            'flujo_id' => $this->evento->tipo,
            'codaula'=>$idSesiones,
          ])->scalar(); 
 if($maxSesion===false) return false;

$sesionConAsistenciaMaxima= StaEventosSesiones::findOne($maxSesion+0);
if($sesionConAsistenciaMaxima->secuencia <=$this->current_sesion){
    return true;
}else{
    return false;
}
 
 
}
 
public function currentSesion(){
   return StaEventosSesiones::findOne(['eventos_id'=>$this->eventos_id,'secuencia'=>$this->current_sesion]);
}

public function maxIdCita(){
     $idSesiones=array_map('strval',$this->evento->getSesiones()->select(['id'])->column());
          return Citas::find()->select(['max(id)'])->andWhere([
             'talleresdet_id' => $this->talleresdet_id,
            'flujo_id' => $this->evento->tipo,
            'codaula'=>$idSesiones,
          ])->scalar();
}

public function beforeSave($insert) {
        parent::beforeSave($insert);
        if($insert){
             $this->clase= \frontend\modules\sta\staModule::CLASE_RIESGO;
            
        }
        return true ;
    }



}


