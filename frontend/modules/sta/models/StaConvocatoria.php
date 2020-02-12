<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%sta_convocatoria}}".
 *
 * @property int $id
 * @property int $talleresdet_id
 * @property string $codfac
 * @property string $canal
 * @property string $resultado
 * @property string $detalle
 *
 * @property StaFacultades $codfac0
 * @property StaTalleresdet $talleresdet
 */
class StaConvocatoria extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    
    public $booleanFields=['resultado'];
    public $dateorTimeFields=[
        'fecha'=>self::_FDATE,
        'hora'=>self::_FHOUR];
    public static function tableName()
    {
        return '{{%sta_convocatoria}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['talleresdet_id'], 'integer'],
            [['codfac', 'canal'], 'required'],
            [['detalle'], 'string'],
             [['canal','fecha','resultado'], 'safe'], 
            [['codfac'], 'string', 'max' => 8],
            [['canal'], 'string', 'max' => 3],
           // [['resultado'], 'string', 'max' => 1],
            [['codfac'], 'exist', 'skipOnError' => true, 'targetClass' => Facultades::className(), 'targetAttribute' => ['codfac' => 'codfac']],
            [['talleresdet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleresdet::className(), 'targetAttribute' => ['talleresdet_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'talleresdet_id' => Yii::t('app', 'Talleresdet ID'),
            'codfac' => Yii::t('app', 'Codfac'),
            'canal' => Yii::t('app', 'Canal'),
            'resultado' => Yii::t('app', 'Respondió'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacultad()
    {
        return $this->hasOne(Facultades::className(), ['codfac' => 'codfac']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTalleresdet()
    {
        return $this->hasOne(Talleresdet::className(), ['id' => 'talleresdet_id']);
    }

    /**
     * {@inheritdoc}
     * @return StaConvocatoriaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaConvocatoriaQuery(get_called_class());
    }
}
