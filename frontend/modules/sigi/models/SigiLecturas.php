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
             [['lectura', 'valida_lectura'], 'number'],
            [['codepa'], 'string', 'max' => 12],
             [['codedificio'], 'string', 'max' => 12],
            [['codepa','codedificio','codtipo'], 'safe'],
           
            /*Escenario imortacion*/
             [['codepa'], 'valida_depa','on'=>self::SCENARIO_IMPORTACION],
             [['codepa','codedificio','codtipo','mes','anio','lectura','flectura'], 'required','on'=>self::SCENARIO_IMPORTACION],
             [['codedificio'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['codedificio' => 'codigo'],'on'=>self::SCENARIO_IMPORTACION],
             //[['codepa'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['codedificio' => 'codigo']],
     
            /*Fin de escebnario imortacion*/
            [['mes'], 'string', 'max' => 2],
            [['flectura'], 'string', 'max' => 10],
            [['hlectura'], 'string', 'max' => 5],
            [['suministro_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiSuministros::className(), 'targetAttribute' => ['suministro_id' => 'id']],
        ];
    }
 public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        //$scenarios['import_basica'] = ['edificio_id','parent_id','codtipo','imputable','numero','area','codpro'];
        $scenarios[self::SCENARIO_IMPORTACION] = ['codepa','codedificio','codtipo','mes','anio','lectura','flectura'];
        //$scenarios[self::SCENARIO_COMPLETO] = ['edificio_id','parent_id','codtipo','imputable','numero','area','codpro','npiso','nombre','detalles','estreno'];
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
      if($insert)
        $this->lecturaant=$this->lastReadNumeric(); 
      if($this->hasChanged('lectura'))
           $this->delta=$this->lectura-$this->lastReadNumeric();        
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
        
        $id_edificio= Edificios::find()->where(['codigo'=>$this->codedificio])->id;
        
        $id_unidad= SigiUnidades::find()->where([
            'codigo'=>$this->codepa,
        'edificio_id'=>$edificio->id,
            ])->one();
        
    }
    public function valida_depa($attribute, $params)
    {
        $edificio=Edificios::find()->where(['codigo'=>$this->codedificio]);
      if(is_null($edificio)){
          $this->addError('codedificio',yii::t('sigi.labels','El codigo de edificio no existe'));
          return;
      }       
   $depa= SigiUnidades::find()->where([
       'codigo'=>$this->codedpa,
        'edificio_id'=>$edificio->id,
       ])->one();
   if(is_null($depa)){
          $this->addError('codepa',yii::t('sigi.labels','El codigo de departamento para este edificio no existe'));
          return;
      } 
        
    }       
}
