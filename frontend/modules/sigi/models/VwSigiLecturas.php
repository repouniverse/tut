<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%vw_sigi_lecturastemp}}".
 *
 * @property int $id
 * @property int $suministro_id
 * @property int $edificio_id
 * @property int $unidad_id
 * @property int $cuentaspor_id
 * @property string $codtipo
 * @property string $codedificio
 * @property string $anio
 * @property string $delta
 * @property string $codepa
 * @property int $user_id
 * @property string $lecturaant
 * @property string $lectura
 * @property string $flectura
 * @property string $codsuministro
 * @property string $numerocliente
 * @property string $codum
 * @property string $numero
 * @property string $nombre
 * @property string $codigo
 */
class VwSigiLecturas extends  \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_sigi_lecturas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'suministro_id', 'edificio_id', 'unidad_id', 'cuentaspor_id'], 'integer'],
            //[['suministro_id', 'unidad_id', 'anio', 'codum', 'numero', 'nombre'], 'required'],
            [['delta', 'lecturaant', 'lectura'], 'number'],
            [['codtipo'], 'string', 'max' => 3],
            [['codedificio', 'codepa', 'codsuministro', 'numero'], 'string', 'max' => 12],
            [['anio', 'codum'], 'string', 'max' => 4],
            [['flectura'], 'string', 'max' => 10],
            [['numerocliente', 'nombre'], 'string', 'max' => 25],
            [['codigo'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'suministro_id' => Yii::t('sigi.labels', 'Suministro ID'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad ID'),
            'cuentaspor_id' => Yii::t('sigi.labels', 'Cuentaspor ID'),
            'codtipo' => Yii::t('sigi.labels', 'Codtipo'),
            'codedificio' => Yii::t('sigi.labels', 'Codedificio'),
            'anio' => Yii::t('sigi.labels', 'Anio'),
            'delta' => Yii::t('sigi.labels', 'Delta'),
            'codepa' => Yii::t('sigi.labels', 'Codepa'),
            //'user_id' => Yii::t('sigi.labels', 'User ID'),
            'lecturaant' => Yii::t('sigi.labels', 'Lecturaant'),
            'lectura' => Yii::t('sigi.labels', 'Lectura'),
            'flectura' => Yii::t('sigi.labels', 'Flectura'),
            'codsuministro' => Yii::t('sigi.labels', 'Codsuministro'),
            'numerocliente' => Yii::t('sigi.labels', 'Numerocliente'),
            'codum' => Yii::t('sigi.labels', 'Codum'),
            'numero' => Yii::t('sigi.labels', 'Numero'),
            'nombre' => Yii::t('sigi.labels', 'Nombre'),
            'codigo' => Yii::t('sigi.labels', 'Codigo'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwSigiTempLecturasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwSigiLecturasQuery(get_called_class());
    }
}
