<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_detfacturacion}}".
 *
 * @property int $id
 * @property int $facturacion_id
 * @property int $cargosedificio_id
 * @property string $monto
 * @property string $codocu
 * @property string $femision
 * @property string $fecha
 * @property string $numero
 * @property string $descripcion
 * @property int $unidad_id
 * @property string $detalles
 *
 * @property SigiCargosedificio $cargosedificio
 * @property SigiFacturacion $facturacion
 */
class SigiDetfacturacion extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_detfacturacion}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['facturacion_id', 'cargosedificio_id', 'codocu', 'descripcion'], 'required'],
            [['facturacion_id', 'cargosedificio_id', 'unidad_id'], 'integer'],
            [['monto'], 'number'],
            [['anio','mes'], 'safe'],
            [['detalles'], 'string'],
            [['codocu'], 'string', 'max' => 3],
            [['femision', 'fecha'], 'string', 'max' => 10],
            [['numero'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 40],
            [['cargosedificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCargosedificio::className(), 'targetAttribute' => ['cargosedificio_id' => 'id']],
            [['facturacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiFacturacion::className(), 'targetAttribute' => ['facturacion_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'facturacion_id' => Yii::t('sigi.labels', 'Facturacion ID'),
            'cargosedificio_id' => Yii::t('sigi.labels', 'Cargosedificio ID'),
            'monto' => Yii::t('sigi.labels', 'Monto'),
            'codocu' => Yii::t('sigi.labels', 'Codocu'),
            'femision' => Yii::t('sigi.labels', 'Femision'),
            'fecha' => Yii::t('sigi.labels', 'Fecha'),
            'numero' => Yii::t('sigi.labels', 'Numero'),
            'descripcion' => Yii::t('sigi.labels', 'Descripcion'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad ID'),
            'detalles' => Yii::t('sigi.labels', 'Detalles'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargosedificio()
    {
        return $this->hasOne(SigiCargosedificio::className(), ['id' => 'cargosedificio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturacion()
    {
        return $this->hasOne(SigiFacturacion::className(), ['id' => 'facturacion_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiDetfacturacionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiDetfacturacionQuery(get_called_class());
    }
    
   
}
