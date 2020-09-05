<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%sta_mail_mensajes}}".
 *
 * @property int $id
 * @property int $tipo_id
 * @property string $subject
 * @property string $fecha
 * @property int $user_id
 *
 * @property StaTipoMail $tipo
 */
class StaMailMensajes extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_mail_mensajes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_id', 'user_id'], 'integer'],
            [['subject', 'fecha'], 'required'],
            [['subject', 'fecha'], 'string', 'max' => 40],
            [['tipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaTipoMail::className(), 'targetAttribute' => ['tipo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'tipo_id' => Yii::t('base.names', 'Tipo ID'),
            'subject' => Yii::t('base.names', 'Subject'),
            'fecha' => Yii::t('base.names', 'Fecha'),
            'user_id' => Yii::t('base.names', 'User ID'),
        ];
    }

    /**
     * Gets query for.
     *
     * 
     */
    public function getTipo()
    {
        return $this->hasOne(StaTipoMail::className(), ['id' => 'tipo_id']);
    }

    /**
     * {@inheritdoc}
     * @return StaMailMensajesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaMailMensajesQuery(get_called_class());
    }
}
