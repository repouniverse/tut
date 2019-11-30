<?php

namespace frontend\modules\sigi\models;
USE frontend\modules\sigi\models\SigiUnidades;
USE common\helpers\h;
USE common\models\masters\Clipro;
use Yii;

/**
 * This is the model class for table "{{%sigi_propietarios}}".
 *
 * @property int $id
 * @property int $unidad_id
 * @property string $tipo
 * @property string $correo
 * @property string $correo1
 * @property string $correo2
 * @property string $celulares
 * @property string $fijo
 * @property string $dni
 * @property string $participacion
 * @property string $detalle
 * @property string $activo
 * @property string $finicio
 * @property string $fcese
 *
 * @property SigiUnidades $unidad
 */
class SigiPropietarios extends \common\models\base\modelBase
{
    CONST SCENARIO_EMPRESA='empresa';
    public $booleanFields=['espropietario','recibemail'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_propietarios}}';
    }
 public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios[self::SCENARIO_EMPRESA] = ['unidad_id','tipo','dni','nombre','espropietario'];
       // $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];
        return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unidad_id', 'tipo','nombre'], 'required'],
            [['unidad_id'], 'integer'],
            [['participacion'], 'number'],
             [['recibemail','nombre','espropietario','user_id'], 'safe'],
            [['detalle'], 'string'],
            [['dni'], 'valida_dni'],
            [['tipo', 'activo'], 'string', 'max' => 1],
             [['correo', 'correo1', 'correo2'], 'email'],
            [['correo', 'correo1', 'correo2', 'celulares'], 'string', 'max' => 70],
            [['fijo', 'dni'], 'string', 'max' => 12],
            [['finicio', 'fcese'], 'string', 'max' => 10],
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
            'unidad_id' => Yii::t('sigi.labels', 'Unidad ID'),
            'tipo' => Yii::t('sigi.labels', 'Tipo'),
            'correo' => Yii::t('sigi.labels', 'Correo'),
            'correo1' => Yii::t('sigi.labels', 'Correo1'),
            'correo2' => Yii::t('sigi.labels', 'Correo2'),
            'celulares' => Yii::t('sigi.labels', 'Celulares'),
            'fijo' => Yii::t('sigi.labels', 'Fijo'),
            'dni' => Yii::t('sigi.labels', 'Dni'),
            'participacion' => Yii::t('sigi.labels', 'Participacion'),
            'detalle' => Yii::t('sigi.labels', 'Detalle'),
            'activo' => Yii::t('sigi.labels', 'Activo'),
            'finicio' => Yii::t('sigi.labels', 'Finicio'),
            'fcese' => Yii::t('sigi.labels', 'Fcese'),
        ];
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
     * @return SigiPropietariosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiPropietariosQuery(get_called_class());
    }
    
    public function beforeSave($insert){
        if($insert){
            $this->activo=true;
        }
        return parent::beforeSave($insert);
    }
    
    public function valida_dni($attribute, $params)
    {
        $error=false;
     if(!((preg_match(h::settings()->get('general','formatoDNI'),$this->dni)==1) or 
        (preg_match(h::settings()->get('general','formatoRUC'),$this->dni)==1)
        )){
        $this->addError('dni',yii::t('sigi.errors','El valor para este campo no es correcto, debe ser un DNI o un RUC'));
    
      } 
            }
            
   public function valida_propietario($attribute, $params)
    {
       if($this->isNewRecord){
           $esnuevo=Unidad::findOne()->esnuevo;
       }ELSE{
          $esnuevo=$this->unidad->esnuevo;
       }
       if($this->tipo=SigiUnidades::TYP_INQUILINO && 
          $esnuevo){
           $this->addError('nombre','No se permiten inquilinos en un departamento sin entregar');
       }
       
       
     } 
}
