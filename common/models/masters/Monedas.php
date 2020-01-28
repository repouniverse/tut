<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "{{%monedas}}".
 *
 * @property string $codmon
 * @property string $desmon
 * @property string $activa
 * @property string $simbolo
 *
 * @property SigiCuentas[] $sigiCuentas
 */
class Monedas extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%monedas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codmon', 'desmon'], 'required'],
            [['codmon'], 'string', 'max' => 5],
            [['desmon'], 'string', 'max' => 15],
            [['activa'], 'string', 'max' => 40],
            [['simbolo'], 'string', 'max' => 3],
            [['codmon'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codmon' => Yii::t('base.labels', 'Codmon'),
            'desmon' => Yii::t('base.labels', 'Desmon'),
            'activa' => Yii::t('base.labels', 'Activa'),
            'simbolo' => Yii::t('base.labels', 'Simbolo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSigiCuentas()
    {
        return $this->hasMany(SigiCuentas::className(), ['codmon' => 'codmon']);
    }

    /**
     * {@inheritdoc}
     * @return MonedasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MonedasQuery(get_called_class());
    }
    
    public static function Simbolo($codmon){
        return static::findOne($codmon)->simbolo;
    }
    public static function Centimos($codmon){
        return static::findOne($codmon)->centimos;
    }
}
