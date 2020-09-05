<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%sta_convocatoria}}".
 *
 * @property int $id
 * @property int $talleresdet_id
 * @property string $codfac
 * @property string $canal
 * @property string $resultado
 * @property string $detalle
 *
 * @property StaFacultades $codfac0
 * @property StaTalleresdet $talleresdet
 */
class StaConvocatoria extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    const CANAL_CORREO='103';
    public $booleanFields=['resultado'];
    public $dateorTimeFields=[
        'fecha'=>self::_FDATE,
        /*'hora'=>self::_FHOUR*/];
    public static function tableName()
    {
        return '{{%sta_convocatoria}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['talleresdet_id'], 'integer'],
            [['codfac', 'canal'], 'required'],
            [['detalle'], 'string'],
             [['canal','fecha','resultado','clase','username','hora'], 'safe'], 
            [['codfac'], 'string', 'max' => 8],
            [['canal'], 'string', 'max' => 3],
           // [['resultado'], 'string', 'max' => 1],
            [['codfac'], 'exist', 'skipOnError' => true, 'targetClass' => Facultades::className(), 'targetAttribute' => ['codfac' => 'codfac']],
            [['talleresdet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleresdet::className(), 'targetAttribute' => ['talleresdet_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'talleresdet_id' => Yii::t('app', 'Talleresdet ID'),
            'codfac' => Yii::t('app', 'Codfac'),
            'canal' => Yii::t('app', 'Canal'),
            'resultado' => Yii::t('app', 'Respondió'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacultad()
    {
        return $this->hasOne(Facultades::className(), ['codfac' => 'codfac']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTalleresdet()
    {
        return $this->hasOne(Talleresdet::className(), ['id' => 'talleresdet_id']);
    }

    /**
     * {@inheritdoc}
     * @return StaConvocatoriaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaConvocatoriaQuery(get_called_class());
    }
     public function beforeSave($insert) {
       if($insert){   
           $this->username=\common\helpers\h::userName();
          $this->clase= \frontend\modules\sta\staModule::CLASE_RIESGO;
          
       }
           
        //$this->resolveDuration();
        return parent::beforeSave($insert);
       
    } 
   /* public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
         if($insert){            
         if($this->canal==self::CANAL_CORREO){
              $this->enviaCorreo();
          }
        }
    }*/
    
    public function enviaCorreo(){
        //$nombre=$this->talleresdet->alumno->fullName();
        $mailer = new \common\components\Mailer();
        $message =new  \yii\swiftmailer\Message();
            $message->setSubject('Notificación '.$this->talleresdet->talleres->descripcion)
            ->setFrom(['neotegnia@gmail.com'=>'Tutoría UNI'])
            ->setTo($this->talleresdet->alumno->correo)
            ->SetHtmlBody($this->detalle);
           
    try {
        
           $result = $mailer->send($message);
           $mensajes['success']='Se envió el correo';
    } catch (\Swift_TransportException $Ste) {      
         $mensajes['error']=$Ste->getMessage();
    }
    
    }
    
   
    
}
