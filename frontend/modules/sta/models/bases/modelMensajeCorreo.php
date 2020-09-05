<?php

namespace frontend\modules\sta\models\bases;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class modelMensajeCorreo extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $destinatarios;
    public $verifyCode;
    public $message_id;
   public $replyTo;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            [['body'], 'validateBody'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
           // ['verifyCode', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
            'email' => 'Recibir respuesta en :',
            'destinatarios' => 'Destinatarios',
            'body'=> 'Mensaje',
            'subject'=> 'Asunto',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($emails)
    { /*return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();*/
    
    $mailer= Yii::$app
            ->mailer;
  $mailer->htmlLayout = 'layouts/html';
  $message=$mailer->compose();
        return
            $message->setHtmlBody(
                $mailer->render('comunicado_correo-html', [
                                                'contenido'=>$this->body,
                                                'img' => $message->embed(\Yii::getAlias(\Yii::getAlias('@frontend/web/img/logo_cabecera.png'))),
                                                'destinatario' => 'Dra Dany',   
                                                        ], 
                        $mailer->htmlLayout
                              ))     
            ->setFrom([$this->email => $this->name])
           ->setReplyTo($this->replyTo)  
            ->setTo($emails)
            ->setSubject($this->subject)
            ->send();
    }
    
  public function  validateBody($attribute, $params){
      if(empty($this->body)){
          $this->addError('body',yii::t('sta.errors','El texto del mensaje no está lleno')); 
      }else{
         if(strlen(trim($this->body)) < 14 ){
            $this->addError('body',yii::t('sta.errors','El texto del mensaje no está lleno'));
         }
      }
  }
  
  public static function allCorreos(){
      $codperiodo= \frontend\modules\sta\staModule::getCurrentPeriod();
      $idstaller=\frontend\modules\sta\models\Talleres::find()->select(['id'])->andWhere(['codperiodo'=>$codperiodo])->column();
      $codalus=\frontend\modules\sta\models\Talleresdet::except()->select(['codalu'])->andWhere(['talleres_id'=>$idstaller])->column();
      return \frontend\modules\sta\models\Alumnos::find()->select(['correo'])->where(['codalu'=>$codalus])->column();
      
  }
  
}
