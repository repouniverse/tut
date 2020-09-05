<?php

namespace common\models\audit;

use Yii;

/**
 * This is the model class for table "{{%access_docu_log}}".
 *
 * @property int $id
 * @property string $canal
 * @property int $user_id
 * @property string $fecha_hora
 * @property string $model_class
 * @property string $codocu
 */
class AccessDocuLog extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%access_docu_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['fecha_hora', 'codocu'], 'required'],
            [['id_model'], 'safe'],
            [['canal'], 'string', 'max' => 2],
            [['fecha_hora'], 'string', 'max' => 19],
            [['model_class'], 'string', 'max' => 30],
            [['codocu'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.labels', 'ID'),
            'canal' => Yii::t('base.labels', 'Canal'),
            'user_id' => Yii::t('base.labels', 'User ID'),
            'fecha_hora' => Yii::t('base.labels', 'Fecha Hora'),
            'model_class' => Yii::t('base.labels', 'Model Class'),
            'codocu' => Yii::t('base.labels', 'Codocu'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AccessDocuLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccessDocuLogQuery(get_called_class());
    }
}
