<?php

namespace frontend\modules\sigi\models;
use frontend\modules\sigi\models\SigiCuentaspor;
use Yii;
USE yii\data\ActiveDataProvider;
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
   
    public $hardFields=['edificio_id','mes','ejercicio'];
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
            [['edificio_id', 'mes', 'descripcion'], 'required'],
            [['edificio_id'], 'integer'],
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
    
    public function generateFacturacionMes(){
        $errores=[];
        
        if($this->isCompleteReadsSuministros()){
          foreach($this->sigiCuentaspor as $cuentapor){
            $errores['error']=$cuentapor->generateFacturacion();
          }  
        }else{
           $errores['error']=yii::t('sigi.errors','Hay suministros que aun no tienen lectura verifique por favor'); 
        }
       $this->asignaIdentidad();//Importante
        
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
    /*Verifica que todos los medidores tengan su lectura*/
    public function isCompleteReadsSuministros(){
        $iscomplete=true;
        $tipomedidores=$this->edificio->typeMedidores();
    foreach($tipomedidores as $key=>$type){
        $nlecturas=SigiLecturas::find()->where(
                ['edificio_id'=>$this->edificio_id,
                    'mes'=>$this->mes,
                    //'tipo'=>$type
                ])->count();
       
      if($nlecturas ==0){
          $iscomplete=false; 
        break;   
      }  
        $nmedidores=$this->edificio->nMedidores($type);       
          if(($nlecturas % $nmedidores) <> 0) //Si las cantidades SON multiplos de la cantidad de medidores entonces OK           
          {
             $iscomplete=false; 
           break;     
          }
        
           }
    return $iscomplete;
      
          }
    
    /*Dataprovider de los mediores que faltan lecturas*/
    public function providerFaltaLecturas($type){
       $idsMedidores=$this->edificio->idsMedidores($type);
       
        yii::error('metiendonos en le data provider');
        $fechas=array_column(SigiLecturas::find()->select('flectura')->distinct()
                ->where([
                    'edificio_id'=>$this->edificio_id,
                    'mes'=>$this->mes,
                    //'tipo'=>$type
                        ])->asArray()->all(),'flectura');
        $idsFaltan=[];
        foreach($fechas as $index=>$fecha){
            $idsConLecturas=array_column(SigiLecturas::find()->select('suministro_id')
                ->where([
                    'edificio_id'=>$this->edificio_id,
                    'mes'=>$this->mes,
                     'flectura'=>$fecha,
                   // 'tipo'=>$type
                        ])->andWhere(['in','suministro_id',$idsMedidores])->asArray()->all(),'suministro_id');
             
                $idsTotales=$this->edificio->idsMedidores($type);
                $idsFaltan= $idsFaltan+array_diff($idsTotales, $idsConLecturas);
        }
        //yii::error($idsTotales);
        //yii::error($idsConLecturas);
        //yii::error($idsFaltan);
        $query= SigiSuministros::find()->where(['in','id',array_keys($idsFaltan)]);        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
        return $dataProvider;
    }
}
