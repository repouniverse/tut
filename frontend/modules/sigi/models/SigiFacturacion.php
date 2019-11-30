<?php

namespace frontend\modules\sigi\models;

use Yii;

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSigiDetfacturacions()
    {
        return $this->hasMany(SigiDetfacturacion::className(), ['facturacion_id' => 'id']);
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
}
