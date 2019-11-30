<?php
namespace frontend\modules\sigi\models;
use frontend\modules\sigi\Module as SigiModule;
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
    const SCENARIO_HIJO='hijo';
    const SCENARIO_EDIFICIO='edificio';
    const SCENARIO_BASICO='import_basica';
    public $booleanFields=['esnuevo'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_unidades}}';
    }

    
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codtipo', 'npiso','codpro', 'edificio_id', 'numero', 'nombre','area'], 'required'],
            [['npiso', 'edificio_id', 'parent_id'], 'integer'],
           ['numero', 'unique', 'targetAttribute' => ['edificio_id','numero']],
            [['area', 'participacion'], 'number'],
            [['detalles'], 'string'],
            [['codpro'.'esnuevo'], 'safe'],
            [['estreno'], 'safe'],
            [['codtipo'], 'string', 'max' => 4],
            [['numero'], 'string', 'max' => 12],
            [['nombre'], 'string', 'max' => 25],
            [['codtipo'], 'exist', 'skipOnError' => true, 'targetClass' => SigiTipoUnidades::className(), 'targetAttribute' => ['codtipo' => 'codtipo']],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
            [['codpro'], 'exist', 'skipOnError' => true, 'targetClass' => Clipro::className(), 'targetAttribute' => ['codpro' => 'codpro']],
        ];
    }

    
      public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios['import_basica'] = ['edificio_id','codtipo','numero','area','codpro'];
        $scenarios[self::SCENARIO_HIJO] = ['destalles','estreno','codtipo','numero','area','numero','area','npiso','nombre','participacion'];
// $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];
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
             'codpro' => Yii::t('sigi.labels', 'Tenencia'),
            'npiso' => Yii::t('sigi.labels', 'Piso'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio'),
            'numero' => Yii::t('sigi.labels', 'Numero'),
            'nombre' => Yii::t('sigi.labels', 'Nombre'),
            'area' => Yii::t('sigi.labels', 'Area (m2)'),
            'participacion' => Yii::t('sigi.labels', '% Part'),
            'parent_id' => Yii::t('sigi.labels', 'Padre'),
            'detalles' => Yii::t('sigi.labels', 'Detalles'),
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
            if(empty($this->nombre)){
              $this->nombre=substr(SigiTipoUnidades::findOne($this->codtipo)->desunidad.'-'.$this->numero,0,25); 
            }
                
        }
        return parent::beforeSave($insert);
    }
    public function afterSave($insert, $changedAttributes)  {
         if($insert){
            if($this->codpro <> SigiModule::getCodeNaturalPerson()){
                //$this->estreno=null;
               $this->insertPropietarioEmpresa() ;
            } 
         } 
        return parent::afterSave($insert, $changedAttributes);
    }
    public function hasChildunits(){
        return($this->getChildsUnits()->count()==0)?true:false;
    }
    
    public function isEntregado(){
        return (empty($this->estreno))?false:true;
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
      if($this->isNewRecord)
       $edificio=Edificios::find()->one(['id'=>$this->edificio_id]);
       $edificio=$this->edificio;
       if(!$edificio->hasApoderados())
        $this->addError ('edificio_id',yii::t('sigi.errors','El edificio no tiene Apoderados'));
      if(!in_array($this->codpro,$edificio->apoderados()))
       $this->addError ('codpro',yii::t('sigi.errors','Este apoderado no esta registrado en el edificio'));
      
        
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
  
}
