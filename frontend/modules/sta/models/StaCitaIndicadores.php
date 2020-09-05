<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%sta_cita_indicadores}}".
 *
 * @property int $id
 * @property string $codfac
 * @property int $citas_id
 * @property int $talleresdet_id
 * @property string $detalles
 * @property int $relevancia
 *
 * @property StaTalleresdet $talleresdet
 * @property StaCitas $citas
 */
class StaCitaIndicadores extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_cita_indicadores}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codfac', 'citas_id', 'talleresdet_id','indicador_id'], 'required'],
            [['citas_id', 'talleresdet_id', 'relevancia'], 'integer'],
            [['detalles'], 'string'],
             [['indicador_id','clase'], 'safe'],
            [['codfac'], 'string', 'max' => 8],
            [['talleresdet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleresdet::className(), 'targetAttribute' => ['talleresdet_id' => 'id']],
            [['citas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Citas::className(), 'targetAttribute' => ['citas_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'codfac' => Yii::t('sta.labels', 'Codfac'),
            'citas_id' => Yii::t('sta.labels', 'Citas ID'),
            'talleresdet_id' => Yii::t('sta.labels', 'Talleresdet ID'),
            'detalles' => Yii::t('sta.labels', 'Detalles'),
            'relevancia' => Yii::t('sta.labels', 'Relevancia'),
        ];
    }

    /**
     * Gets query for.
     *
     * 
     */
    public function getTalleresdet()
    {
        return $this->hasOne(Talleresdet::className(), ['id' => 'talleresdet_id']);
    }

    /**
     * Gets query for.
     *
     * 
     */
    public function getCitas()
    {
        return $this->hasOne(Citas::className(), ['id' => 'citas_id']);
    }
 public function getIndicador()
    {
        return $this->hasOne(StaTestindicadores::className(), ['id' => 'indicador_id']);
    }

    /**
     * {@inheritdoc}
     * @return StaCitaIndicadoresQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaCitaIndicadoresQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
       parent::beforeSave($insert);
     $this->clase= \frontend\modules\sta\staModule::CLASE_RIESGO;
     return true;
    }
}
