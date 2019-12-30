<?php
namespace frontend\modules\sigi\models;
use frontend\modules\sigi\Module as SigiModule;
use frontend\modules\sigi\interfaces\colectoresInterface;
use common\models\masters\Clipro;
use Yii;

/**
 * This is the model class for table "{{%sigi_unidades}}".
 *
 * @property int $id
 * @property string $codtipo
 * @property int $npiso
 * @property int $edificio_id
 * @property string $numero
 * @property string $nombre
 * @property string $area
 * @property string $participacion
 * @property int $parent_id
 * @property string $detalles
 *
 * @property SigiPropietarios[] $sigiPropietarios
 * @property SigiSuministros[] $sigiSuministros
 * @property SigiTipounidad $codtipo0
 * @property SigiEdificios $edificio
 */
class SigiUnidades extends \common\models\base\modelBase
{
    const TYP_PROPIETARIO='P';
    const TYP_INQUILINO='I';
     //const TYP_EX_PROPIETARIO='E';
    //const TYP_EX_INQUILINO='X';
    const SCENARIO_HIJO='import_hijos';
    const SCENARIO_EDIFICIO='edificio';
    const SCENARIO_COMPLETO='import_completo';
    const SCENARIO_BASICO='basica';
    const SCENARIO_UPDATE_BASICO='update_basico';
    public $booleanFields=['esnuevo','imputable'];
    public $hardFields=['edificio_id','numero'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_unidades}}';
    }

    public $codpadre='';//PARA HACER UN ARTIDFICIO EN LA IMPORTACION DE 
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codtipo', 'npiso','edificio_id','codpro', 'numero', 'nombre'], 'required'],
            [['npiso', 'edificio_id'], 'integer'],
            ['numero', 'unique', 'targetAttribute' => ['edificio_id','numero']],
            [['area', 'participacion'], 'number'],
            ['imputable', 'validateArea'],
            //['imputable', 'validateArea'],
            ['parent_id', 'validateParent',
                'except' => ['import_basica',self::SCENARIO_UPDATE_BASICO,self::SCENARIO_HIJO,self::SCENARIO_COMPLETO]
             ],
            ['id', 'required',
                'on' => [self::SCENARIO_UPDATE_BASICO]
             ],
            [['codpro'], 'validateApoderado'],
            [['detalles'], 'string'],
            [['codpro','esnuevo','codpadre'], 'safe'],
            [['estreno','imputable'], 'safe'],
            [['codtipo'], 'string', 'max' => 4],
            [['numero'], 'string', 'max' => 12],
            [['nombre'], 'string', 'max' => 25],
             [
                 ['parent_id'], 'resolveParent',
                'on'=>[self::SCENARIO_HIJO,self::SCENARIO_COMPLETO]
              ],
            [['codtipo'], 'exist', 'skipOnError' => true, 'targetClass' => SigiTipoUnidades::className(), 'targetAttribute' => ['codtipo' => 'codtipo']],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
            [['codpro'], 'exist', 'skipOnError' => true, 'targetClass' => Clipro::className(), 'targetAttribute' => ['codpro' => 'codpro']],
        ];
    }

    
      public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios['basica'] = ['edificio_id','codtipo','imputable','npiso','numero','area','codpro'];
        $scenarios[self::SCENARIO_HIJO] = ['edificio_id','parent_id','codtipo','imputable','numero','area','codpro','npiso'];
        $scenarios[self::SCENARIO_COMPLETO] = ['edificio_id','parent_id','codtipo','imputable','numero','area','codpro','npiso','nombre','detalles','estreno'];
        $scenarios[self::SCENARIO_UPDATE_BASICO] = ['id','imputable','codpro'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'codtipo' => Yii::t('sigi.labels', 'Tipo'),
             'codpro' => Yii::t('sigi.labels', 'G Gestión'),
            'npiso' => Yii::t('sigi.labels', 'Piso'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio'),
            'numero' => Yii::t('sigi.labels', 'Numero'),
            'nombre' => Yii::t('sigi.labels', 'Nombre'),
            'area' => Yii::t('sigi.labels', 'Area (m2)'),
            'participacion' => Yii::t('sigi.labels', '% Part'),
            'parent_id' => Yii::t('sigi.labels', 'Padre'),
            'detalles' => Yii::t('sigi.labels', 'Detalles'),
            'imputable' => Yii::t('sigi.labels', 'Imputable'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSigiPropietarios()
    {
        return $this->hasMany(SigiPropietarios::className(), ['unidad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSigiSuministros()
    {
        return $this->hasMany(SigiSuministros::className(), ['unidad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(SigiTipoUnidades::className(), ['codtipo' => 'codtipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }
    
     public function getChildsUnits()
    {
        return $this->hasMany(SigiUnidades::className(), ['parent_id' => 'id']);
    }
    
     public function getPadre()
    {
        return $this->hasOne(SigiUnidades::className(), ['id' => 'parent_id']);
    }
    
     public function getClipro()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }

    /**
     * {@inheritdoc}
     * @return SigiUnidadesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiUnidadesQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert){
            $this->arreglaParent();
            if(empty($this->nombre)){
              $this->nombre=substr(SigiTipoUnidades::findOne($this->codtipo)->desunidad.'-'.$this->numero,0,25); 
            }
                
        }
        return parent::beforeSave($insert);
    }
    public function afterSave($insert, $changedAttributes)  {
         if($insert){
            /*if($this->codpro <> SigiModule::getCodeNaturalPerson()){
                //$this->estreno=null;
               $this->insertPropietarioEmpresa() ;
            } */
         } 
        return parent::afterSave($insert, $changedAttributes);
    }
    public function hasChildunits(){
        return($this->getChildsUnits()->count()==0)?true:false;
    }
    
    public function isEntregado(){
        return (empty($this->estreno))?false:true;
    }
    
    public function resolveParent($attribute, $params){
        //Sio se trata de una imortacion 
        if(substr($this->getScenario(),0,6)=='import'){
            if(!empty($this->parent_id)){
               $registro= $this->find()->where([
                   'numero'=>$this->parent_id,
                     'edificio_id'=>$this->edificio_id,   
                       ])->one();
               if(is_null($registro)){
                   $this->addError ('parent_id',yii::t('sigi.errors','Este número de unidad no está registrado en el edificio'));
      
               } else{
                   if($registro->codpro <> $this->codpro){
                       yii::error('este es l nombnre : '.$registro->nombre);
                       $this->addError ('parent_id',yii::t('sigi.errors','La unidad padre "{nombre}" tiene otro grupo de gestión "{gpadre}" <> "{ghijo}" ',['nombre'=>$registro->id,'gpadre'=>$registro->codpro,'ghijo'=>$this->codpro]));  
                   }
               }
                
            }
        }
       
    }
    
    /*CALCULA LA PARTICIPACION */
    
    public function participacion($porcentaje=false){
      if($this->isNewRecord){
          return 0;
      }else{
         $areaTotal=$this->edificio->area();
         /*if(!$porcentaje){
              $areaTotal=$areaTotal*100;
         return $areaTotal;
         }
          */
         
        if($areaTotal>0){
            return round(($this->area*(($porcentaje)?100:1))/$areaTotal,4);
        }else{
           return 0; 
        }  
      }
       
        
    }
    /*
     * Se estrena este departamento
     */
    public function estrenar($fecha,$apoderado){
        
    }
    
    public function validateApoderado($attribute, $params)
    {
      /*verificar que el edificio a asignar tiene apoderadoso*/
      if($this->isNewRecord){
         $edificio=Edificios::find()->where(['id'=>$this->edificio_id])->one(); 
         if(is_null($edificio)){
              $this->addError ('edificio_id',yii::t('sigi.errors','El edificio no Existe'));
              return; 
         }
           
      }
       
     
      
       $edificio=$this->edificio;
       if(!$edificio->hasApoderados())
        $this->addError ('edificio_id',yii::t('sigi.errors','El edificio no tiene Grupos de gestión'));
      if(!in_array($this->codpro,$edificio->apoderados()))
       $this->addError ('codpro',yii::t('sigi.errors','Esta empresa no esta registrado en el edificio'));
      
        
    }
    /*
     * Se encarga solode arreglar el campo parent_id para que 
     * se grabe correctamente al momento de imortar masivamenrwe 
     */
    private function arreglaParent(){
        if(substr($this->getScenario(),0,6)=='import' && ( !empty($this->parent_id))){
            $this->parent_id= $this->find()->where([
                   'numero'=>$this->parent_id,
                     'edificio_id'=>$this->edificio_id,   
                       ])->one()->id; 
        }
           
    }
    public function validateArea($attribute, $params)
    {
      /*verificar que cuando es imputable area debe ser obligatorio*/
        yii::error($this->imputable);
        if(empty($this->area) && $this->imputable){
            $this->addError('area',yii::t('sigi.errors','Esta unidad es imputable y debe de tener participación'));
        }
      
    }
    
    public function validateParent($attribute, $params)
    {
      /*verificar que cuando es imputable area debe ser obligatorio*/
        //yii::error($this->imputable);
        if(!empty($this->parent_id)){
           $registro= $this->find()->where([
                   'id'=>$this->parent_id,
                     'edificio_id'=>$this->edificio_id,   
                       ])->one();
               if(is_null($registro)){
                   $this->addError ('parent_id',yii::t('sigi.errors','Este número de unidad no está registrado en el edificio'));
      
               } else{
                   if($registro->codpro <> $this->codpro){
                       $this->addError ('parent_id',yii::t('sigi.errors','La unidad padre tiene otro grupo de gestión "{gpadre}" ',['gpadre'=>$registro->codpro,'ghijo'=>$this->codpro]));  
                   }
               }
              
           
        }
      
    }
   
  private function insertPropietarioEmpresa(){
      $atributos=[
         'unidad_id'=>$this->id,
          'tipo'=>self::TYP_PROPIETARIO,
          'espropietario'=>true,
          'nombre'=>Clipro::find()->where(['codpro'=>$this->codpro])->one()->despro,
          'dni'=>Clipro::find()->where(['codpro'=>$this->codpro])->one()->rucpro,
      ];
      SigiPropietarios::firstOrCreateStatic($atributos, SigiPropietarios::SCENARIO_EMPRESA);
  }  
   
  
  public static function treeBase($edificio_id){
       $datos=static::find()->where(['edificio_id'=>$edificio_id])->asArray()->all();
       foreach($datos as $fila){
         $keyTree='uni_'.$fila['id'];
         $array_tree['items'][]=[             
                       'icon'=>'fa fa-couch',
                       'title' => $fila['nombre'],
                       'lazy' => true ,
                       // 'OTHER'=>'holis',
                          'key'=>$keyTree,
             'children' => [
                        ['title' => yii::t('base.names','Unidades'),'tooltip'=>'fill-unidades_'.$fila['id'],'key'=>$keyTree.'_unidades'],
                        ['title' => yii::t('base.names','Documentos'),'tooltip'=>'fill-documentos_'.$fila['id'],'key'=>$keyTree.'_documentos'],
                        ['title' => yii::t('base.names','Colectores'),'tooltip'=>'fill-grupos_'.$fila['id'],'key'=>$keyTree.'_grupos'],                       
                    ],
                        ];
       }
     
   }
  
   
   
   public function CalculoColector(colectoresInterface $colector){
      return $colector->factorProRateo()->montoTotal()->insertCosto();
      
   }
   
   
  
   
   
   public function firstMedidor($type){
       return $this->getSigiSuministros()->andWhere(['tipo'=>$type])->one();
   }   
   
   public function currentResidente(){
      return SigiPropietarios::find()->where(
               ['unidad_id'=>$this->id]
               )->andWhere(
               ['activo'=>'1']
               )->one();
   }
}
