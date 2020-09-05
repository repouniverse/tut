<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%vw_sta_eventos}}".
 *
 * @property int $id
 * @property int $eventos_id
 * @property int $talleresdet_id
 * @property int $talleres_id
 * @property string $codalu
 * @property string $asistio
 * @property string $nombres
 * @property string $detalle
 * @property string $codfac
 * @property string $correo
 * @property string $celulares
 * @property string $clase
 * @property string $numerocita
 * @property string $libre
 * @property int $current_sesion
 * @property string $codcar
 * @property string $fechaprog
 * @property string $numero
 * @property string $proceso
 * @property int $tipo
 * @property string $status
 * @property string $codperiodo
 */
class VwStaEventos extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_sta_eventos}}';
    }
public $fechaprog1;
 public $dateorTimeFields=['fechaprog'=>self::_FDATETIME,
        'fechaprog1'=>self::_FDATETIME];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'eventos_id', 'talleresdet_id', 'talleres_id', 'current_sesion', 'tipo'], 'integer'],
            [['eventos_id', 'talleresdet_id', 'talleres_id', 'codalu', 'asistio', 'nombres', 'fechaprog', 'numero', 'proceso'], 'required'],
            [['detalle'], 'string'],
            [['codalu'], 'string', 'max' => 14],
            [['asistio', 'clase', 'libre', 'status'], 'string', 'max' => 1],
            [['nombres', 'correo'], 'string', 'max' => 60],
            [['codfac', 'numero'], 'string', 'max' => 8],
            [['celulares'], 'string', 'max' => 20],
            [['numerocita'], 'string', 'max' => 10],
            [['codcar'], 'string', 'max' => 4],
            [['fechaprog'], 'string', 'max' => 19],
            [['proceso'], 'string', 'max' => 40],
            [['codperiodo'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.labels', 'ID'),
            'eventos_id' => Yii::t('base.labels', 'Eventos ID'),
            'talleresdet_id' => Yii::t('base.labels', 'Talleresdet ID'),
            'talleres_id' => Yii::t('base.labels', 'Talleres ID'),
            'codalu' => Yii::t('base.labels', 'Codalu'),
            'asistio' => Yii::t('base.labels', 'Asistio'),
            'nombres' => Yii::t('base.labels', 'Nombres'),
            'detalle' => Yii::t('base.labels', 'Detalle'),
            'codfac' => Yii::t('base.labels', 'Codfac'),
            'correo' => Yii::t('base.labels', 'Correo'),
            'celulares' => Yii::t('base.labels', 'Celulares'),
            'clase' => Yii::t('base.labels', 'Clase'),
            'numerocita' => Yii::t('base.labels', 'Numerocita'),
            'libre' => Yii::t('base.labels', 'Libre'),
            'current_sesion' => Yii::t('base.labels', 'Current Sesion'),
            'codcar' => Yii::t('base.labels', 'Codcar'),
            'fechaprog' => Yii::t('base.labels', 'Fechaprog'),
            'numero' => Yii::t('base.labels', 'Numero'),
            'proceso' => Yii::t('base.labels', 'Proceso'),
            'tipo' => Yii::t('base.labels', 'Tipo'),
            'status' => Yii::t('base.labels', 'Status'),
            'codperiodo' => Yii::t('base.labels', 'Codperiodo'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwStaEventosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwStaEventosQuery(get_called_class());
    }
    
    public function getEventoDetalle(){
         RETURN StaEventosdet::findOne($this->id);
    }
    
    public static function except(){
      return self::find()->andWhere(['<>','status', Aluriesgo::FLAG_RETIRADO]);
  }
    
}
