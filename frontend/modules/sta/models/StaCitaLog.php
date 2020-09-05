<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%sta_cita_log}}".
 *
 * @property int $id
 * @property int $citas_id
 * @property string $fecha
 * @property string $detalles
 *
 * @property StaCitas $citas
 */
class StaCitaLog extends \common\models\base\modelBase
{
    public $dateorTimeFields=[
        'fecha'=>self::_FDATETIME,
         'nuevafecha'=>self::_FDATETIME,
       
    ];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_cita_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['citas_id'], 'required'],
            [['citas_id'], 'integer'],
            [['detalles'], 'string'],
             [['nuevafecha'], 'safe'],
            [['fecha'], 'string', 'max' => 19],
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
            'citas_id' => Yii::t('sta.labels', 'Citas ID'),
            'fecha' => Yii::t('sta.labels', 'Fecha'),
            'detalles' => Yii::t('sta.labels', 'Detalles'),
        ];
    }

    /**
     * Gets query for.
     *
     * 
     */
    public function getCita()
    {
        return $this->hasOne(Citas::className(), ['id' => 'citas_id']);
    }

    /**
     * {@inheritdoc}
     * @return StaCitaLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaCitaLogQuery(get_called_class());
    }
}
