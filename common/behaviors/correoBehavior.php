<?php

namespace common\behaviors;
use yii;
use yii\base\Behavior;


/*
 * Esta clase se extiende de la clase original 
 * nemmo\attachments\behaviors\FileBehavior
 * Le ahorrara mucho trabajo al momento de trabajar
 * con archivos adjuntos, en especial sin son imagenes
 * 
 */

class correoBehavior extends Behavior {
    /*
     * Retorna un array de modelos 
     * con la info de archivos adjuntos filtrados por la extension
     * que  usted desea
     */
  public $nombrecampocorreo='correo';
  public $campodocu='codocu';
  
   public function mailSimple($destinatarios,$titulo,$mensaje,$from){
     $mailer = new \common\components\Mailer();
        $message =new  \yii\swiftmailer\Message();
            $message->setSubject($titulo)
            ->setFrom($from)
            ->setTo($destinatarios)
            ->SetHtmlBody($mensaje);
           
    try {
        
           $result = $mailer->send($message);
           $mensajes['success']='Se envió el correo, invitando al examen, el Alumno tiene que responder ';
    } catch (\Swift_TransportException $Ste) {      
         $mensajes['error']=$Ste->getMessage();
    }
    return $mensajes;
   }
   
   public function destinatariosMail(){
       
   }
}
