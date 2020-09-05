<?php

namespace frontend\modules\sta\models;
use frontend\modules\sta\models\Talleresdet;
use common\behaviors\FileBehavior;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%sta_retiros}}".
 *
 * @property int $id
 * @property int $tallerdet_id
 * @property string $codalu
 * @property string $motivo
 *
 * @property StaTalleresdet $tallerdet
 */
class StaRetiros extends \common\models\base\modelBase
{
    const STATUS_ACTIVO='A';
    const STATUS_INACTIVO='X';
    const CODIGO_DOC='415';
    public $dateorTimeFields=['fecha'=>self::_FDATE];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_retiros}}';
    }
   
    public function behaviors()
            {
	return [
		'fileBehavior' => [
			'class' => FileBehavior::className()
		],
            'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
                ];
            }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codalu','tallerdet_id','motivo','fecha','codocu','motivo'], 'required'],
            [['tallerdet_id'], 'integer'],
            [['codalu'], 'string', 'max' => 14],
            [['motivo'], 'string', 'max' => 3],
            [['codocu','detalle','estado','clase'],'safe'],
            [['codalu','tallerdet_id'],'validateExists'],
             /*[['codalu'], 'exist', 'skipOnError' => true, 
                 'targetClass' => Talleresdet::className(),
                 'targetAttribute' => ['codalu' => 'codalu'],
                'message'=>yii::t('sta.labels','El alumno no se encuentra en el programa ')],*/
            /*[['tallerdet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleresdet::className(), 'targetAttribute' => ['tallerdet_id' => 'id']],*/
        ];
    }

    
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sta.labels', 'ID'),
            'tallerdet_id' => Yii::t('sta.labels', 'Tallerdet ID'),
            'codalu' => Yii::t('sta.labels', 'Codalu'),
            'motivo' => Yii::t('sta.labels', 'Motivo'),
             'codocu' => Yii::t('sta.labels', 'Documento'),
            'estado' => Yii::t('sta.labels', 'Estado'),
            'detalle'=>Yii::t('sta.labels', 'Detalles'),
        ];
    }

    /**
     * Gets query for.
     *
     * 
     */
    public function getTallerdet()
    {
        return Talleresdet::find()->complete()->andWhere(['id' => $this->tallerdet_id]);
        //return $this->hasOne(Talleresdet::className(), ['id' => 'tallerdet_id']);
        
    }
    
     public function getAlumno()
    {
        return $this->hasOne(Alumnos::className(), ['codalu' => 'codalu']);
    }

    /**
     * {@inheritdoc}
     * @return StaRetirosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaRetirosQuery(get_called_class());
    }
    
   public function afterSave($insert, $changedAttributes) {
       if($insert){
           $this->tallerdet->retiraDelPrograma(true);
       }else{
         if(in_array('estado',array_keys($changedAttributes)) && $this->estado==self::STATUS_INACTIVO){
             YII::ERROR('SE CAMBIO',$this->estado);
             $this->tallerdet->retiraDelPrograma(false); 
         }ELSE{
             YII::ERROR('NO SE CAMBIO',$this->estado);
         }
       }
      return parent::afterSave($insert, $changedAttributes);
   }
   
    public function beforeSave($insert) {
       if($insert){
          $this->clase= \frontend\modules\sta\staModule::CLASE_RIESGO;
       }
       return parent::beforeSave($insert);
    } 
   
   public function validateFecha(){
       $fecha=$this->toCarbon('fecha');
       if($fecha->greaterThan(self::CarbonNow()->addMinutes(10))){
           $this->addError('fecha',yii::t('sta.errors','La fecha está en el futuro'));
       }
       if($fecha->lessThan( $this->tallerdet->talleres->toCarbon('fopen'))){
           $this->addError('fecha',yii::t('sta.errors','La fecha es anterior a la fecha de inicio del programa, revise'));
       }
   }
   
   public function isBlocked(){
       return ($this->estado==self::STATUS_INACTIVO)?true:false;
   }
   
   public function validateExists($attribute, $params) {
      if($this->isNewRecord){
          $codperiodo= \frontend\modules\sta\staModule::getCurrentPeriod();
          
         $model= Talleresdet::findOne(['id'=>$this->tallerdet_id]);
         if(is_null($model)){
             $this->addError('codalu', yii::t('sta.labels','El alumno no se encuentra en el programa '));
         }else{
             if(!($model->talleres->codperiodo==$codperiodo)){
                 $this->addError('codalu', yii::t('sta.labels','El alumno no se encuentra en el programa '));
             }
         }
      }
       
   }
   
   public function isActive(){
       RETURN ($this->estado==self::STATUS_ACTIVO)?TRUE:FALSE;
   }
}
