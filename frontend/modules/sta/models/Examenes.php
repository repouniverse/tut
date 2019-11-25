<?php

namespace frontend\modules\sta\models;
use common\behaviors\FileBehavior;
use Yii;

/**
 * This is the model class for table "{{%sta_examenes}}".
 *
 * @property int $id
 * @property int $citas_id
 * @property string $codtest
 * @property string $detalles
 *
 * @property StaTest $codtest0
 * @property StaCitas $citas
 */
class Examenes extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_examenes}}';
    }

    
    public function behaviors()
            {
	return [
		
		'fileBehavior' => [
			'class' => FileBehavior::className()
		]
		
                ];
            }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['citas_id', 'codtest'], 'required'],
            [['citas_id'], 'integer'],
            [['detalles'], 'string'],
            [['codtest'], 'string', 'max' => 8],
            [['codtest'], 'exist', 'skipOnError' => true, 'targetClass' => Test::className(), 'targetAttribute' => ['codtest' => 'codtest']],
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
            'codtest' => Yii::t('sta.labels', 'Codtest'),
            'detalles' => Yii::t('sta.labels', 'Detalles'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['codtest' => 'codtest']);
    }
    
    public function getTestTalleres()
    {
     // var_dump($this->cita->tallerdet->id);/*talleres->id);*/die();
        return  StaTestTalleres::find()->where(
                ['codtest' => $this->codtest,
            'taller_id' => $this->cita->talleres_id,
            ])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCita()
    {
        return $this->hasOne(Citas::className(), ['id' => 'citas_id']);
    }

    /**
     * {@inheritdoc}
     * @return ExamenesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExamenesQuery(get_called_class());
    }
}
