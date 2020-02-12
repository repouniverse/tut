<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\models\Test;
use Yii;

/**
 * This is the model class for table "{{%sta_examenesdet}}".
 *
 * @property int $id
 * @property int $examenes_id
 * @property int $test_id
 * @property string $codfac
 * @property int $valor
 * @property string $detalles
 *
 * @property StaFacultades $codfac0
 * @property StaExamenes $examenes
 */
class StaExamenesdet extends \common\models\base\modelBase
{
    
    const SCENARIO_MIN='min';
    const SCENARIO_RESPUESTA='respuesta';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_examenesdet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['examenes_id', 'test_id', 'codfac', 'valor'], 'required'],
            [['examenes_id', 'test_id', 'valor'], 'integer'],
            [['detalles'], 'string'],
             [['codfac','valor','indicador_id'], 'safe'],
            [['codfac'], 'string', 'max' => 8],
            [['codfac'], 'exist', 'skipOnError' => true, 'targetClass' => Facultades::className(), 'targetAttribute' => ['codfac' => 'codfac']],
            [['examenes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Examenes::className(), 'targetAttribute' => ['examenes_id' => 'id']],
        ];
    }
 public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios[self::SCENARIO_MIN] = ['examenes_id','test_id','codfac','indicador_id'];
         $scenarios[self::SCENARIO_RESPUESTA] = ['valor','puntaje'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'examenes_id' => Yii::t('sta.labels', 'Examenes ID'),
            'test_id' => Yii::t('sta.labels', 'Test ID'),
            'codfac' => Yii::t('sta.labels', 'Codfac'),
            'valor' => Yii::t('sta.labels', 'Valor'),
            'detalles' => Yii::t('sta.labels', 'Detalles'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodfac0()
    {
        return $this->hasOne(Facultades::className(), ['codfac' => 'codfac']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExamen()
    {
        return $this->hasOne(Examenes::className(), ['id' => 'examenes_id']);
    }
    
    public function getTestdet()
    {
        return $this->hasOne(StaTestdet::className(), ['id' => 'test_id']);
    }

    /**
     * {@inheritdoc}
     * @return StaExamenesdetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaExamenesdetQuery(get_called_class());
    }
    
    public static function respuesta($identidad,$valor){
       $modelo=static::findOne($identidad);
       $modelo->setScenario(self::SCENARIO_RESPUESTA);
       $modelo->valor=$valor;
       return $modelo->save();
    }
    
    public function setPuntaje($arrayCalificaciones){
        $this->setScenario(self::SCENARIO_RESPUESTA);
        $this->puntaje=$this->testdet->puntaje($this->valor,$arrayCalificaciones);
       return $this->save();
    }
    
    
}
