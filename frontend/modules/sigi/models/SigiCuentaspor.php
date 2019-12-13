<?php

namespace frontend\modules\sigi\models;
use common\models\masters\Clipro;
use Yii;
use common\behaviors\FileBehavior;
/**
 * This is the model class for table "{{%sigi_cuentaspor}}".
 *
 * @property int $id
 * @property int $edificio_id
 * @property string $codocu
 * @property string $descripcion
 * @property string $fedoc
 * @property int $mes
 * @property string $anio
 * @property string $detalle
 * @property string $fevenc
 * @property string $monto
 * @property string $igv
 * @property string $codestado
 *
 * @property SigiEdificios $id0
 */
class SigiCuentaspor extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_cuentaspor}}';
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
            [['edificio_id', 'codocu', 'descripcion', 'mes', 'anio', 'monto', 'codestado'], 'required'],
            [['edificio_id', 'mes'], 'integer'],
            [['detalle'], 'string'],
            [['monto'], 'number'],
            [['codocu'], 'string', 'max' => 3],
            [['descripcion'], 'string', 'max' => 40],
            [['fedoc', 'fevenc', 'igv', 'codestado'], 'string', 'max' => 10],
            [['anio'], 'string', 'max' => 4],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'codocu' => Yii::t('sigi.labels', 'Codocu'),
            'descripcion' => Yii::t('sigi.labels', 'Descripcion'),
            'fedoc' => Yii::t('sigi.labels', 'Fedoc'),
            'mes' => Yii::t('sigi.labels', 'Mes'),
            'anio' => Yii::t('sigi.labels', 'Año'),
            'detalle' => Yii::t('sigi.labels', 'Detalle'),
            'fevenc' => Yii::t('sigi.labels', 'Fevenc'),
            'monto' => Yii::t('sigi.labels', 'Monto'),
            'igv' => Yii::t('sigi.labels', 'Igv'),
            'codestado' => Yii::t('sigi.labels', 'Codestado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['edificio_id' => 'id']);
    }

    
    public function getClipro()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }

    /**
     * {@inheritdoc}
     * @return SigiCuentasporQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiCuentasporQuery(get_called_class());
    }
}
