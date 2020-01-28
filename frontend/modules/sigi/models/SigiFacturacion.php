<?php

namespace frontend\modules\sigi\models;
use frontend\modules\sigi\models\SigiCuentaspor;
use frontend\modules\sigi\models\SigiDetfacturacion;
use frontend\modules\sigi\models\SigiKardexdepa;
use Yii;
use  yii\web\ServerErrorHttpException;
USE yii\data\ActiveDataProvider;
use frontend\modules\report\models\Reporte;
/**
 * This is the model class for table "{{%sigi_facturacion}}".
 *
 * @property int $id
 * @property int $edificio_id
 * @property string $mes
 * @property string $ejercicio
 * @property string $fecha
 * @property string $descripcion
 * @property string $detalles
 *
 * @property SigiDetfacturacion[] $sigiDetfacturacions
 * @property SigiEdificios $edificio
 */
class SigiFacturacion extends \common\models\base\modelBase
{
   //public static $varsToReplace=['$cuenta'=>'','$dias'=>'','$banco'=>'','$correo_cobranza'=>''];
    public $hardFields=['edificio_id','mes','ejercicio'];
     public $dateorTimeFields=['fvencimiento'=>self::_FDATE,'fecha'=>self::_FDATE];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_facturacion}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edificio_id', 'mes', 'descripcion','fecha','fvencimiento','reporte_id'], 'required'],
            [['edificio_id'], 'integer'],
              [['fvencimiento','detalleinterno','unidad_id','reporte_id'], 'safe'],
            ['fvencimiento', 'validateFechas'],
            [['detalles'], 'string'],
            [['mes'], 'string', 'max' => 2],
            [['ejercicio'], 'string', 'max' => 4],
            [['fecha'], 'string', 'max' => 10],
            [['descripcion'], 'string', 'max' => 40],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'mes' => Yii::t('sigi.labels', 'Mes'),
            'ejercicio' => Yii::t('sigi.labels', 'Ejercicio'),
            'fecha' => Yii::t('sigi.labels', 'Fecha'),
            'descripcion' => Yii::t('sigi.labels', 'Descripcion'),
            'detalles' => Yii::t('sigi.labels', 'Detalles'),
        ];
    }

   
    public function getSigiCuentaspor()
    {
        return $this->hasMany(SigiCuentaspor::className(), ['facturacion_id' => 'id']);
    }
    
    public function getSigiDetfacturacion()
    {
        return $this->hasMany(SigiDetfacturacion::className(), ['facturacion_id' => 'id']);
    }
    
    
    public function montoTotal(){
       RETURN $this->getSigiCuentaspor()->sum('monto');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }
    public function getReporte(){
       return $this->hasOne(Reporte::className(), ['id' => 'reporte_id']);
   
    }
    

    /**
     * {@inheritdoc}
     * @return SigiFacturacionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiFacturacionQuery(get_called_class());
    }
 
    public function afterSave($insert,$changedAttributes ) {
      if($insert){
          $this->refresh();
          yii::error('El id d efacturacion es');
          yii::error($this->id);
          $this->createAutoFac(); //cREA LOS RECIBOS AUTOMATICOS DEL PRESUPUESTO
      }
        return parent::afterSave($insert,$changedAttributes );
    }
    
    
    /*
     *Crea los recibos automáticos para la facturacion
     * Solo aquellos de emisor interno JDp y que sean respuestables 
     */
    public function createAutoFac(){
        $scenario= SigiCuentaspor::SCENARIO_RECIBO_AUTOMATICO;
       $edificio= Edificios::findOne($this->edificio_id);
      // $facturacion= SigiFacturacion::findOne($this->facturacion_id);
      // var_dump($edificio->cargos,$edificio->cargos->sigiCargosedificios);die();
       yii::error('inicnado primer bucle ');
       foreach($edificio->cargos as $cargo){
            yii::error('inicnado segundo bucle ');
          foreach($cargo->sigiCargosedificios as $colector){
              yii::error('dentro del rtercer bucle ');
              //var_dump(count($cargo->sigiCargosedificios));echo"<br><br><br>";
              yii::error($colector->cargo->descargo);
               yii::error($colector->isBudget());
               yii::error(!$this->hasReciboAuto($colector->id));
             if($colector->isBudget() && !$this->hasReciboAuto($colector->id)) {
                   yii::error('creando la boleta ');     
                 $model=new SigiCuentaspor();
                      $model->setScenario(SigiCuentaspor::SCENARIO_RECIBO_AUTOMATICO);
                      $model->setAttributes($this->prepareFieldsAuto($edificio, $colector));
                       yii::error($model->attributes);  
                      IF($model->save()){
                         yii::error('grabo');  
                      }ELSE{
                         yii::error($model->getFirstError()); 
                      }
                // yii::error('El colector is es '.$colector->id);
                      }
           }
        }
    }
    
    
    public function hasReciboAuto($id_colector){
        $registro=SigiCuentaspor::find()
                ->andWhere(['edificio_id'=>$this->edificio_id])
                ->andWhere( ['mes'=>$this->mes])
                 ->andWhere( ['facturacion_id'=>$this->id])
                ->andWhere(['anio'=>$this->ejercicio])
                 ->andWhere(['colector_id'=>$id_colector])->one();
       
       
            return (!is_null($registro))?true:false ;
        
    }
    
    private function prepareFieldsAuto($edificio,$colector){
   
        return [
            'edificio_id'=>$this->edificio_id,
            'facturacion_id'=>$this->id,
            'numerodoc'=>$edificio->codigo. SigiCuentaspor::COD_RECIBO_INTERNO.'-AB-00034',
            'descripcion'=>$colector->cargo->descargo,
            'mes'=>$this->mes,
            'anio'=>$this->ejercicio,
            'codestado'=> SigiCuentaspor::ESTADO_CREADO,
            'codocu'=> SigiCuentaspor::COD_RECIBO_INTERNO,
            'codpro'=>$edificio->emisorDefault()->codpro,
            'fedoc'=>$this->fecha,
           'colector_id'=>$colector->id,
            'codmon'=>\common\helpers\h::gsetting('general', 'moneda'),
            'monto'=>$colector->montoTotal($this->mes,$this->ejercicio),
        ];
    }
    
    /*Verifica que todosl los coelctores del 
     * rpesupesto 
     * esten en el detalle 
     */
    public function isCompleteColectores(){
       $dif= array_diff($this->idsColectoresInBudget(),$this->idsColectores());
       //VAR_DUMP($this->idsColectoresInBudget(),$this->idsColectores(),$dif);die();
       return (count($dif)>0)?false:true;
    }
    
    
    
    public function generateFacturacionMes(){
        $errores=[];
        yii::error('generando facturacion');
        if(count($this->getSigiCuentaspor()->select('codmon')->distinct()->column())==1){
             
      
       if($this->isCompleteColectores()){
          if($this->isCompleteReadsSuministros()){
        /* foreach($this->sigiCuentaspor as $cuentapor){
            $err=$cuentapor->generateFacturacion();
            if(count($err)>0){
                $errores['error']=yii::t('sigi.errors','Se presentaron algunos incovenientes'); 
            }else{
               $errores['success']=yii::t('sigi.errors','Se ha generado la facturacion sin problemas '.$this->balanceMontos());  
            }
          }*/
           $this->shortFactu();
           $this->asignaIdentidad();//Importante  
           $this->asignaNumero();
        }else{
            
           $errores['error']=yii::t('sigi.errors','Hay suministros que aun no tienen lectura verifique por favor'); 
        } 
       }else{
           $errores['error']=yii::t('sigi.errors','Falta agregar recibos o conceptos en la facturación');  
       }
       
       //Verificando que todos los recibos tengan la misma moneda 
        }else{
            $errores['error']=yii::t('sigi.errors','Existe más de una moneda verifique los detalles');
        }
       
       
        return $errores;
    }
    /*
     * Esta funcion revisa la columna identidad de
     * la tabla facturaciondetalle y la catualiza
     * segune lgrupo de facturacion , de este modo ya se puede separar
     * lso recibos mediante un id 
     */
    private function asignaIdentidad(){
        foreach($this->grupos() as $filaGrupo){
          $criterio= SigiDetfacturacion::criteriaDepa(
                  $filaGrupo->grupofacturacion,
                  $filaGrupo->mes,
                  $filaGrupo->anio,
                  $filaGrupo->facturacion_id
                  );
          $identidad= SigiDetfacturacion::maxIdentidad();
            SigiDetfacturacion::updateAll(['identidad'=>$identidad], $criterio);
       }
       return true;
    }
    
    
    public function grupos(){
       return  $this->getSigiDetfacturacion()->
                select(['grupofacturacion','mes','anio','facturacion_id'])->
                distinct()->all();
        
    }
    
    public function idsToFacturacion(){
       return  array_column($this->getSigiDetfacturacion()->
                select('identidad')->distinct()
                ->all(),'identidad');
        
    }
    
    public function idsColectores(){
       return  array_column($this->getSigiCuentaspor()->
                select('colector_id')->distinct()
                ->all(),'colector_id');
        
    }
    
    public function idsColectoresInBudget(){
       return  array_column(SigiBasePresupuesto::find()->
                select('cargosedificio_id')->distinct()->
               where([
                   'edificio_id'=>$this->edificio_id,
                     'ejercicio'=>$this->ejercicio,
                   ])->all(),'cargosedificio_id');
        
    }
    
    public function idsToCuentasPor(){
       return  array_column($this->getSigiCuentaspor()->
                select('id')->distinct()
                ->all(),'id');
        
    }
    
    
    
    /*Verifica que todos los medidores tengan su lectura*/
    public function isCompleteReadsSuministros(){
        $iscomplete=true;
        $tipomedidores=$this->edificio->typeMedidores();
   IF(count($tipomedidores)>0){
        foreach($tipomedidores as $key=>$type){
        $nlecturas=SigiLecturas::find()->where(
                ['edificio_id'=>$this->edificio_id,
                    'mes'=>$this->mes,
               'facturable'=>'1',
                    'codtipo'=>$type,
                ])->count();
       
      if($nlecturas ==0){
          $iscomplete=false; 
        break;   
      }
      $nmedidores=$this->edificio->nMedidores($type); 
       //var_dump($nmedidores,$nlecturas,$nlecturas % $nmedidores);die();
          if(($nlecturas % $nmedidores) <> 0) //Si las cantidades SON multiplos de la cantidad de medidores entonces OK           
          {
             $iscomplete=false; 
           break;     
          }
           }
   }else{
       return false;
   }
   
    return $iscomplete;      
          }
    
    /*Dataprovider de los mediores que faltan lecturas*/
    public function providerFaltaLecturas($type){
       $idsMedidores=$this->edificio->idsMedidores($type);
      $idsFaltan=[];
           $idsConLecturas=array_column(SigiLecturas::find()->select('suministro_id')
                ->where([
                    'edificio_id'=>$this->edificio_id,
                    'mes'=>$this->mes,
                    'anio'=>$this->ejercicio,
                    // 'flectura'=>static::SwichtFormatDate($this->fecha, 'date',false),
                   'facturable'=>'1',
                    'codtipo'=>$type,
                        ])->asArray()->all(),'suministro_id');
             
                $idsTotales=$this->edificio->idsMedidores($type);
                
                $idsFaltan= array_diff($idsTotales,  $idsConLecturas);
               // var_dump($idsTotales,$idsConLecturas,$idsFaltan);die();
              $query= SigiSuministros::find()->where(['in','id',$idsFaltan]);        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
        return $dataProvider;
    }
    
    public function resetFacturacion(){
      $borrados= \frontend\modules\sigi\models\SigiDetfacturacion::deleteAll(['facturacion_id'=>$this->id]);
      yii::error('borrados '.$borrados.'  Registros');
      \frontend\modules\sigi\models\SigiLecturas::updateAll(['cuentaspor_id'=>null],
              [ 
                 'mes'=>$this->mes,
                  'anio'=>$this->ejercicio,
                  'cuentaspor_id'=>$this->idsToCuentasPor()
            ]);
    }
            
  public function generateTempReads(){
      
  } 
  /*
   * Verifica que la suma de los notos de cuentas por
   * DEBE DE SER IGUAL A La Suma de los valores
   * de detfacturacion
   * Es un balance 
   */
   public function balanceMontos(){
      return $this->montoFacturado()-$this->montoTotal();
   }
   
   public function montoFacturado(){
      return  $this->detfacturacionQuery()->select('sum(monto)')->scalar();
   }
   public function detfacturacionQuery(){
      return SigiDetfacturacion::find()->where(['facturacion_id'=>$this->id]); 
   }
   /*
    * Citeriop de filtro del mes anterior*/
    
   private function previousQuery(){
      
        $mesprev=($this->mes=='1')?'12':(($this->mes-1).'');
        $anioPrev=($this->mes=='1')?(($this->ejercicio-1).''):$this->ejercicio;
      return $this->getSigiDetfacturacion()->where(['mes'=>$mesprev,'anio'=>$anioPrev]);
   }
   //nUMERO MAXIMO ANTEIROR DEL RECIBO , DONDE SE QUEDO
   private function numeroAnterior(){
       RETURN $this->previousQuery()->max(numero);
   }
   
   private function asignaNumero(){
       $mes= str_pad( $this->mes , 2,  "0",STR_PAD_LEFT);       
      $depas=array_column($this->getSigiDetfacturacion()->select('grupofacturacion')->distinct()->orderBy('grupofacturacion ASC')->asArray()->all(),'grupofacturacion');
     $contador=1;
      foreach($depas as $key=>$depa){
          $numero=$this->ejercicio.'-'.$mes.'-'.str_pad( $contador.'' , 3,  "0",STR_PAD_LEFT);      
          SigiDetfacturacion::updateAll(['numerorecibo'=>$numero],['grupofacturacion'=>$depa,'facturacion_id'=>$this->id]);
          $contador++;
      }
   }
   
   
    public function validateFechas($attribute, $params)
    {
      // $this->toCarbon('fecingreso');
       //$this->toCarbon('cumple');
       //self::CarbonNow();
       //var_dump(self::CarbonNow());
        
       if($this->toCarbon('fecha')->greaterThan($this->toCarbon('fvencimiento'))){
            $this->addError('fvencimiento', yii::t('base.errors','La fecha  {campo} es una fecha anterior a la fecha emisión',
                    ['campo'=>$this->getAttributeLabel('fvencimiento')]));
       }
     
    }
 
    
  public function beforeSave($insert){
      if($insert){
          
      }
      return parent::beforeSave($insert);
  }
  
  /*
   * Funcio que obtiene el registro unico para 
   * recolectar las cobranzas de los departamenteos
   * afiliados de la inmobiliaria 
   */
  private function hasKardexDepaComun(){
      if(empty($this->unidad_id))
      throw new ServerErrorHttpException(Yii::t('base.errors', 'No ha especificado la unidad general para  cobranza masiva'));
 return SigiKardexdepa::find()->where([
      'edificio_id'=>$this->edificio,
      'unidad_id'=>$this->unidad_id,
      'facturacion_id'=>$this->id,
      ])->one();
      
  }
  
  private function hasKardexDepa($unidad_id){
      return SigiKardexdepa::find()->where([
      'edificio_id'=>$this->edificio,
      'unidad_id'=>$unidad_id,
      'facturacion_id'=>$this->id,
      ])->one();
      
  }
  
  private function kardexDepaComun(){
      $registro=$this->hasKardexDepaComun();
    if(is_null($registro)){
        $attributes=[
        'edificio_id'=>$this->edificio_id,
        'unidad_id'=>$this->unidad_id,
        'facturacion_id'=>$this->id,
        'mes'=>$this->mes,
        'anio'=>$this->ejercicio,
        'fecha'=>$this->fecha, ];
     $modelo=New SigiKardexdepa();
     $modelo->setAttributes($attributes);
      if($modelo->save()){
          //var_dump('0k');die();
      }else{
        var_dump($modelo->getErrors());die();  
      }
      return $modelo;
    }else{
      return $registro;  
    }
    
  }
  
    private function kardexDepa($unidad_id){  
         $registro=$this->hasKardexDepa($unidad_id);
    if(is_null($registro)){
        $attributes=[
        'edificio_id'=>$this->edificio_id,
        'unidad_id'=>$unidad_id,
        'facturacion_id'=>$this->id,
        'mes'=>$this->mes,
        'anio'=>$this->ejercicio,
        'fecha'=>$this->fecha, ];
     $modelo=New SigiKardexdepa();
     $modelo->setAttributes($attributes);
      if($modelo->save()){
          //var_dump('0k');die();
      }else{
        var_dump($modelo->getErrors());die();  
      }
      return $modelo;
    }else{
      return $registro;  
    }
  }
  
  public function hasCobranzaMasiva(){
      $valor=false;
     foreach($this->edificio->apoderados as $apoderado){
         if(!$apoderado->cobranzaindividual && $apoderado->hasDepasImputables()){
            $valor=true; break; 
         }
    }
    return $valor;
  }
  
  /*Facturacion sin nmucho detalle */
  public function shortFactu(){
     $unidades= $this->edificio->unidadesImputablesPadres();
     $hasCobranzaMasiva=$this->hasCobranzaMasiva();
     

     if($hasCobranzaMasiva){
       //Obteniendo la unidad Grupal
        
      $kardexGrupal=$this->kardexDepaComun();
       $kardexGrupal->refresh();  
     }
      
     foreach($unidades as $unidad){
       
         if($hasCobranzaMasiva){
                  if($unidad->miApoderado()->cobranzaindividual){
                      $modeltemp=$this->kardexDepa($unidad->id);
                       $identidad=$modeltemp->id; unset($modeltemp);
          
                     }else{
                        $identidad=$kardexGrupal->id;  
                  } 
         }else{
                     $modeltemp=$this->kardexDepa($unidad->id);
                     $identidad=$modeltemp->id; unset($modeltemp);
         }
         
       
       
        foreach($this->sigiCuentaspor as $cuenta){
            $colector=$cuenta->colector;
           if($colector->isMassive()){
             if($colector->isMedidor()){
                 $medidor=$unidad->firstMedidor($colector->tipomedidor);
                 $participacion=$medidor->participacionRead($cuenta->mes,$cuenta->anio);
                 //yii::error('partici medidor  '.$participacion);
                $monto=round($participacion*$cuenta->monto,6);
                 /***insertar un registrio****/
                if(!$cuenta->existsDetalleFacturacion($unidad,$colector,false))
                 $cuenta->insertaRegistro($identidad,$unidad,$medidor,$monto,'0',$participacion);
                 /*****************************/
                 // yii::error('partici unidada  '.$unidad->porcWithChilds());
                     $monto=0;
                     /******Recorreidno los medidores de aareas comunes*/
                         foreach($this->edificio->medidoresAaCc() as $medidorAACC){
                             $participacionAACC=$medidorAACC->participacionRead($cuenta->mes,$cuenta->anio);
                             $monto=$monto+round($participacionAACC //el porc d ecomsumo
                                     *$unidad->porcWithChilds() //por la participacion 
                                     *$cuenta->monto,10); ///el monto totañl
                         }
                 
                 /***insertar un registrio  por todfas las sumas de las lecturas****/
                  if(!$cuenta->existsDetalleFacturacion($unidad,$colector,true))
                  $cuenta->insertaRegistro($identidad,$unidad,null,$monto,'1',$participacionAACC //el porc d ecomsumo
                                     *$unidad->porcWithChilds());
                 /*****************************/
                 
                 
                 
                }else{
                   
                $monto=round($unidad->porcWithChilds()*$cuenta->monto,10);
                
                /***insertar un registrio****/
                if(!$cuenta->existsDetalleFacturacion($unidad,$colector,false))
                  $cuenta->insertaRegistro($identidad,$unidad,null,$monto,'0',$unidad->porcWithChilds());
                 /*****************************/
                 
                   }
                }else{
                   /*Si es un cobro uindividual aplicar aqui*/
                   if($cuenta->unidad_id>0 && $cuenta->unidad_id==$unidad->id) {
                       /***insertar un registrio****/
                       if(!$cuenta->existsDetalleFacturacion($unidad,$colector,false))
                    $cuenta->insertaRegistro($identidad,$unidad,null,$monto,'1',1);
                      /*****************************/
                 
                 
                        }
                 }
            
        } 
     }         
  }
  
  
  
  
   
}
