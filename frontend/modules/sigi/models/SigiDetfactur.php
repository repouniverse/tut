<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_detfactur}}".
 *
 * @property int $id
 * @property int $cuentaspor_id
 * @property int $edificio_id
 * @property int $unidad_id
 * @property int $colector_id
 * @property int $grupo_id
 * @property string $monto
 * @property string $igv
 * @property int $grupounidad agrupa  todos los objetos: cochera, depositos  en el mismo departamento  
 * @property int $grupofacturacion Agrupa el documento del recibo, ojo lo hace por departametno o apoderado, MUY IMPORTANTES 
 *
 * @property SigiCargosgrupoedificio $grupo
 * @property SigiCuentaspor $cuentaspor
 * @property SigiCargosedificio $colector
 * @property SigiEdificios $edificio
 * @property SigiUnidades $unidad
 */
class SigiDetfactur extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_detfactur}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuentaspor_id', 'edificio_id', 'unidad_id', 'colector_id', 'grupo_id', 'monto', 'igv', 'grupounidad', 'grupofacturacion'], 'required'],
            [['cuentaspor_id', 'edificio_id', 'unidad_id', 'colector_id', 'grupo_id', 'grupounidad', 'grupofacturacion'], 'integer'],
            [['monto', 'igv'], 'number'],
            [['grupo_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCargosgrupoedificio::className(), 'targetAttribute' => ['grupo_id' => 'id']],
            [['cuentaspor_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCuentaspor::className(), 'targetAttribute' => ['cuentaspor_id' => 'id']],
            [['colector_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCargosedificio::className(), 'targetAttribute' => ['colector_id' => 'id']],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiEdificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
            [['unidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiUnidades::className(), 'targetAttribute' => ['unidad_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'cuentaspor_id' => Yii::t('sigi.labels', 'Cuentaspor ID'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad ID'),
            'colector_id' => Yii::t('sigi.labels', 'Colector ID'),
            'grupo_id' => Yii::t('sigi.labels', 'Grupo ID'),
            'monto' => Yii::t('sigi.labels', 'Monto'),
            'igv' => Yii::t('sigi.labels', 'Igv'),
            'grupounidad' => Yii::t('sigi.labels', 'Grupounidad'),
            'grupofacturacion' => Yii::t('sigi.labels', 'Grupofacturacion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupo()
    {
        return $this->hasOne(SigiCargosgrupoedificio::className(), ['id' => 'grupo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuentaspor()
    {
        return $this->hasOne(SigiCuentaspor::className(), ['id' => 'cuentaspor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColector()
    {
        return $this->hasOne(SigiCargosedificio::className(), ['id' => 'colector_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(SigiEdificios::className(), ['id' => 'edificio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidad()
    {
        return $this->hasOne(SigiUnidades::className(), ['id' => 'unidad_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiDetfacturQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiDetfacturQuery(get_called_class());
    }
}
