<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\models\Citas;
use Yii;

/**
 * This is the model class for table "{{%sta_resumenasistencias}}".
 *
 * @property int $id
 * @property string $codalu
 * @property string $codfac
 * @property string $nombres
 * @property string $c_1
 * @property string $c_2
 * @property string $c_3
 * @property string $c_4
 * @property string $c_5
 * @property string $c_6
 * @property string $c_7
 * @property string $c_8
 * @property string $c_9
 * @property string $c_10
 * @property string $c_11
 * @property string $c_12
 * @property string $c_13
 * @property string $c_14
 */
class StaResumenasistencias extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_resumenasistencias}}';
    }
 
    
 public $dateorTimeFields=[
   // 'c_1'=>self::_FDATETIME,
    'c_2'=>self::_FDATETIME,
    'c_3'=>self::_FDATETIME,
    'c_4'=>self::_FDATETIME,
    'c_5'=>self::_FDATETIME,
    'c_6'=>self::_FDATETIME, 
    'c_7'=>self::_FDATETIME,
    'c_8'=>self::_FDATETIME,
    'c_9'=>self::_FDATETIME,
    'c_10'=>self::_FDATETIME,
    'c_11'=>self::_FDATETIME,
    'c_12'=>self::_FDATETIME,
    'c_13'=>self::_FDATETIME,
    'c_14'=>self::_FDATETIME];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codalu'], 'string', 'max' => 14],
            [['codfac'], 'string', 'max' => 8],
            [['nombres'], 'string', 'max' => 40],
             [['status','n_informe','tallerdet_id','codperiodo','codcar','c_15', 'c_16', 'c_17', 'c_18', 'c_19', 'c_20','c_21','c_30','c_31','c_32','c_33','c_34','c_35','c_36','c_37','c_38','c_39','c_40','c_41','c_42','c_43','c_44','n_informe2','tmarzo','tabril','tmayo','tjunio','tjulio','tagosto','tsetiembre','codtra','n_tutorias','n_talleres'], 'safe'],
            [['c_1', 'c_2', 'c_3', 'c_4', 'c_5', 'c_6', 'c_7', 'c_8', 'c_9', 'c_10', 'c_11', 'c_12', 'c_13', 'c_14','c_30','c_31','c_32','c_33','c_34','c_35'], 'string', 'max' => 19],
        ];
    }

      public function getAlumno()
    {
      /* echo  $this->hasOne(Talleresdet::className(), ['id' => 'talleresdet_id'])->createCommand()
          ->getRawSql();die();*/
        return $this->hasOne(Alumnos::className(), ['codalu' => 'codalu']);
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'n_informe' => Yii::t('sta.labels', 'N inf'),
            'id' => Yii::t('sta.labels', 'ID'),
            'codalu' => Yii::t('sta.labels', 'Código'),
             'codperiodo' => Yii::t('sta.labels', 'Period'),
            'codfac' => Yii::t('sta.labels', 'Fac'),
            'codtra' => Yii::t('sta.labels', 'Psic'),
            'codcar' => Yii::t('sta.labels', 'Esp'),
            'nombres' => Yii::t('sta.labels', 'Nombres'),
            'c_1' => Yii::t('sta.labels', 'EvI'),
            'c_2' => Yii::t('sta.labels', 'Entr'),
            'c_3' => Yii::t('sta.labels', 'Tu1'),
            'c_4' => Yii::t('sta.labels', 'Tu2'),
            'c_5' => Yii::t('sta.labels', 'Tu3'),
            'c_6' => Yii::t('sta.labels', 'Tu4'),
            'c_7' => Yii::t('sta.labels', 'Tu5'),
            'c_8' => Yii::t('sta.labels', 'Tu6'),
            'c_9' => Yii::t('sta.labels', 'Tu7'),
             'c_10' => Yii::t('sta.labels', 'Tu8'),
             'c_11' => Yii::t('sta.labels', 'Tu9'),
             'c_12' => Yii::t('sta.labels', 'Tu10'),
            'c_15' => Yii::t('sta.labels', 'Ta1'),
            'c_16' => Yii::t('sta.labels', 'Ta2'),
            'c_17' => Yii::t('sta.labels', 'Ta3'),
            'c_18' => Yii::t('sta.labels', 'Ta4'),
            'c_19' => Yii::t('sta.labels', 'Ta5'),
            'c_20' => Yii::t('sta.labels', 'Ta6'),            
            'c_21' => Yii::t('sta.labels', 'Tot'),
             'c_30' => Yii::t('sta.labels', 'Ta7'),            
            'c_31' => Yii::t('sta.labels', 'Ta8'),
            'c_32' => Yii::t('sta.labels', 'Ta9'),            
            'c_33' => Yii::t('sta.labels', 'Ta10'),
            'c_34' => Yii::t('sta.labels', 'Ta11'),            
            'c_35' => Yii::t('sta.labels', 'Ta12'),
             'c_36' => Yii::t('sta.labels', 'Ta13'),            
            'c_37' => Yii::t('sta.labels', 'Tu11'),
            'c_38' => Yii::t('sta.labels', 'Tu12'),            
            'c_39' => Yii::t('sta.labels', 'Tu13'),
            'c_40' => Yii::t('sta.labels', 'Ta14'),
             'c_41' => Yii::t('sta.labels', 'Ta15'),
             'c_42' => Yii::t('sta.labels', 'Ta16'),
             'c_43' => Yii::t('sta.labels', 'Ta17'),
            'c_44' => Yii::t('sta.labels', 'Ta18'),
            'ev_f' => Yii::t('sta.labels', 'EvFinal'),
              'tmarzo' => Yii::t('sta.labels', 'TuMarzo'),
              'tabril' => Yii::t('sta.labels', 'TuAbril'),
             'tmayo' => Yii::t('sta.labels', 'TuMayo'),
              'tjunio' => Yii::t('sta.labels', 'TuJunio'),
             'tjulio' => Yii::t('sta.labels', 'TuJulio'),
             'tagosto' => Yii::t('sta.labels', 'TuAgosto'),
             'tsetiembre' => Yii::t('sta.labels', 'TuSet'),
             'nveces' => Yii::t('sta.labels', 'NMaxRep'),
              'n_tutorias' => Yii::t('sta.labels', 'Solo Tut Ind'),
             'n_talleres' => Yii::t('sta.labels', 'Solo Tut Grup'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return StaResumenasistenciasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaResumenasistenciasQuery(get_called_class());
    }
    
    public function cleanAttributes(){
        $attr=['n_informe'=>null,
            'c_1'=>null,
            'c_2'=>null,
            'c_3'=>null,
            'c_4'=>null,
            'c_5'=>null,
            'c_6'=>null,
            'c_7'=>null,
            'c_8'=>null,
            'c_9'=>null,
            'c_10'=>null,
            'c_11'=>null,
            'c_12'=>null,
            'c_13'=>null,
            'c_14'=>null,
            'c_15'=>null,
            'c_16'=>null,
            'c_17'=>null,
            'c_18'=>null,
            'c_19'=>null,
            'c_20'=>null,
            'c_21'=>null,
            'n_informe2'=>null
            ];
        $this->setAttributes($attr);
        return true;
    }
    
    public function afterFind() {
        parent::afterFind();
        foreach($this->dateorTimeFields as $keyCampo=>$tipo){
            if(substr($this->{$keyCampo},0,10)=='31/12/1969'){
              $this->{$keyCampo}='';  
            }
        }
       
       
    }
    
  public function obtenerCitaId($etapa){
     $registro= Citas::findOne([
          'talleresdet_id'=>$this->tallerdet_id,
          'asistio'=>'1',
          'flujo_id'=>$etapa
      ]);
     return (!is_null($registro))?$registro->id:-1;
  }
  
   public function beforeSave($insert) {
       if($insert){            
         $this->clase= \frontend\modules\sta\staModule::CLASE_RIESGO;
          
       }
           
        //$this->resolveDuration();
        return parent::beforeSave($insert);
       
    } 
  
}
