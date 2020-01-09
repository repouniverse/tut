<?php

namespace frontend\modules\sigi\models;
USE common\models\masters\Clipro;
USE common\models\masters\Ums;
use Yii;

/**
 * This is the model class for table "{{%sigi_suministros}}".
 *
 * @property int $id
 * @property string $tipo
 * @property string $codpro
 * @property string $codsuministro
 * @property string $numerocliente
 * @property string $codum
 * @property int $unidad_id
 * @property string $detalles
 * @property int $frecuencia
 *
 * @property Ums $codum0
 * @property SigiUnidades $unidad
 * @property Clipro $codpro0
 */
class SigiSuministros extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    CONST COD_TYPE_SUMINISTRO_DEFAULT='101'; //medidor tipo agua 
    const SCENARIO_IMPORTACION='importacion_simple';
    public static function tableName()
    {
        return '{{%sigi_suministros}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo', 'codpro', 'codum', 'unidad_id'], 'required'],
            [['unidad_id', 'frecuencia'], 'integer'],
            [['detalles'], 'string'],
            [['tipo'], 'string', 'max' => 3],
            
            
            /*Escenario imortacion*/
             [['codepa'], 'valida_depa','on'=>self::SCENARIO_IMPORTACION],
             [['codepa','codedificio','tipo','codum','codpro'], 'required','on'=>self::SCENARIO_IMPORTACION],
              [['codepa','codedificio','tipo','codum','codpro'], 'safe','on'=>self::SCENARIO_IMPORTACION],
            
            [['codedificio'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['codedificio' => 'codigo'],'on'=>self::SCENARIO_IMPORTACION],
             //[['codepa'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['codedificio' => 'codigo']],
     
            
            
            [['codpro'], 'string', 'max' => 6],
            [['codsuministro'], 'string', 'max' => 12],
            [['numerocliente'], 'string', 'max' => 25],
            [['codum'], 'string', 'max' => 4],
            [['codum'], 'exist', 'skipOnError' => true, 'targetClass' => Ums::className(), 'targetAttribute' => ['codum' => 'codum']],
            [['unidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiUnidades::className(), 'targetAttribute' => ['unidad_id' => 'id']],
            [['codpro'], 'exist', 'skipOnError' => true, 'targetClass' => Clipro::className(), 'targetAttribute' => ['codpro' => 'codpro']],
        ];
    }
public function scenarios()
    {
        $scenarios = parent::scenarios(); 
       $scenarios[self::SCENARIO_IMPORTACION] = ['codepa','codedificio','tipo','codum','codpro'];
        return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'tipo' => Yii::t('sigi.labels', 'Tipo'),
            'codpro' => Yii::t('sigi.labels', 'Codpro'),
            'codsuministro' => Yii::t('sigi.labels', 'Codsuministro'),
            'numerocliente' => Yii::t('sigi.labels', 'Numerocliente'),
            'codum' => Yii::t('sigi.labels', 'Codum'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad ID'),
            'detalles' => Yii::t('sigi.labels', 'Detalles'),
            'frecuencia' => Yii::t('sigi.labels', 'Frecuencia'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUm()
    {
        return $this->hasOne(Ums::className(), ['codum' => 'codum']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidad()
    {
        return $this->hasOne(SigiUnidades::className(), ['id' => 'unidad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClipro()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }
public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }
    
    public function getLecturas()
    {
        return $this->hasMany(SigiLecturas::className(), ['suministro_id' =>'id']);
    }
    
    public function lastRead($fecha=null)
    {
        $query=$this->queryReads();
                
        if(is_null($fecha)){
            $query=$query->andWhere(['id'=>$this->queryReads()->max('id')]);
        }else{
           $query=$query->andWhere(['<=','flectura',static::SwichtFormatDate($fecha, 'date',false)])/*->andWhere(['<=','id',$this->queryReads()->max('id')])*/
                   ->orderBy('id desc')->limit(1); 
        }
        yii::error($query->createCommand()->getRawSql());
        return $query->one();
    }
      
    public function nextRead($fecha){
        $query=$this->queryReads()->
      andWhere(['>=','flectura',static::SwichtFormatDate($fecha, 'date',false)])->
      orderBy('id ASC')->limit(1);
        yii::error($query->createCommand()->getRawSql());
      return $query->one();  
    }
    
    /*Verifica con una fecha si esta fecha es mayor a cualquier lectura 
     * Corresponderia a una nueva lectura
     * En otro caso , habria ya una lectura con esta fecha o una fecha anterior
     * fecha   en formato dd/mm/yyyy (Formato usuario)
     */
    public function isDateForLastRead($fecha){
        return is_null($this->nextRead($fecha))?true:false;
    }
    
    
    private function queryReads(){
        return SigiLecturas::find()->where(['suministro_id' => $this->id]);
    }
    
    private function queryReadsForThisMonth($mes,$anio){
        return $this->queryReads()->
                andWhere(['mes' => $mes,'anio'=>$anio]);
    }
    
    
    public function consumoTotal($mes,$anio){
        $query=$this->queryReadsForThisMonth($mes,$anio);
        if($query->count()>0)
         return  $query->select('sum(lectura)')->scalar();
        return 0;
    }
    
    
    
    /**
     * {@inheritdoc}
     * @return SigiSuministrosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiSuministrosQuery(get_called_class());
    }
    
    public function ultimaLectura(){
      return 1;  
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
    /*private function medidor(){
       return  $this->depa()->firstMedidor(SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT);
    }*/
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
    }
    
  private function resolveIds(){ 
      if($this->getScenario()==self::SCENARIO_IMPORTACION){
         $this->edificio_id= $this->edificio()->id;        
        $this->unidad_id= $this->depa()->id;
        $this->numerocliente=substr($this->depa()->numero.'_'.$this->comboValueField('tipo'),0,25);
      }
        
       // $this->suministro_id=$this->medidor()->id;        
    }
    
 public function beforeSave($insert) {
      if($insert){
          $this->resolveIds();
        //$this->lecturaant=$this->lastReadNumeric();   
      }else{
          
      }  
        RETURN parent::beforeSave($insert);
    }
   
/*
 * Devuelve un array de lecturas 
 * 
 */
public function matrixReads(){
    
}
    
}
