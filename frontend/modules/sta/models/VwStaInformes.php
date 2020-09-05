<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%vw_sta_informes}}".
 *
 * @property string $aptutor
 * @property string $amtutor
 * @property string $nombrestutor
 * @property string $proceso
 * @property string $codalu
 * @property string $ap
 * @property string $am
 * @property string $nombres
 * @property string $codcar
 * @property string $correo
 * @property int $id
 * @property string $codocu
 * @property string $codfac
 * @property string $descripcion
 * @property string $status
 * @property string $impreso
 * @property string $ultimamod
 * @property string $numerocita
 * @property string $fechaprog
 * @property int $flujo_id
 * @property string $desdocu
 */
class VwStaInformes extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_sta_informes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aptutor', 'amtutor', 'nombrestutor', 'proceso', 'codalu', 'codocu', 'desdocu'], 'required'],
            [['id', 'flujo_id'], 'integer'],
            [['aptutor', 'amtutor', 'nombrestutor', 'proceso', 'ap', 'am', 'nombres'], 'string', 'max' => 40],
            [['codalu'], 'string', 'max' => 14],
            [['codcar'], 'string', 'max' => 6],
            [['correo'], 'string', 'max' => 54],
            [['codocu'], 'string', 'max' => 3],
            [['codfac', 'numerocita'], 'string', 'max' => 8],
            [['descripcion'], 'string', 'max' => 30],
            [['status', 'impreso'], 'string', 'max' => 1],
            [['ultimamod', 'fechaprog'], 'string', 'max' => 19],
            [['desdocu'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'aptutor' => Yii::t('sta.labels', 'Aptutor'),
            'amtutor' => Yii::t('sta.labels', 'Amtutor'),
            'nombrestutor' => Yii::t('sta.labels', 'Nombrestutor'),
            'proceso' => Yii::t('sta.labels', 'Proceso'),
            'codalu' => Yii::t('sta.labels', 'Codalu'),
            'ap' => Yii::t('sta.labels', 'Ap'),
            'am' => Yii::t('sta.labels', 'Am'),
            'nombres' => Yii::t('sta.labels', 'Nombres'),
            'codcar' => Yii::t('sta.labels', 'Codcar'),
            'correo' => Yii::t('sta.labels', 'Correo'),
            'id' => Yii::t('sta.labels', 'ID'),
            'codocu' => Yii::t('sta.labels', 'Codocu'),
            'codfac' => Yii::t('sta.labels', 'Codfac'),
            'descripcion' => Yii::t('sta.labels', 'Descripcion'),
            'status' => Yii::t('sta.labels', 'Status'),
            'impreso' => Yii::t('sta.labels', 'Impreso'),
            'ultimamod' => Yii::t('sta.labels', 'Ultimamod'),
            'numerocita' => Yii::t('sta.labels', 'Numerocita'),
            'fechaprog' => Yii::t('sta.labels', 'Fechaprog'),
            'flujo_id' => Yii::t('sta.labels', 'Flujo ID'),
            'desdocu' => Yii::t('sta.labels', 'Desdocu'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwStaInformesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwStaInformesQuery(get_called_class());
    }
    
    public static function except(){
      return self::find()->andWhere(['<>','status', Aluriesgo::FLAG_RETIRADO]);
  }
}
