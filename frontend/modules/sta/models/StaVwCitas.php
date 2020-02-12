<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\staModule;
use common\models\masters\Documentos;
use frontend\modules\sta\interfaces\editableViewInterface;
use common\models\base\modelBase;
use Yii;
class StaVwCitas extends 
modelBase implements 
editableViewInterface
{
    /**
     * {@inheritdoc}
     */
    public $extraMethodsToReport=[
        'reportFacultad',
        'reportCarrera',
        'reportFotoAlu',
        'reportDocument'
    ];
    
    public $dateorTimeFields=['fechaprog'=>self::_FDATETIME,
        'fechaprog1'=>self::_FDATETIME];
   // public $booleanFields=['asistio'];
    public $fechaprog1;
     public $finicio1;
      public $ftermino1;
    public static function tableName()
    {
        return '{{%vw_sta_citas}}';
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
            'aptutor' => Yii::t('sta.labels', 'Ap Psicólogo'),
            'codtra' => Yii::t('sta.labels', 'Psicólogo'),
            'amtutor' => Yii::t('sta.labels', 'Am Psicólogo'),
            'nombrestutor' => Yii::t('sta.labels', 'Nombre Psicólogo'),
            'codperiodo' => Yii::t('sta.labels', 'Periodo'),
            'codalu' => Yii::t('sta.labels', 'Código Alumno'),
            'ap' => Yii::t('sta.labels', 'Ap Alumno'),
            'am' => Yii::t('sta.labels', 'Am Alumno'),
            'nombres' => Yii::t('sta.labels', 'Nombres'),
            'codfac' => Yii::t('sta.labels', 'Facultad'),
            'codcar' => Yii::t('sta.labels', 'Especialidad'),
            'id' => Yii::t('sta.labels', 'ID'),
            'talleresdet_id' => Yii::t('sta.labels', 'Talleresdet ID'),
            'talleres_id' => Yii::t('sta.labels', 'Talleres ID'),
            'fechaprog' => Yii::t('sta.labels', 'Fecha Ini'),
            'fechaprog1' => Yii::t('sta.labels', 'Fecha Fin'),
            //'codtra' => Yii::t('sta.labels', 'Codtra'),
            'finicio' => Yii::t('sta.labels', 'Finicio'),
            'ftermino' => Yii::t('sta.labels', 'Ftermino'),
            'fingreso' => Yii::t('sta.labels', 'Fingreso'),
            'detalles' => Yii::t('sta.labels', 'Detalles'),
            'codaula' => Yii::t('sta.labels', 'Codaula'),
            'duracion' => Yii::t('sta.labels', 'Duracion'),
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
    
   public function getReportFacultad()
    {
        return Facultades::findOne($this->codfac)->desfac;
    }
     public function getReportCarrera()
    {
         return Carreras::findOne($this->codcar)->descar;
    }
   public function getReportFotoAlu()
    {
      return \yii\helpers\Html::img(staModule::getPathImage($this->codalu),['width'=>90, 'height'=>120]) ; 
    } 
     public function fotoAluSmall()
    {
      return \yii\helpers\Html::img(staModule::getPathImage($this->codalu),['width'=>45, 'height'=>60]) ; 
    } 
    
    public function getCita(){
        return $this->hasOne(Citas::className(), ['id' => 'id']);
    }
    
    public function getReportDocument()
    {
      return 'INFORME DE TUTORIA';
    }
    public static function findOne($id){
        return static::find()->where(['id'=>$id])->one();
    }
    public function delete(){
       return $this->cita->delete();
    }
}
