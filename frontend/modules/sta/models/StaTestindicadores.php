<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\models\StaPercentiles;
use Yii;

/**
 * This is the model class for table "{{%sta_testindicadores}}".
 *
 * @property int $id
 * @property string $codtest
 * @property string $grupo
 * @property string $nombre
 * @property string $texto_bajo
 * @property string $texto_medio
 * @property string $texto_alto
 *
 * @property StaTest $codtest0
 */
class StaTestindicadores extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_testindicadores}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codtest', 'grupo', 'nombre'], 'required'],
            [['texto_bajo', 'texto_medio', 'texto_alto'], 'string'],
            [['codtest'], 'string', 'max' => 8],
             [['nombre','grupo','nemonico'], 'safe'],
            [['grupo'], 'string', 'max' => 2],
            [['nombre'], 'string', 'max' => 60],
            [['codtest'], 'exist', 'skipOnError' => true, 'targetClass' => Test::className(), 'targetAttribute' => ['codtest' => 'codtest']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'codtest' => Yii::t('sta.labels', 'Codtest'),
            'grupo' => Yii::t('sta.labels', 'Grupo'),
            'nombre' => Yii::t('sta.labels', 'Nombre'),
            'texto_bajo' => Yii::t('sta.labels', 'Texto Bajo'),
            'texto_medio' => Yii::t('sta.labels', 'Texto Medio'),
            'texto_alto' => Yii::t('sta.labels', 'Texto Alto'),
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
     * {@inheritdoc}
     * @return StaTestindicadoresQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaTestindicadoresQuery(get_called_class());
    }
    
    public function interpretacion($categoria){
        if($categoria== StaPercentiles::CALIFICACION_BAJO){
           return $this->texto_bajo; 
        }elseif($categoria==StaPercentiles::CALIFICACION_PROMEDIO){
             return $this->texto_medio; 
        }
        elseif($categoria==StaPercentiles::CALIFICACION_ALTO){
             return $this->texto_alto; 
        }else{
            return '--';
        }
        
    }
}
