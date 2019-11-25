<?php

namespace frontend\modules\sta\models;

use Yii;
class StaVwCitas extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public $dateorTimeFields=['fechaprog'=>self::_FDATETIME,
        'fechaprog1'=>self::_FDATETIME];
    public $fechaprog1;
     public $finicio1;
      public $ftermino1;
    public static function tableName()
    {
        return '{{%sta_vw_citas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'talleresdet_id', 'talleres_id', 'duracion'], 'integer'],
            [['detalles'], 'string'],
            [['aptutor', 'amtutor', 'nombrestutor', 'ap', 'am', 'nombres'], 'string', 'max' => 40],
            [['codperiodo', 'codcar'], 'string', 'max' => 6],
            [['codalu', 'codtra'], 'string', 'max' => 14],
            [['codfac'], 'string', 'max' => 8],
            [['fechaprog', 'finicio', 'ftermino'], 'string', 'max' => 19],
            [['fingreso', 'codaula'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'aptutor' => Yii::t('app', 'Aptutor'),
            'amtutor' => Yii::t('app', 'Amtutor'),
            'nombrestutor' => Yii::t('app', 'Nombrestutor'),
            'codperiodo' => Yii::t('app', 'Codperiodo'),
            'codalu' => Yii::t('app', 'Codalu'),
            'ap' => Yii::t('app', 'Ap'),
            'am' => Yii::t('app', 'Am'),
            'nombres' => Yii::t('app', 'Nombres'),
            'codfac' => Yii::t('app', 'Codfac'),
            'codcar' => Yii::t('app', 'Codcar'),
            'id' => Yii::t('app', 'ID'),
            'talleresdet_id' => Yii::t('app', 'Talleresdet ID'),
            'talleres_id' => Yii::t('app', 'Talleres ID'),
            'fechaprog' => Yii::t('app', 'Fechaprog'),
            'codtra' => Yii::t('app', 'Codtra'),
            'finicio' => Yii::t('app', 'Finicio'),
            'ftermino' => Yii::t('app', 'Ftermino'),
            'fingreso' => Yii::t('app', 'Fingreso'),
            'detalles' => Yii::t('app', 'Detalles'),
            'codaula' => Yii::t('app', 'Codaula'),
            'duracion' => Yii::t('app', 'Duracion'),
        ];
    }

    
    /**
     * {@inheritdoc}
     * @return StaVwCitasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaVwCitasQuery(get_called_class());
    }
}
