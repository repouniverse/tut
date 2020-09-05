<?php

namespace frontend\modules\sigi\models;
use frontend\modules\sigi\models\SigiPropietarios;
use Yii;

/**
 * This is the model class for table "{{%sigi_transferencias}}".
 *
 * @property int $id
 * @property int $edificio_id
 * @property int $unidad_id
 * @property string $fecha
 * @property string $tipotrans
 * @property string $nombre
 * @property string $correo
 * @property string $dni
 * @property int $parent_id
 *
 * @property SigiEdificios $edificio
 * @property SigiUnidades $unidad
 */
class SigiTransferencias extends \common\models\base\modelBase
{
   const TRANS_VENTA='10';
    public $dateorTimeFields=['fecha'=>self::_FDATE];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_transferencias}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edificio_id', 'unidad_id', 'fecha', 'tipotrans', 'nombre','codpro'], 'required'],
            [['edificio_id', 'unidad_id', 'parent_id'], 'integer'],
            [['fecha'], 'string', 'max' => 10],
            [['tipotrans'], 'string', 'max' => 2],
            [['correo'], 'email'],
            [['codpro','parent_id','fecha','edificio_id','tipotrans','correo','dni','codproant'], 'safe'],
            [['codpro'], 'validateCodpro'],
            [['nombre', 'correo'], 'string', 'max' => 60],
            [['dni'], 'string', 'max' => 14],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
            [['unidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiUnidades::className(), 'targetAttribute' => ['unidad_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'unidad_id' => Yii::t('sigi.labels', 'Unidad ID'),
            'fecha' => Yii::t('sigi.labels', 'Fecha'),
            'tipotrans' => Yii::t('sigi.labels', 'Tipotrans'),
            'nombre' => Yii::t('sigi.labels', 'Nuevo Prop'),
            'codpro' => Yii::t('sigi.labels', 'Gr. Gestión'),
            'correo' => Yii::t('sigi.labels', 'Correo'),
            'dni' => Yii::t('sigi.labels', 'Dni'),
            'parent_id' => Yii::t('sigi.labels', 'Parent ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidad()
    {
        return $this->hasOne(SigiUnidades::className(), ['id' => 'unidad_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiTransferenciasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiTransferenciasQuery(get_called_class());
    }
    
    public function afterSave($insert,$ChangedAttributes){
       if($insert){
           if($this->tipotrans==self::TRANS_VENTA){
               $this->insertPropietario();
               $this->resolveCodpro();
             
           }
       }
        return parent::afterSave($insert,$ChangedAttributes);
    }
    
    public function beforeSave($insert){
       if($insert){
           $this->codproant=$this->unidad->codpro;
       }
        return parent::beforeSave($insert);
    }
    
    
    
    private function insertPropietario($mentirita=false){
        
        SigiPropietarios::updateAll([
             'activo'=>'0',
             'fcese'=>$this->swichtDate('fecha',false),
            ],
                [
                   'unidad_id'=>$this->unidad_id,
                   'tipo'=> SigiUnidades::TYP_PROPIETARIO 
                    
                ]); 
        
        
        
        $model=new SigiPropietarios();
        $model->setAttributes([
            'unidad_id'=>$this->unidad_id,
            'edificio_id'=>$this->edificio_id,
              'tipo'=> SigiUnidades::TYP_PROPIETARIO, 
             'correo'=>$this->correo,
            'nombre'=>$this->nombre,
              'finicio'=> $this->fecha
        ]);
       if($mentirita){
          return $model->validate();  
       }else{
           return $model->save();  
       }
       
    }
    
    public function resolveCodpro(){
      $unidad=$this->unidad;
                $unidad->setScenario($unidad::SCENARIO_BASICO);            
                $unidad->codpro=$this->codpro;
                $unidad->save();  
    }
    
    public function resolveParent(){
         yii::error('----resolve parent----');
           yii::error($this->attributes);
       if(!is_null($this->parent_id)){
                $unidad=$this->unidad;
                $unidad->setScenario($unidad::SCENARIO_PARENT);            
                $unidad->parent_id=$this->parent_id;
               IF(!$unidad->save()){
                 yii::error('fallo----');
                 yii::error($unidad->getErrors());  
               }
                
       }
        }  
       
     public function unResolveParent(){
       
                $unidad=$this->unidad;
                $unidad->setScenario($unidad::SCENARIO_PARENT);            
                $unidad->parent_id=null;
                $unidad->save();
       
     }   
 
    private function resolveTransferencia(){
      //Primero actualizamos la unidad 
      $unidad=$this->unidad;
       $unidad->setScenario($unidad::SCENARIO_PARENT);
      /*Si e shijo , lo liberamos */
      if($unidad->isChild()){      
        $unidad->parent_id=null;
      }
      /* Si sel destinooes un padre los actualizamos igual*/
      if(!is_null($this->parent_id)){         
        $unidad->parent_id=$this->parent_id;
      }
      //actualizamos le parent_id  einsertamos el propietario 
      if( $unidad->save()  && $this->insertPropietario(true)){
         //Ahora acualizamos los propietarios*/ 
        SigiPropietarios::updateAll([
             'activo'=>'0',
             'fcese'=>$this->swichtDate('fecha',false),
            ],
                [
                   'unidad_id'=>$this->unidad_id,
                   'tipo'=> SigiUnidades::TYP_PROPIETARIO 
                    
                ]); 
        $this->insertPropietario(false);
      }
      
       //ahora insertamos el nuevo propietario
    }
    
   public function validateCodpro($attribute, $params)
    {
     //no puede haber un codpro con un parent_id  incosistentes
       if($this->parent_id >0 ){
          $codpro= SigiUnidades::findOne($this->parent_id)->codpro;
          if($codpro <> $this->codpro)
            $this->addError('codpro',yii::t('sigi.errors','La unidad padre tiene grupo de gestion {grupo} diferente al ingresado {ingresadndo}',['grupo'=>$codpro,'ingresado'=>$this->codpro]));
       }
       
    }
}
