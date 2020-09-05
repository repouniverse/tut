<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\models\StaPercentiles;
use Yii;

/**
 * This is the model class for table "{{%sta_resultados}}".
 *
 * @property int $id
 * @property int $indicador_id
 * @property int $examen_id
 * @property int $puntaje_total
 * @property int $percentil
 * @property string $categoria
 * @property string $interpretacion
 *
 * @property StaTestindicadores $indicador
 * @property StaExamenes $examen
 */
class StaResultados extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_resultados}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['indicador_id', 'examen_id'], 'required'],
            [['indicador_id', 'examen_id', 'puntaje_total', 'percentil'], 'integer'],
            [['interpretacion'], 'string'],
            [['codfac','codperiodo','flujo_id','status'], 'safe'],
            [['categoria'], 'string', 'max' => 10],
            [['indicador_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaTestindicadores::className(), 'targetAttribute' => ['indicador_id' => 'id']],
            [['examen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Examenes::className(), 'targetAttribute' => ['examen_id' => 'id']],
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
            'examen_id' => Yii::t('sta.labels', 'Examen ID'),
            'puntaje_total' => Yii::t('sta.labels', 'Puntaje Total'),
            'percentil' => Yii::t('sta.labels', 'Percentil'),
            'categoria' => Yii::t('sta.labels', 'Categoria'),
            'interpretacion' => Yii::t('sta.labels', 'Interpretacion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicador()
    {
        return $this->hasOne(StaTestindicadores::className(), ['id' => 'indicador_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExamen()
    {
        return $this->hasOne(Examenes::className(), ['id' => 'examen_id']);
    }

    /**
     * {@inheritdoc}
     * @return StaResultadosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaResultadosQuery(get_called_class());
    }
    
    public function color(){
         if($this->categoria== StaPercentiles::CALIFICACION_BAJO){
           return 'red'; 
        }elseif($this->categoria==StaPercentiles::CALIFICACION_PROMEDIO){
             return 'orange'; 
        }
        elseif($this->categoria==StaPercentiles::CALIFICACION_ALTO){
             return '#61de61'; 
        }else{
            return '--';
        }
        
    }
}
