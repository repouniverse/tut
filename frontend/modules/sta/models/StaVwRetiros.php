<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%vw_sta_retiros}}".
 *
 * @property int $id
 * @property int $tallerdet_id
 * @property string $codalu
 * @property string $motivo
 * @property string $fecha
 * @property string $detalle
 * @property string $estado
 * @property string $codocu
 * @property string $codfac
 * @property string $codperiodo
 * @property string $descripcion
 * @property string $numero
 * @property string $ap
 * @property string $am
 * @property string $nombres
 * @property string $codcar
 */
class StaVwRetiros extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_sta_retiros}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tallerdet_id'], 'integer'],
            [['detalle'], 'string'],
            [['descripcion', 'numero'], 'required'],
            [['codalu'], 'string', 'max' => 14],
            [['motivo', 'codocu'], 'string', 'max' => 3],
            [['fecha'], 'string', 'max' => 10],
            [['estado'], 'string', 'max' => 1],
            [['codfac', 'codperiodo', 'codcar'], 'string', 'max' => 6],
            [['descripcion', 'ap', 'am', 'nombres'], 'string', 'max' => 40],
            [['numero'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'tallerdet_id' => Yii::t('sta.labels', 'Tallerdet ID'),
            'codalu' => Yii::t('sta.labels', 'Código'),
            'motivo' => Yii::t('sta.labels', 'Motivo'),
            'fecha' => Yii::t('sta.labels', 'Fecha'),
            'detalle' => Yii::t('sta.labels', 'Detalle'),
            'estado' => Yii::t('sta.labels', 'Estado'),
            'codocu' => Yii::t('sta.labels', 'Codocu'),
            'codfac' => Yii::t('sta.labels', 'Facultad'),
            'codperiodo' => Yii::t('sta.labels', 'Periodo'),
            'descripcion' => Yii::t('sta.labels', 'Descripcion'),
            'numero' => Yii::t('sta.labels', 'Número'),
            'ap' => Yii::t('sta.labels', 'Ap'),
            'am' => Yii::t('sta.labels', 'Am'),
            'nombres' => Yii::t('sta.labels', 'Nombres'),
            'codcar' => Yii::t('sta.labels', 'Espec.'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return StaVwRetirosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaVwRetirosQuery(get_called_class());
    }
}
