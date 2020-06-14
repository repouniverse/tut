<?php

namespace frontend\modules\sta;
use common\helpers\h;
use frontend\modules\sta\components\Profile;
use frontend\modules\sta\models\StaInterlocutor;
use common\helpers\FileHelper;
use common\filters\FilterAccess;
use frontend\modules\sta\models\Aluriesgo;
use linslin\yii2\curl;
use frontend\modules\sta\models\UserFacultades;
USE yii2mod\settings\models\enumerables\SettingType;
use frontend\modules\sta\models\Periodos;
use  yii\web\ServerErrorHttpException;
use common\helpers\timeHelper;
use yii;
/**
 * sta module definition class
 */
class staModule extends \yii\base\Module
{
    const CLASE_RIESGO='M';
    const CLASE_REGULAR='N';
    
    
    const USER_ALUMNO='10';
    const USER_OTROS='20';
    const RESPONSE_SUCCESS_CODE=200;
    const REPORTE_TEST=9;
    const LEVEL_ACCESS_PROFILE_BAJO='bajo';
    const LEVEL_ACCESS_PROFILE_MEDIO='medio';
    const LEVEL_ACCESS_PROFILE_ALTO='alto';
   
    
    const PROFILE_INVITADO='10';
     const PROFILE_TUTOR_ACADEMICO='20';
       const PROFILE_PSICOLOGO='30';
     const PROFILE_ASISTENTE='40';
       const PROFILE_AUTORIDAD='50';
      const PROFILE_ADMIN='60';
      
      
 public STATIC  $tipos=[
     self::LEVEL_ACCESS_PROFILE_BAJO=>[
         self::PROFILE_INVITADO,
     self::PROFILE_TUTOR_ACADEMICO,
      
      ],
     self::LEVEL_ACCESS_PROFILE_MEDIO=>[self::PROFILE_INVITADO,
     self::PROFILE_TUTOR_ACADEMICO,
         self::PROFILE_ASISTENTE,
       ],
     self::LEVEL_ACCESS_PROFILE_ALTO=>[self::PROFILE_INVITADO,
     self::PROFILE_TUTOR_ACADEMICO,
         self::PROFILE_ASISTENTE,
         self::PROFILE_PSICOLOGO,
         self::PROFILE_AUTORIDAD,
         self::PROFILE_ADMIN
         ]
     
 ];  
 
 public static function levelAccess(){
     $tipo=h::user()->profile->tipo;
     $retorno=self::LEVEL_ACCESS_PROFILE_BAJO;
   foreach(static::$tipos as $nivel=>$perfiles) {
       if(in_array($tipo,$perfiles)){
           $retorno=$nivel;
           break;
       }
   } 
  return $retorno;
 }
 
     /* const MENSAJE_INFORME_104='STA_INF_104';
       const MENSAJE_INFORME_105='STA_INF_105';
        const MENSAJE_INFORME_106='STA_INF_106';
       const MENSAJE_INFORME_107='STA_INF_107';
         const MENSAJE_CORREO_='STA_MAIL_CI';
       const MENSAJE_INFORME_105='MSG_105';
        const MENSAJE_INFORME_106='MSG_106';
       const MENSAJE_INFORME_107='MSG_107';*/
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\sta\controllers';
    public $_currentPeriod=null;
    /**
     * {@inheritdoc}
     */
    public function behaviors(){
        return[
           [
            'class' => FilterAccess::className(), 
            'except' => [
                'citas/examen-banco',
                'citas/respuesta-examen',
                'citas/termina-examen',
                ],
            ],
        ];
    }
    
    
    public function init()
    {
        parent::init();
        static::putSettingsModule();
        //$this->_currentPeriod=
        static::getCurrentPeriod();
        /*if(is_null(static::getInterlocutor())){
             //var_dump(\yii::$app->controller)  ;die();
        }
           */
      //  h::app()->controller->redirect(['/sta/default/completar']);

        // custom initialization code goes here
    }
    
    public static function getProfile(){
        return Profile::find()->where(['user_id'=>h::userId()])->one();
    }
    public static function getInterlocutor(){
        $reg=static::getProfile();
       // var_dump($reg->attributes);die();
        if(is_null($reg)){
            return null;
        }else{
           return  StaInterlocutor::find()->where(['profile_id'=>$reg->id])->one();
        }
        //return (is_null($reg))?null:StaInterlocutor::find()->where(['profile_id'=>$reg->id])->one();
    }
   public function hasInterlocutor(){
       return (is_null(static::getInterlocutor()))?false:true;
   }
    
    public static function isAlumno(){
       if(h::UserIsGuest()){
           return false;
       }else{
          return(h::user()->identity->tipo==self::USER_ALUMNO)?true:false;
           
       }
    }
    
    /*Localiza la ruta de las imagenes 
     * de un servidor remoto mediante un Url
     * 
     */
    public static function getPathImage($codalu){
     if(h::gsetting('sta','showImgOrce') or h::user()->profile->recexternos){
          $hasExternal=self::externalUrlImage($codalu);
         if($hasExternal)
         return $hasExternal;
        return  FileHelper::getUrlImageUserGuest();  
     } else{
        return  FileHelper::getUrlImageUserGuest();   
     }
   
    }
    
    private static function putSettingsModule(){
        h::getIfNotPutSetting('sta','formatDateFullCalendar',"YYYY-MM-DD HH:mm:ss", SettingType::STRING_TYPE);
        h::getIfNotPutSetting('sta','extensionimagesalu','.jpg', SettingType::STRING_TYPE);
         h::getIfNotPutSetting('sta','urlimagesalu','http:://www.orce.uni.edu.pe/alumnos/', SettingType::STRING_TYPE);
         h::getIfNotPutSetting('sta','prefiximagesalu','0060', SettingType::STRING_TYPE);
         h::getIfNotPutSetting('sta','regexcodalu','/[1-9]{1}[0-9]{3}[0-9]{1}[0-9]{3}[A-Z]{1}/', SettingType::STRING_TYPE);
          h::getIfNotPutSetting('sta','horainicio','17:00', SettingType::STRING_TYPE);
           h::getIfNotPutSetting('sta','horafin','17:00', SettingType::STRING_TYPE);
            h::getIfNotPutSetting('sta','nhorasantesevento',24, SettingType::INTEGER_TYPE);
    h::getIfNotPutSetting('sta','notificacitasmail',true, SettingType::BOOLEAN_TYPE);
       h::getIfNotPutSetting('sta','notificavencimientocitasmail',true, SettingType::BOOLEAN_TYPE);
       h::getIfNotPutSetting('sta','nhorasavisarcita',24, SettingType::INTEGER_TYPE);
        h::getIfNotPutSetting('sta','showImgOrce',true, SettingType::BOOLEAN_TYPE);
    }
    
   private static function  externalUrlImage($codalu){
      $extension=h::settings()->get('sta','extensionimagesalu');
        if(!(substr($extension,0,1)=='.'))
         $extension='.'.$extension;
        
      $urlExt= FileHelper::normalizePath(
             h::settings()->get('sta','urlimagesalu').DIRECTORY_SEPARATOR
            .h::settings()->get('sta','prefiximagesalu') 
            .$codalu
            .$extension,'/');   
     // VAR_DUMP($urlExt,'https://www.orce.uni.edu.pe/fotosuni/006019930117K.jpg');DIE();
      if(FileHelper::checkUrlFound($urlExt)){
          return $urlExt;
      }else{
        return false; 
      }
   }
   
   private static function  localUrlImage(){
     
        
      return FileHelper::normalizePath(
             h::settings()->get('sta','urlimagesalu').DIRECTORY_SEPARATOR
            .h::settings()->get('sta','prefiximagesalu').DIRECTORY_SEPARATOR 
            .$codalu
            .$extension);    
   }
    
   
   public function getCurrentPeriod(){
    $modelo=Periodos::findOne(['activa'=>'1']);
     if(is_null($modelo))
          throw new ServerErrorHttpException(Yii::t('sta.errors', 'No se encontró ningun periodo Activo, debe activar un Periodo'));
         return $modelo->codperiodo; 

     
   }
   /*
    * Retormna un font awseome de acuerdo a la facultad*/
    
  public static function faAwesomeFac($codfac){
      return [
          'FIIS'=>'<span class="fa fa "></span>'
      ];
  }
  
  
  public static function formatDateFullCalendar(){
      return h::gsetting('sta','formatDateFullCalendar');
      
  }

 public static function docCodes(){
     return ['104','105','106','107'];
 } 
  
 
 
 
 public static  function notificaMailCitasProximas(){
     $validator=new yii\validators\EmailValidator();
      $mensajes=[];
       $mailer = new \common\components\Mailer();
        $message =new  \yii\swiftmailer\Message();
        
     $contador=0;
    foreach(static::queryCitasProximas() as $fila){
      if($validator->validate($fila['correo'])){
          if(static::enviacorreo($fila,$mailer,$message))
          $contador++;
      }
    }
    unset($mailer);unset($message);unset($validator);
   return $contador;
 }
 
 private static function enviacorreo($fila,$mailer,$message){
      
        $nombrealumno=$fila['codalu'].'  :  '.$fila['nombres'].'-'.$fila['ap'].'-'.$fila['am'];
        $psicologo=$fila['codigotra'].'  :  '.$fila['nombrestutor'].'-'.$fila['aptutor'].'-'.$fila['amtutor'];
            $message->setSubject('Cita pendiente '.$fila['numerocita'])
            ->setFrom([h::gsetting('mail','userservermail')=>'Oficina de Tutoría Psicológica UNI'])
            ->setTo($fila['correo'])
            ->SetHtmlBody("Buenas Tardes :".$nombrealumno." <br>"
                    . "La presente es para notificarle que tienes "
                    . "una cita  programada por la OFICINA DE TUTORÍA PSICOLÓGICA.<br> "
                    . "Cuándo : ".$fila['fechaprog']."<br>"
                    . "Profesional a Cargo :  ".$psicologo."  <br><br>"
                    . "Contamos con tu presencia <br>"
                    . "Muchas Gracias por tu atención.");
           
    try {
        
           $result = $mailer->send($message);
           return true;
          //$mensajes['success']='Se envió el correo,  ';
    } catch (\Swift_TransportException $Ste) {      
         return false;
    }
   
     
     
 }
 private static function queryCitasProximas(){
   $horas=h::gsetting('sta','nhorasavisarcita');    
    $fechaInicial= \Carbon\Carbon::now()->
            addHours($horas)->
            format(timeHelper::formatMysqlDateTime()); 
   
    $fechaFinal= \Carbon\Carbon::now()->addHours(24)->
            format(timeHelper::formatMysqlDateTime());
    
  $query=h::obQuery()->select([
         'd.ap as aptutor',
         'd.am as amtutor',
         'd.nombres as nombrestutor','d.codigotra',
      'c.codalu','c.ap','c.am','c.nombres','c.correo',
         'a.fechaprog','a.numero as numerocita',
        ])
    ->from(['b'=>'{{%sta_talleresdet}}'])->
     innerJoin('{{%sta_alu}} c', 'c.codalu=b.codalu')->
     innerJoin('{{%sta_talleres}} s', 's.id=b.talleres_id')->          
      innerJoin('{{%sta_citas}} a', 'a.talleresdet_id=b.id')->
      innerJoin('{{%trabajadores}} d', 'd.codigotra=a.codtra')->
      andWhere(['>=','a.fechaprog',$fechaInicial])
      ->andWhere(['<=','a.fechaprog',$fechaFinal])->andWhere(['not',['correo'=>null]]); 
    yii::error('El query de citas',__FUNCTION__);
    yii::error($query->createCommand()->getRawSql(),__FUNCTION__); 
    return $query->all();
 }
 

}
