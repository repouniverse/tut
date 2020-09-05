<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%sta_tipo_mail}}".
 *
 * @property int $id
 * @property int $tipo
 * @property string $cabecera
 * @property string $pie
 * @property string $titulo
 * @property string $nombre
 *
 * @property StaMailMensajes[] $staMailMensajes
 */
class StaTipoMail extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_tipo_mail}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo'], 'required'],
            [['tipo'], 'integer'],
            [['cabecera', 'pie'], 'string'],
            [['titulo'], 'string', 'max' => 40],
            [['nombre'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'tipo' => Yii::t('base.names', 'Tipo'),
            'cabecera' => Yii::t('base.names', 'Cabecera'),
            'pie' => Yii::t('base.names', 'Pie'),
            'titulo' => Yii::t('base.names', 'Titulo'),
            'nombre' => Yii::t('base.names', 'Nombre'),
        ];
    }

    /**
     * Gets query for.
     *
     * 
     */
    public function getStaMailMensajes()
    {
        return $this->hasMany(StaMailMensajes::className(), ['tipo_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return StaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaTipoMailQuery(get_called_class());
    }
}
