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
            
            [['suministro_id', 'unidad_id'], 'integer'],
            [['lectura', 'lecturaant', 'delta'], 'number'],
            [['lectura'], 'valida_lectura'],
            [['codepa'], 'string', 'max' => 12],
             [['codedificio'], 'string', 'max' => 12],
            [['codepa','codedificio','codtipo'], 'safe'],
           
            /*Escenario imortacion*/
             [['codepa'], 'valida_depa','on'=>self::SCENARIO_IMPORTACION],
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
        $scenarios[self::SCENARIO_IMPORTACION] = ['codepa','codedificio','codtipo','codum','codpro'];
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
   
    
    public function lastReadNumeric(){
        $ll=$this->rawSuministro()->lastRead();
       return (is_null($ll))?0:$ll->lectura;
    }
    
     public function valida_lectura($attribute, $params)
    {
      if($this->lastReadNumeric() > $this->lectura){
          $this->addError('lecura','Este valor es menor que la última lectura {\'ultimalectura\'}',['ultimalectura'=>$this->lastReadNumeric()]);
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
        'edificio_id'=>$this->edificio()->id,
            ])->one();
    }
    private function medidor(){
       return  $this->depa()->firstMedidor(SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT);
    }
}
