<?php

namespace common\models;

use Yii;
use common\models\masters\Documentos;
/**
 * This is the model class for table "{{%acces_docu}}".
 *
 * @property int $id
 * @property string $modelo
 * @property string $codocu
 * @property string $rol
 * @property string $campo
 * @property string $campo_profile
 * @property string $upload
 * @property string $download
 *
 * @property Documentos $codocu0
 */
class AccesDocu extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%acces_docu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['modelo', 'codocu', 'rol'], 'required'],
            [['modelo'], 'string', 'max' => 180],
            [['codocu'], 'string', 'max' => 3],
            [['rol'], 'string', 'max' => 100],
            [['campo'], 'string', 'max' => 40],
            [['campo_profile'], 'string', 'max' => 20],
            [['upload', 'download'], 'string', 'max' => 1],
            [['codocu'], 'exist', 'skipOnError' => true, 'targetClass' => Documentos::className(), 'targetAttribute' => ['codocu' => 'codocu']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.labels', 'ID'),
            'modelo' => Yii::t('base.labels', 'Modelo'),
            'codocu' => Yii::t('base.labels', 'Codocu'),
            'rol' => Yii::t('base.labels', 'Rol'),
            'campo' => Yii::t('base.labels', 'Campo'),
            'campo_profile' => Yii::t('base.labels', 'Campo Profile'),
            'upload' => Yii::t('base.labels', 'Upload'),
            'download' => Yii::t('base.labels', 'Download'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodocu0()
    {
        return $this->hasOne(Documentos::className(), ['codocu' => 'codocu']);
    }

    /**
     * {@inheritdoc}
     * @return AccesDocuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccesDocuQuery(get_called_class());
    }
}
