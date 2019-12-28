<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%sta_testcali}}".
 *
 * @property int $id
 * @property string $codtest
 * @property int $valor
 * @property string $descripcion
 * @property int $peso
 *
 * @property StaTest $codtest0
 */
class StaTestcali extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_testcali}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codtest', 'valor', 'descripcion'], 'required'],
            [['valor', 'peso'], 'integer'],
            [['codtest'], 'string', 'max' => 8],
            [['descripcion'], 'string', 'max' => 30],
            [['codtest'], 'exist', 'skipOnError' => true, 'targetClass' => Test::className(), 'targetAttribute' => ['codtest' => 'codtest']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codtest' => Yii::t('app', 'Codtest'),
            'valor' => Yii::t('app', 'Valor'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'peso' => Yii::t('app', 'Peso'),
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
     * @return StaTestcaliQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaTestcaliQuery(get_called_class());
    }
}
