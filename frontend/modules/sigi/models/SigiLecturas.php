<?php

namespace frontend\modules\sigi\models;
use  yii\web\ServerErrorHttpException;
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
    public $booleanFields=['facturable'];
    /**
     * {@inheritdoc}
     */
    const SCENARIO_IMPORTACION='importacion_simple';
    const SCENARIO_FLAG_FACTURACION='factur';
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
            [['suministro_id','lectura','flectura', 'unidad_id', 'mes','anio'], 'required','on'=>'default'],
            
            [['suministro_id', 'unidad_id', 'mes'], 'required','on'=>'default'],
            //[['suministro_id','mes', 'anio'], 'unique', 'targetAttribute' => ['mes']],
             [['suministro_id', 'unidad_id'], 'integer'],
            [['lectura', 'lecturaant', 'delta'], 'number'],
           // ['lectura', 'valida_lectura'],
            [['codepa'], 'string', 'max' => 12],
             [['mes'], 'safe'],
            /*
             * VALIDACIONES GENERALES
             */
             [['flectura'], 'validate_duplicado','except'=>self::SCENARIO_IMPORTACION],
            [['flectura'], 'validate_general'],
            /*******************/
            
             [['codedificio'], 'string', 'max' => 12], 
            [['codepa','codedificio','cuentaspor_id','facturable','codtipo','edificio_id','lecturaant'], 'safe'],
           
            /*Escenario imortacion*/
             [['codepa'], 'valida_depa','on'=>self::SCENARIO_IMPORTACION],
            // [['codepa'], 'valida_lectura','on'=>self::SCENARIO_IMPORTACION],
            [['flectura'], 'unique', 'targetAttribute' =>['codepa','mes','anio','codedificio', 'codtipo'] ,'on'=>self::SCENARIO_IMPORTACION],
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
        $scenarios[self::SCENARIO_IMPORTACION] = ['codepa','codedificio','codtipo','mes','anio','lectura','lecturaant','flectura'];
       $scenarios[self::SCENARIO_FLAG_FACTURACION] = ['cuentaspor_id'];
      
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
        $this->lecturaant=$this->lastReadValue(); 
         $this->delta=$this->lectura-$this->lecturaant;    
      }else{
         if($this->hasChanged('lectura'))
           $this->delta=$this->lectura-$this->lastReadValue();    
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
        if($this->getScenario()==self::SCENARIO_IMPORTACION){
          $this->facturable=true;
          $this->edificio_id= $this->edificio()->id;        
        $this->unidad_id= $this->depa()->id;
        $this->suministro_id=$this->medidor()->id;  
        }
    }
    public function valida_depa($attribute, $params)
    {
        yii::error('valida_depa '.$this->codepa);
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
        $edificio=Edificios::find()->where(['codigo'=>$this->codedificio])->one();
        //if(is_null($edificio))
          //throw new ServerErrorHttpException(Yii::t('base.errors','El código del edificio {codigo} no existe ',['codigo'=>$this->codedificio]));
    	return $edificio;
    }
    private function depa(){
        yii::error('funcion depa');
        yii::error(SigiUnidades::find()->where([
            'numero'=>$this->codepa,
            'edificio_id'=>$this->edificio()->id,
            ])->createCommand()->getRawSql());
       return  SigiUnidades::find()->where([
            'numero'=>$this->codepa,
            'edificio_id'=>$this->edificio()->id,
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
            return ($this->cuentaspor_id >0)?true:false;
        }
    }
    
    public function putFacturado($idcuentaspor){
        $oldscenario=$this->getScenario();
        $this->setScenario(self::SCENARIO_FLAG_FACTURACION);
        $this->cuentaspor_id=$idcuentaspor;
       $grabo=$this->save();
        $this->setScenario($oldscenario);
        return $grabo;
    }
    
    
    
    public function isDateForFirstRead(){
        return is_null($this->previousRead($this->flectura,$this->facturable))?true:false;
    }
    public function previousRead(){
        
       $this->hasCompleteCriteriaFields();       
       yii::error($this->facturable);
         $valorFacturable=($this->resolveFacturable())?'1':'0'; 
       //$valorFacturable='1'; 
        $query=self::find()->where(['suministro_id'=>$this->resolveSuministroId()])->
                 andWhere(['<>','id',!is_null($this->id)?$this->id:0])->
      andWhere(['facturable'=>$valorFacturable])->andWhere(['<=','flectura',static::SwichtFormatDate($this->flectura, 'date',false)])->
      orderBy('flectura DESC')->limit(1);
        yii::error('Sql previousRead');
        yii::error($query->createCommand()->getRawSql());
      return $query->one();  
    }
    
    public function isDateForLastRead(){
        return is_null($this->nextRead($this->flectura,$this->facturable))?true:false;
    }
    
    
    public function nextRead(){
       $this->hasCompleteCriteriaFields();        
        $valorFacturable=($this->resolveFacturable())?'1':'0';   
        $query=self::find()->where(['suministro_id'=>$this->resolveSuministroId()])->
                 andWhere(['<>','id',!is_null($this->id)?$this->id:0])->
      andWhere(['facturable'=>$valorFacturable])->andWhere(['>=','flectura',static::SwichtFormatDate($this->flectura, 'date',false)])->
      orderBy('flectura ASC')->limit(1);
        yii::error('Sql nextRead');
        yii::error($query->createCommand()->getRawSql(),__FUNCTION__);
      return $query->one();  
    }
    public function lastReadValue(){
        yii::error('** lastReadValue() **');
       
      $registro=$this->previousRead();
       yii::error('Registro '.(IS_NULL($registro)?' ES ':' NO ES ').'  NULO');
      return(is_null($registro))?$this->medidor()->liminf:$registro->lectura;
    } 
    public function nextReadValue(){
      $registro=$this->nextRead();
      return(is_null($registro))?$this->medidor()->limsup:$registro->lectura;
  } 
    private function hasCompleteCriteriaFields(){
        if(empty($this->flectura) || !is_bool($this->facturable) )
            throw new ServerErrorHttpException(Yii::t('base.errors', 'Las propiedades {valor} y {campo}  no son las adecuadas ',['valor'=>$this->getAttributeLabel('flectura'),'campo'=>$this->getAttributeLabel('facturable')]));
    		   
    }
  
    public function validate_general($attribute, $params){
        yii::error('**** validategeneral *****'.$this->codepa.'********');
          yii::error('isDateForFirstRead');  
          yii::error($this->isDateForFirstRead());  
          yii::error('isDateForLASTRead');  
          yii::error($this->isDateForLastRead()); 
          yii::error('lectura');  
          yii::error($this->lectura); 
           yii::error('ultima lectura');  
          yii::error($this->lastReadValue()); 
          
        if($this->isDateForFirstRead()){
            
        }elseif($this->isDateForLastRead()){
           
             if($this->lectura < $this->lastReadValue()){
                 yii::error('isDateForLastRead');
                 $this->addError('lectura',yii::t('sigi.errors','Hay una lectura anterior a esta fecha, y es mayor a la que pretende ingresar'));
             }
        }else{
             yii::error('Esta en el medio');
           if($this->lectura < $this->lastReadValue()){
               $this->addError('lectura',yii::t('sigi.errors','Hay una lectura anterior a esta fecha, y es mayor a la que pretende ingresar'));
           } 
           if($this->lectura > $this->nextReadValue()){
               $this->addError('lectura',yii::t('sigi.errors','Hay una lectura posterior a esta fecha, y  es menor a la que pretende ingresar'));
            
           } 
        }
        yii::error('*********Fin de validate general*************');
    }
      /*
       * Verifica si ya eiste un registor duplicado*/
      
    public function validate_duplicado(){
      if(!$this->facturable)
      return false;
      if(!$this->isNewRecord)
       return;
        $criteria=[
            'mes'=>$this->mes,
            'anio'=>$this->anio,
            'suministro_id'=>$this->suministro_id,
            'facturable'=>'1',
        ];
       if(self::find()->where($criteria)->exists())
       $this->addError('lectura',yii::t('sigi.errors','Ya hay una lectura facturable en el mismo periodo'));
            
    }
    
    private function resolveFacturable(){
        if($this->getScenario()==self::SCENARIO_IMPORTACION){
            return true;
        }else{
            if($this->facturable=='0')return false;
            if($this->facturable=='1')return true;
        }
    }
    private function resolveSuministroId(){
        if($this->getScenario()==self::SCENARIO_IMPORTACION){
            return $this->medidor()->id;
        }else{
            return $this->suministro_id;
        }
    }
}
