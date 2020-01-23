<?php

namespace frontend\modules\sta;
use common\helpers\h;
use frontend\modules\sta\components\Profile;
use frontend\modules\sta\models\StaInterlocutor;
use common\helpers\FileHelper;
use frontend\modules\sta\filters\FilterAccess;
use frontend\modules\sta\models\Aluriesgo;
use linslin\yii2\curl;
use frontend\modules\sta\models\UserFacultades;
USE yii2mod\settings\models\enumerables\SettingType;
use frontend\modules\sta\models\Periodos;
use  yii\web\ServerErrorHttpException;
use yii;
/**
 * sta module definition class
 */
class staModule extends \yii\base\Module
{
    const USER_ALUMNO='10';
    const USER_OTROS='20';
    const RESPONSE_SUCCESS_CODE=200;
    
    CONST COD_INFORME_DEPARA='104';
    CONST COD_INFORME_TUTORIA_ACADEMICA='105';
    CONST COD_INFORME_TUTORIA_PSICOLOGICA='106';
     CONST COD_TRABAJADOR_PSICOLOGO='200';
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
             // 'except' => ['default/complete'],
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
    $hasExternal=self::externalUrlImage($codalu);
    /*VAR_DUMP($hasExternal);
    VAR_DUMP(FileHelper::checkUrlFound($hasExternal));DIE();*/
     if($hasExternal)
         return $hasExternal;
        return  FileHelper::getUrlImageUserGuest();  
    }
    
    private static function putSettingsModule(){
         h::getIfNotPutSetting('sta','formatDateFullCalendar',"YYYY-MM-DD HH:mm:ss", SettingType::STRING_TYPE);
        h::getIfNotPutSetting('sta','extensionimagesalu','.jpg', SettingType::STRING_TYPE);
         h::getIfNotPutSetting('sta','urlimagesalu','http:://www.orce.uni.edu.pe/alumnos/', SettingType::STRING_TYPE);
         h::getIfNotPutSetting('sta','prefiximagesalu','0060', SettingType::STRING_TYPE);
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
     return ['104','105','106'];
 } 
 
 public function isPcRegistered($taller_id){
     return models\StaIpslab::find()->
             where([
                 'taller_id'=>$taller_id,
                 'ip'=>h::request()->getUserIP()
                     ])->exists();
     
 }
  
}
