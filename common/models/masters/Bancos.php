<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "{{%bancos}}".
 *
 * @property int $id
 * @property string $codbanco
 * @property string $nombre
 * @property string $texto
 * @property int $order
 *
 * @property SigiCuentas[] $sigiCuentas
 */
class Bancos extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bancos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codbanco','nombre'], 'required'],
            [['texto'], 'string'],
            [['order'], 'integer'],
            [['codbanco'], 'string', 'max' => 10],
            [['nombre'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codbanco' => Yii::t('base.names', 'Código'),
            'nombre' => Yii::t('base.names', 'Nombre'),
            'texto' => Yii::t('base.names', 'Texto'),
            'order' => Yii::t('base.names', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    

    /**
     * {@inheritdoc}
     * @return BancosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BancosQuery(get_called_class());
    }
}
