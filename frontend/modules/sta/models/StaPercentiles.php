<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%sta_percentiles}}".
 *
 * @property int $id
 * @property int $indicador_id
 * @property string $codtest
 * @property int $puntaje
 * @property int $percentil
 * @property string $categoria
 *
 * @property StaTest $codtest0
 * @property StaTestindicadores $indicador
 */
class StaPercentiles extends \common\models\base\modelBase
{
    const CALIFICACION_BAJO='BAJO';
    const CALIFICACION_PROMEDIO='PROMEDIO';
    const CALIFICACION_ALTO='ALTO';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_percentiles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['indicador_id', 'codtest', 'puntaje', 'percentil'], 'required'],
            [['indicador_id', 'puntaje', 'percentil'], 'integer'],
            [['codtest'], 'string', 'max' => 8],
            [['categoria'], 'string', 'max' => 10],
            [['codtest'], 'exist', 'skipOnError' => true, 'targetClass' => Test::className(), 'targetAttribute' => ['codtest' => 'codtest']],
            [['indicador_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaTestindicadores::className(), 'targetAttribute' => ['indicador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'indicador_id' => Yii::t('sta.labels', 'Indicador ID'),
            'codtest' => Yii::t('sta.labels', 'Codtest'),
            'puntaje' => Yii::t('sta.labels', 'Puntaje'),
            'percentil' => Yii::t('sta.labels', 'Percentil'),
            'categoria' => Yii::t('sta.labels', 'Categoria'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['codtest' => 'codtest']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicador()
    {
        return $this->hasOne(StaTestindicadores::className(), ['id' => 'indicador_id']);
    }

    /**
     * {@inheritdoc}
     * @return StaPercentilesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaPercentilesQuery(get_called_class());
    }
}
