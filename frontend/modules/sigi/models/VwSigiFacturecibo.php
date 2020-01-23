<?php

namespace frontend\modules\sigi\models;
use frontend\modules\sigi\models\SigiUnidades;
use Yii;

/**
 * This is the model class for table "{{%vw_sigi_facturecibo}}".
 *
 * @property int $id
 * @property int $cuentaspor_id
 * @property int $edificio_id
 * @property int $unidad_id
 * @property int $colector_id
 * @property int $grupo_id
 * @property string $monto
 * @property string $igv
 * @property string $grupounidad agrupa  todos los objetos: cochera, depositos  en el mismo departamento  
 * @property string $grupofacturacion Agrupa el documento del recibo, ojo lo hace por departametno o apoderado, MUY IMPORTANTES 
 * @property int $facturacion_id
 * @property int $mes
 * @property string $anio
 * @property int $identidad
 * @property string $fecha
 * @property string $descripcion
 * @property string $detalles
 * @property string $nombreedificio
 * @property string $codigo
 * @property string $direccion
 * @property string $numero
 * @property string $nombre
 * @property string $area
 * @property string $participacion
 * @property string $descargo
 * @property string $codcargo
 * @property string $codgrupo
 * @property string $desgrupo
 * @property string $numerodepa
 * @property string $nombredepa
 * @property string $areadepa
 * @property string $participaciondepa
 */
class VwSigiFacturecibo extends \common\models\base\modelBase
{
    public $extraMethodsToReport=['reportGrafico','reportAreas','reportLecturaAnt','reportPropietarios'];
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_sigi_facturecibo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cuentaspor_id', 'edificio_id', 'unidad_id', 'colector_id', 'grupo_id', 'facturacion_id', 'mes', 'identidad'], 'integer'],
            [['cuentaspor_id', 'edificio_id', 'unidad_id', 'colector_id', 'grupo_id', 'monto', 'igv', 'grupounidad', 'grupofacturacion', 'facturacion_id', 'mes', 'anio', 'descripcion', 'nombreedificio', 'direccion', 'numero', 'nombre', 'descargo', 'codcargo', 'codgrupo', 'numerodepa', 'nombredepa'], 'required'],
            [['monto', 'igv', 'area', 'participacion', 'areadepa', 'participaciondepa'], 'number'],
            //[['particiapcion','codsuministro',''], 'string'],
            [['grupounidad', 'grupofacturacion', 'numero', 'numerodepa'], 'string', 'max' => 12],
            [['anio', 'codcargo'], 'string', 'max' => 4],
            [['fecha'], 'string', 'max' => 10],
            [['descripcion', 'descargo', 'desgrupo'], 'string', 'max' => 40],
            [['nombreedificio'], 'string', 'max' => 60],
            [['codigo'], 'string', 'max' => 8],
            [['direccion'], 'string', 'max' => 100],
            [['nombre', 'nombredepa'], 'string', 'max' => 25],
            [['codgrupo'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'cuentaspor_id' => Yii::t('sigi.labels', 'Cuentaspor ID'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad ID'),
            'colector_id' => Yii::t('sigi.labels', 'Colector ID'),
            'grupo_id' => Yii::t('sigi.labels', 'Grupo ID'),
            'monto' => Yii::t('sigi.labels', 'Monto'),
            'igv' => Yii::t('sigi.labels', 'Igv'),
            'grupounidad' => Yii::t('sigi.labels', 'Grupounidad'),
            'grupofacturacion' => Yii::t('sigi.labels', 'Grupofacturacion'),
            'facturacion_id' => Yii::t('sigi.labels', 'Facturacion ID'),
            'mes' => Yii::t('sigi.labels', 'Mes'),
            'anio' => Yii::t('sigi.labels', 'Anio'),
            'identidad' => Yii::t('sigi.labels', 'Identidad'),
            'fecha' => Yii::t('sigi.labels', 'Fecha'),
            'descripcion' => Yii::t('sigi.labels', 'Descripcion'),
            'detalles' => Yii::t('sigi.labels', 'Detalles'),
            'nombreedificio' => Yii::t('sigi.labels', 'Nombreedificio'),
            'codigo' => Yii::t('sigi.labels', 'Codigo'),
            'direccion' => Yii::t('sigi.labels', 'Direccion'),
            'numero' => Yii::t('sigi.labels', 'Numero'),
            'nombre' => Yii::t('sigi.labels', 'Nombre'),
            'area' => Yii::t('sigi.labels', 'Area'),
            'participacion' => Yii::t('sigi.labels', 'Participacion'),
            'descargo' => Yii::t('sigi.labels', 'Descargo'),
            'codcargo' => Yii::t('sigi.labels', 'Codcargo'),
            'codgrupo' => Yii::t('sigi.labels', 'Codgrupo'),
            'desgrupo' => Yii::t('sigi.labels', 'Desgrupo'),
            'numerodepa' => Yii::t('sigi.labels', 'Numerodepa'),
            'nombredepa' => Yii::t('sigi.labels', 'Nombredepa'),
            'areadepa' => Yii::t('sigi.labels', 'Areadepa'),
            'participaciondepa' => Yii::t('sigi.labels', 'Participaciondepa'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwSigiFactureciboQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwSigiFactureciboQuery(get_called_class());
    }
    
    public function getReportAreas(){        
        
      $controller=Yii::$app->controller;
        $nameView= \common\helpers\FileHelper::getShortName($this::className());
        $pathView='/'.$controller->id.'/reports/'.$nameView.'/detalleAreas';
       return  $controller->getView()->render($pathView,['areas'=>$this->unidad->arrayParticipaciones()]);
    }
   public function getReportPropietarios(){        
        
      $controller=Yii::$app->controller;
        $nameView= \common\helpers\FileHelper::getShortName($this::className());
        $pathView='/'.$controller->id.'/reports/'.$nameView.'/propietarios';
       return  $controller->getView()->render($pathView,['propietarios'=>$this->unidad->arrayPropietarios()]);
    }
   public function getReportGrafico(){ 
       
       $suministro=SigiSuministros::findOne(['unidad_id'=>$this->unidad_id]);
      if(!is_null($suministro)) {
        if(!$suministro->hasAfiliados()){
           $lecturas=$suministro->lastReads(); 
        $controller=Yii::$app->controller;
        $nameView= \common\helpers\FileHelper::getShortName($this::className());
        $pathView='/'.$controller->id.'/reports/'.$nameView.'/_grafico';
       
          return  $controller->getView()->render($pathView,['lecturas'=>$lecturas ]);
        
        }
        
      } else{
          return 'No hay Medidores';
      }
      }
    
     public function getReportLecturaAnt(){        
      return $this->lectura-$this->delta;
    }
    public function getUnidad()
    {
         
        return $this->hasOne(SigiUnidades::className(), ['id' => 'unidad_id']);
    }
    public function getSuministro()
    {
         
        
    }
    
    
    
}
