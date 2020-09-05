<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%activerecordlog}}".
 *
 * @property int $id
 * @property string $model
 * @property string $field
 * @property string $ip
 * @property string $creationdate
 * @property string $controlador
 * @property string $description
 * @property string $nombrecampo
 * @property string $oldvalue
 * @property string $newvalue
 * @property string $username
 * @property string $metodo
 * @property string $action
 * @property string $clave
 */
class Activerecordlog extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%activerecordlog}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model'], 'string', 'max' => 100],
            [['field', 'nombrecampo'], 'string', 'max' => 45],
            [['ip'], 'string', 'max' => 18],
            [['creationdate', 'clave'], 'string', 'max' => 20],
            [['controlador'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 105],
            [['oldvalue', 'newvalue'], 'string', 'max' => 80],
            [['username'], 'string', 'max' => 30],
            [['metodo'], 'string', 'max' => 7],
            [['action'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.labels', 'ID'),
            'model' => Yii::t('base.labels', 'Model'),
            'field' => Yii::t('base.labels', 'Field'),
            'ip' => Yii::t('base.labels', 'Ip'),
            'creationdate' => Yii::t('base.labels', 'Creationdate'),
            'controlador' => Yii::t('base.labels', 'Controlador'),
            'description' => Yii::t('base.labels', 'Description'),
            'nombrecampo' => Yii::t('base.labels', 'Nombrecampo'),
            'oldvalue' => Yii::t('base.labels', 'Oldvalue'),
            'newvalue' => Yii::t('base.labels', 'Newvalue'),
            'username' => Yii::t('base.labels', 'Username'),
            'metodo' => Yii::t('base.labels', 'Metodo'),
            'action' => Yii::t('base.labels', 'Action'),
            'clave' => Yii::t('base.labels', 'Clave'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ActiverecordlogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActiverecordlogQuery(get_called_class());
    }
}
