<?php

namespace frontend\modules\sta\models;
//use common
use Yii;

/**
 * This is the model class for table "{{%plantilla_correos}}".
 *
 * @property int $id
 * @property int $programa_id
 * @property string $codfac
 * @property string $masivo
 * @property string $descripcion
 * @property string $disparador
 * @property string $titulo
 * @property string $cuerpo
 * @property string $detalles
 *
 * @property StaFacultades $codfac0
 */
class PlantillaCorreos extends \common\models\base\modelBase
{
    
         const DISPARADOR_CORREO_CREA_CITAS='100';
     const DISPARADOR_CORREO_REPROGRAMA_CITAS='102';
    /**
     * {@inheritdoc}
     */
    public $booleanFields=['masivo'];
    public $layout='';
    
    public static function tableName()
    {
        return '{{%plantilla_correos}}';
    }

    public function behaviors() {
        return [
           
            'auditoriaBehavior' => [
                'class' => '\common\behaviors\AuditBehavior',
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['programa_id'], 'integer'],
            [['programa_id','codfac', 'descripcion', 'disparador','remitente', 'titulo', 'cuerpo'], 'required'],
            [['cuerpo', 'detalles'], 'string'],
            [['codfac'], 'string', 'max' => 6],
            [['copiato','copiato2'], 'string', 'max' => 80],
             [['copiato','copiato2','remitente','programa_id','clase'], 'safe'],
            [['copiato','copiato2'], 'email'],
            [['descripcion'], 'string', 'max' => 40],
            [['disparador'], 'string', 'max' => 3],
            [['titulo'], 'string', 'max' => 60],
            [['codfac'], 'exist', 'skipOnError' => true, 'targetClass' => Facultades::className(), 'targetAttribute' => ['codfac' => 'codfac']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.labels', 'ID'),
            'programa_id' => Yii::t('base.labels', 'Programa asociado'),
            'codfac' => Yii::t('base.labels', 'Codfac'),
            'masivo' => Yii::t('base.labels', 'Masivo'),
            'descripcion' => Yii::t('base.labels', 'Descripcion'),
            'disparador' => Yii::t('base.labels', 'Disparador'),
            'titulo' => Yii::t('base.labels', 'Título del mensaje'),
             'copiato' => Yii::t('base.labels', 'Copiar a :'),
            'cuerpo' => Yii::t('base.labels', 'Cuerpo del mensaje'),
            'detalles' => Yii::t('base.labels', 'Detalles'),
             'remitente' => Yii::t('base.labels', 'Nombre del remitente'),
        ];
    }

    /**
     * Gets query for.
     *
     * 
     */
    public function getCodfac0()
    {
        return $this->hasOne(Facultades::className(), ['codfac' => 'codfac']);
    }

    /**
     * {@inheritdoc}
     * @return PlantillaCorreosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PlantillaCorreosQuery(get_called_class());
    }
    
    public function replaceVariables($array_variables){
        return str_replace(array_keys($array_variables),array_values($array_variables),$this->cuerpo);
    }
    
    public function messageNoMasivo($parametros,$correo,$copyTo=null){
        $copias=[/*'hipogea@hotmail.com'*/];
        $mailer = new \common\components\Mailer();
        $mailer->htmlLayout=$this->layout;
        $message =new  \yii\swiftmailer\Message();
        if(!empty($this->copiato)){
            $copias[]=$this->copiato;
           /// $copias[]='neotegnia@gmail.com';
          //$message->setCc('neotegnia@gmail.com');  
        }
        $message->setCc($copias);
        //$mailer->compose()->
            $message->setSubject($this->titulo)
            ->setFrom(['neotegnia@gmail.com'=>$this->remitente])
            ->setTo($correo)
            ->SetHtmlBody($this->replaceVariables($parametros));
        return $mailer->send($message);
    }
    
  public function beforeSave($insert) {
     
      $this->clase= \frontend\modules\sta\staModule::CLASE_RIESGO;
      RETURN parent::beforeSave($insert);
  }  
    
 
  
  
}
