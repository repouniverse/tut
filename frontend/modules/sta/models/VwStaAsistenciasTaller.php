<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%vw_sta_asistenciastaller}}".
 *
 * @property int $asistencias
 * @property int $id
 * @property int $secuencia
 * @property int $tipo
 * @property string $proceso
 * @property string $numero
 * @property string $fecha
 * @property string $codfac
 * @property string $codperiodo
 * @property string $clase
 */
class VwStaAsistenciasTaller extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_sta_asistenciastaller}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['asistencias', 'id', 'secuencia', 'tipo'], 'integer'],
            [['proceso', 'numero'], 'required'],
            [['proceso'], 'string', 'max' => 40],
            [['numero', 'codfac'], 'string', 'max' => 8],
            [['fecha'], 'string', 'max' => 19],
            [['codperiodo'], 'string', 'max' => 6],
            [['clase'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'asistencias' => Yii::t('base.labels', 'Asistencias'),
            'id' => Yii::t('base.labels', 'ID'),
            'secuencia' => Yii::t('base.labels', 'Secuencia'),
            'tipo' => Yii::t('base.labels', 'Tipo'),
            'proceso' => Yii::t('base.labels', 'Proceso'),
            'numero' => Yii::t('base.labels', 'Numero'),
            'fecha' => Yii::t('base.labels', 'Fecha'),
            'codfac' => Yii::t('base.labels', 'Codfac'),
            'codperiodo' => Yii::t('base.labels', 'Codperiodo'),
            'clase' => Yii::t('base.labels', 'Clase'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwStaAsistenciasTallerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwStaAsistenciasTallerQuery(get_called_class());
    }
    
    public function totalConvocados(){
       return StaEventosdet::find()->andWhere([
          'eventos_id'=>$this->idevento  
        ])->count();
    }
}
