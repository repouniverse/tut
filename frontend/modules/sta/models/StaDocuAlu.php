<?php

namespace frontend\modules\sta\models;
use common\models\masters\Documentos;
use common\behaviors\FileBehavior;
use frontend\modules\access\models\modelSensibleAccess;
use Yii;

/**
 * This is the model class for table "{{%sta_docu_alu}}".
 *
 * @property int $id
 * @property int $talleresdet_id
 * @property string $codocu
 * @property string $descripcion
 * @property string $detalle
 *
 * @property StaTalleresdet $talleresdet
 */
class StaDocuAlu extends modelSensibleAccess
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_docu_alu}}';
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
            [['talleresdet_id'], 'integer'],
            [['codocu'], 'required'],
            [['detalle'], 'string'],
            [['codfac'], 'safe'],
            [['codocu'], 'string', 'max' => 3],
            [['descripcion'], 'string', 'max' => 30],
            [['talleresdet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleresdet::className(), 'targetAttribute' => ['talleresdet_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'talleresdet_id' => Yii::t('app', 'Talleresdet ID'),
            'codocu' => Yii::t('app', 'Codocu'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle' => Yii::t('app', 'Detalle'),
            'codestado' => Yii::t('app', 'Estado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTalleresdet()
    {
        return $this->hasOne(Talleresdet::className(), ['id' => 'talleresdet_id']);
    }
    public function getDocumento()
    {
        return $this->hasOne(Documentos::className(), ['codocu' => 'codocu']);
    }
    

    /**
     * {@inheritdoc}
     * @return StaDocuAluQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaDocuAluQuery(get_called_class());
    }
}
