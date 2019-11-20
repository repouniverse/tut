<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_cargosedificio}}".
 *
 * @property int $id
 * @property int $edificio_id
 * @property int $cargo_id
 * @property string $tasamora
 * @property string $codgrupo
 * @property int $plazovencimiento
 * @property string $regular
 * @property string $montofijo
 * @property int $frecuencia
 * @property string $tipomedidor
 *
 * @property SigiEdificios $edificio
 * @property SigiCargosgrupoedificio $codgrupo0
 * @property SigiCargos $cargo
 */
class SigiCargosedificio extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_cargosedificio}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edificio_id', 'cargo_id', 'tasamora', 'grupo_id'], 'required'],
            [['edificio_id', 'cargo_id', 'plazovencimiento', 'frecuencia'], 'integer'],
            [['tasamora'], 'number'],
            [['codgrupo'], 'string', 'max' => 3],
            [['regular', 'montofijo', 'tipomedidor'], 'string', 'max' => 1],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
            [['codgrupo'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCargosgrupoedificio::className(), 'targetAttribute' => ['grupo_id' => 'id']],
            [['cargo_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCargos::className(), 'targetAttribute' => ['cargo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'edificio_id' => Yii::t('app', 'Edificio ID'),
            'cargo_id' => Yii::t('app', 'Cargo ID'),
            'tasamora' => Yii::t('app', 'Tasamora'),
            'codgrupo' => Yii::t('app', 'Codgrupo'),
            'plazovencimiento' => Yii::t('app', 'Plazovencimiento'),
            'regular' => Yii::t('app', 'Regular'),
            'montofijo' => Yii::t('app', 'Montofijo'),
            'frecuencia' => Yii::t('app', 'Frecuencia'),
            'tipomedidor' => Yii::t('app', 'Tipomedidor'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupo()
    {
        return $this->hasOne(SigiCargosgrupoedificio::className(), ['id' => 'grupo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargo()
    {
        return $this->hasOne(SigiCargos::className(), ['id' => 'cargo_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiCargosedificioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiCargosedificioQuery(get_called_class());
    }
}
