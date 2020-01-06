<?php

namespace frontend\modules\sigi\models;

use Yii;

class SigiVwPapeletas extends \common\models\base\modelBase
{
   
     public $extraMethodsToReport=['reportPropietario'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_sigi_papeletas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'edificio_id', 'colector_id', 'mes', 'unidad_id'], 'integer'],
            [['edificio_id', 'codocu', 'numerodoc', 'descripcion', 'codpro', 'mes', 'anio', 'monto', 'codestado', 'nombre', 'direccion', 'desdocu', 'despro', 'rucpro', 'descargo'], 'required'],
            [['detalle'], 'string'],
            [['monto'], 'number'],
            [['codocu', 'codmon'], 'string', 'max' => 3],
            [['numerodoc'], 'string', 'max' => 20],
            [['descripcion', 'descripciongrupo', 'descargo'], 'string', 'max' => 40],
            [['codpro'], 'string', 'max' => 6],
            [['fedoc', 'fevenc', 'igv', 'codestado'], 'string', 'max' => 10],
            [['anio'], 'string', 'max' => 4],
            [['nombre', 'desdocu', 'despro'], 'string', 'max' => 60],
            [['direccion'], 'string', 'max' => 100],
            [['codigo'], 'string', 'max' => 8],
            [['rucpro'], 'string', 'max' => 15],
            [['numero'], 'string', 'max' => 12],
            [['nombredepa'], 'string', 'max' => 25],
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
            'codocu' => Yii::t('sigi.labels', 'Codocu'),
            'numerodoc' => Yii::t('sigi.labels', 'Numerodoc'),
            'descripcion' => Yii::t('sigi.labels', 'Descripcion'),
            'codpro' => Yii::t('sigi.labels', 'Codpro'),
            'fedoc' => Yii::t('sigi.labels', 'Fedoc'),
            'colector_id' => Yii::t('sigi.labels', 'Colector ID'),
            'mes' => Yii::t('sigi.labels', 'Mes'),
            'anio' => Yii::t('sigi.labels', 'Anio'),
            'detalle' => Yii::t('sigi.labels', 'Detalle'),
            'fevenc' => Yii::t('sigi.labels', 'Fevenc'),
            'monto' => Yii::t('sigi.labels', 'Monto'),
            'igv' => Yii::t('sigi.labels', 'Igv'),
            'codestado' => Yii::t('sigi.labels', 'Codestado'),
            'codmon' => Yii::t('sigi.labels', 'Codmon'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad ID'),
            'nombre' => Yii::t('sigi.labels', 'Nombre'),
            'direccion' => Yii::t('sigi.labels', 'Direccion'),
            'codigo' => Yii::t('sigi.labels', 'Codigo'),
            'desdocu' => Yii::t('sigi.labels', 'Desdocu'),
            'despro' => Yii::t('sigi.labels', 'Despro'),
            'rucpro' => Yii::t('sigi.labels', 'Rucpro'),
            'numero' => Yii::t('sigi.labels', 'Numero'),
            'nombredepa' => Yii::t('sigi.labels', 'Nombredepa'),
            'descripciongrupo' => Yii::t('sigi.labels', 'Descripciongrupo'),
            'descargo' => Yii::t('sigi.labels', 'Descargo'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return SigiVwPapeletasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiVwPapeletasQuery(get_called_class());
    }
    
     public  function getReportPropietario()
    {
         $unidad=SigiUnidades::findOne($this->unidad_id)->currentPropietario();
         
        return is_null($unidad)?'':$unidad->nombre ;
    }
}
