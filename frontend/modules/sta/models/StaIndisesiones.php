<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%sta_indisesiones}}".
 *
 * @property int $id
 * @property string $codfac
 * @property int $sesiones_id
 * @property int $eventos_id
 * @property int $indicador_id
 * @property string $detalles
 * @property int $relevancia
 *
 * @property StaEventosSesiones $sesiones
 * @property StaEventos $eventos
 * @property StaTestindicadores $indicador
 */
class StaIndisesiones extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_indisesiones}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codfac', 'sesiones_id', 'eventos_id', 'indicador_id'], 'required'],
            [['sesiones_id', 'eventos_id', 'indicador_id', 'relevancia'], 'integer'],
             [['indicador_id','sesiones_id'],'unique','targetAttribute' => ['indicador_id','sesiones_id'], 'message'=>yii::t('sta.labels','Indicador ya ha sido utilizado')],
            [['detalles'], 'string'],
            [['codfac'], 'string', 'max' => 8],
            [['sesiones_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaEventosSesiones::className(), 'targetAttribute' => ['sesiones_id' => 'id']],
            [['eventos_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaEventos::className(), 'targetAttribute' => ['eventos_id' => 'id']],
            [['indicador_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaTestindicadores::className(), 'targetAttribute' => ['indicador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.labels', 'ID'),
            'codfac' => Yii::t('base.labels', 'Codfac'),
            'sesiones_id' => Yii::t('base.labels', 'Sesiones ID'),
            'eventos_id' => Yii::t('base.labels', 'Eventos ID'),
            'indicador_id' => Yii::t('base.labels', 'Indicador ID'),
            'detalles' => Yii::t('base.labels', 'Detalles'),
            'relevancia' => Yii::t('base.labels', 'Relevancia'),
        ];
    }

    /**
     * Gets query for.
     *
     * 
     */
    public function getSesion()
    {
        return $this->hasOne(StaEventosSesiones::className(), ['id' => 'sesiones_id']);
    }

    /**
     * Gets query for.
     *
     * 
     */
    public function getEvento()
    {
        return $this->hasOne(StaEventos::className(), ['id' => 'eventos_id']);
    }

    /**
     * Gets query for.
     *
     * 
     */
    public function getIndicador()
    {
        return $this->hasOne(StaTestindicadores::className(), ['id' => 'indicador_id']);
    }

    /**
     * {@inheritdoc}
     * @return StaIndisesionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaIndisesionesQuery(get_called_class());
    }
    
    
}
