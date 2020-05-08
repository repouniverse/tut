<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
      //die();  
        //echo Yii::$app->params['supportEmail']; die();
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }
  $mailer= Yii::$app
            ->mailer;
  $mailer->htmlLayout = 'layouts/html';
  $message=$mailer->compose();
        return
            $message/*->compose(
                [ 'html' => 'passwordResetToken-html', 
                  'img' => $message->embed(\Yii::getAlias('@frontend/web/img/logo_cabecera.png')),
                    //'html' => 'layouts/html', 
                    'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
           */->setHtmlBody($mailer->render('passwordResetToken-html', [
    'img' => $message->embed(\Yii::getAlias(\Yii::getAlias('@frontend/web/img/logo_cabecera.png'))),
        'user' => $user    
               ], $mailer->htmlLayout))     
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' -Restablecer contraseña'])
            ->setTo($this->email)
            ->setSubject(yii::t('base.verbs','Solicitud de cambio de contrasena') .'  '. Yii::$app->name)
            ->send();
    }
}
