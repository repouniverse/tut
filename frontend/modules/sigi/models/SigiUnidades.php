<?php
namespace frontend\modules\sigi\models;
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
            [['codpro'], 'safe'],
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
             'codpro' => Yii::t('sigi.labels', 'Apoderado'),
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
         if(!$porcentaje)
           $areaTotal=$areaTotal*100;
         return $areaTotal;
         
        if($areaTotal>0){
            return $this->area/$areaTotal;
        }else{
           return 0; 
        }  
      }
       
        
    }
}
