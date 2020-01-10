<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_lecturas}}".
 *
 * @property int $id
 * @property int $suministro_id
 * @property int $unidad_id
 * @property string $codepa
 * @property string $mes
 * @property string $flectura
 * @property string $hlectura
 * @property string $lectura
 * @property string $lecturaant
 * @property string $delta
 *
 * @property SigiSuministros $suministro
 */
class SigiLecturas extends \common\models\base\modelBase
{
    
    public $dateorTimeFields=['flectura'=>self::_FDATE];
    /**
     * {@inheritdoc}
     */
    const SCENARIO_IMPORTACION='importacion_simple';
    public static function tableName()
    {
        return '{{%sigi_lecturas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['suministro_id', 'unidad_id', 'mes','anio'], 'required','on'=>'default'],
            
            [['suministro_id', 'unidad_id', 'mes'], 'required','on'=>'default'],
            [['suministro_id','mes', 'anio'], 'unique', 'targetAttribute' => ['mes']],
            
            [['suministro_id', 'unidad_id'], 'integer'],
            [['lectura', 'lecturaant', 'delta'], 'number'],
             [['lectura', 'valida_lectura'], 'number'],
            [['codepa'], 'string', 'max' => 12],
             [['codedificio'], 'string', 'max' => 12], 
            [['codepa','codedificio','codtipo','edificio_id'], 'safe'],
           
            /*Escenario imortacion*/
             [['codepa'], 'valida_depa','on'=>self::SCENARIO_IMPORTACION],
             [['codepa'], 'valida_lectura','on'=>self::SCENARIO_IMPORTACION],
             [['codepa','codedificio','codtipo','mes','anio','lectura','flectura'], 'required','on'=>self::SCENARIO_IMPORTACION],
             [['codedificio'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['codedificio' => 'codigo'],'on'=>self::SCENARIO_IMPORTACION],
             //[['codepa'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['codedificio' => 'codigo']],
     
            /*Fin de escebnario imortacion*/
            [['mes'], 'integer'],
            [['flectura'], 'string', 'max' => 10],
            [['hlectura'], 'string', 'max' => 5],
            [['suministro_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiSuministros::className(), 'targetAttribute' => ['suministro_id' => 'id']],
        ];
    }
 public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios[self::SCENARIO_IMPORTACION] = ['codepa','codedificio','codtipo','mes','anio','lectura','flectura'];
       return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'suministro_id' => Yii::t('sigi.labels', 'Suministro ID'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad ID'),
            'codepa' => Yii::t('sigi.labels', 'Codepa'),
            'mes' => Yii::t('sigi.labels', 'Mes'),
            'flectura' => Yii::t('sigi.labels', 'Flectura'),
            'hlectura' => Yii::t('sigi.labels', 'Hlectura'),
            'lectura' => Yii::t('sigi.labels', 'Lectura'),
            'lecturaant' => Yii::t('sigi.labels', 'Lecturaant'),
            'delta' => Yii::t('sigi.labels', 'Delta'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuministro()
    {
        return $this->hasOne(SigiSuministros::className(), ['id' => 'suministro_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiLecturasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiLecturasQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
      if($insert){
          $this->resolveIds();
        $this->lecturaant=$this->lastReadNumeric(); 
         $this->delta=$this->lectura-$this->lastReadNumeric();    
      }else{
         if($this->hasChanged('lectura'))
           $this->delta=$this->lectura-$this->lastReadNumeric();    
      }  
        RETURN parent::beforeSave($insert);
    }
    
    
    public function rawSuministro(){        
             return ($this->isNewRecord)?SigiSuministros::findOne($this->suministro_id):
           $this->suministro ;
    }
   
    
    public function lastReadNumeric($fecha=null){
        $ll=$this->medidor()->lastRead($fecha);
       return (is_null($ll))?0:$ll->lectura;
    }
    public function lastDateRead($fecha=null){
        $ll=$this->medidor()->lastRead($fecha);
       return (is_null($ll))?0:$ll->flectura; 
    }
    public function nextReadNumeric($fecha){
        $ll=$this->medidor()->nextRead($fecha);
       return (is_null($ll))?null:$ll->lectura;
    }
    public function nextDateRead($fecha){
        $ll=$this->medidor()->nextRead($fecha);
       return (is_null($ll))?null:$ll->flectura;
    }
    
    
    
    
    
     public function valida_lectura($attribute, $params)
    {
      /*Validando fecha*/
         $mes=$this->toCarbon('flectura')->month+0;
        if(!((integer)$this->mes == (integer)$mes)){
            $this->addError('flectura',yii::t('sigi.errors','La fecha no corresponde al mes'));
        }
         
         
         
         if($this->lectura < $this->lastReadNumeric($this->flectura))
              $this->addError('lectura','Este valor es menor que la última lectura {\'ultimalectura\'}',['ultimalectura'=>$this->lastReadNumeric()]);
        
         $medidor=$this->medidor($type=SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT);
         
      /*Si la lectura corresponde a una nueva lectura */
         if(!$medidor->isDateForLastRead($this->flectura)){
              if($this->lectura > $this->nextReadNumeric($this->flectura))
              $this->addError('lectura','Existe una lectura posterior, y es menor que la lectura que esta intentando ingresar "{{ultimalectura}}"',['ultimalectura'=>$this->nextReadNumeric($this->flectura)]);
           }
        
     } 
     
    private function resolveIds(){
        
        $this->edificio_id= $this->edificio()->id;        
        $this->unidad_id= $this->depa()->id;
        $this->suministro_id=$this->medidor()->id;
        
    }
    public function valida_depa($attribute, $params)
    {
        $edificio=$this->edificio();
      if(is_null($edificio)){
          $this->addError('codedificio',yii::t('sigi.labels','El codigo de edificio no existe'));
          return;
      }       
   $depa= $this->depa(); 
   if(is_null($depa)){
          $this->addError('codepa',yii::t('sigi.labels','El codigo de departamento para este edificio no existe'));
          return;
      } 
  //VERIFICANDO QUE EL DEPA TENGA MDEIDOR DE ESTE TIPO
     if(is_null($this->medidor())){
        $this->addError('codepa',yii::t('sigi.labels','Este departamento no tiene ningun medidor del tipo {medidor}',['medidor'=> SigiSuministros::comboValueFieldStatic('tipo',SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT)]));
          return;  
     }
     
      
        
    }     
    
    private function edificio(){
        return Edificios::find()->where(['codigo'=>$this->codedificio])->one();
    }
    private function depa(){
       return  SigiUnidades::find()->where([
            'numero'=>$this->codepa,
        'edificio_id'=>$this->edificio_id,
            ])->one();
    }
    public function medidor($type=SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT){
       if($this->suministro_id >0)
         return $this->suministro; 
       if(!empty($this->codepa) && !is_null($this->edificio()))
       return  $this->depa()->firstMedidor($type);
        
       
    }
    
    public function hasUsedFactur(){
        if(!$this->facturable){
           return false; 
        }else{
            
        }
    }
}
