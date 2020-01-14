<?php

namespace frontend\modules\sigi;
use common\helpers\h;
USE \yii2mod\settings\models\enumerables\SettingType;
use frontend\modules\sigi\filters\FilterAccess;
/**
 * people module definition class amiugito
 */
class Module extends \yii\base\Module
{
  const CODIGOPERSONA_NATURAL='100000';
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\sigi\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        static::putSettingsModule();

        // custom initialization code goes here
    }
     public function behaviors(){
        return[
            [
            'class' => FilterAccess::className(), 
              //'except' => ['default/complete'],
            ],
        ];
    }
    
    
    
      private static function putSettingsModule(){
        h::getIfNotPutSetting('sigi','numeroMaxLecturas',5, SettingType::INTEGER_TYPE);
       //  h::getIfNotPutSetting('sigi','urlimagesalu','http:://www.orce.uni.edu.pe/alumnos/', SettingType::STRING_TYPE);
        // h::getIfNotPutSetting('sigi','prefiximagesalu','0060', SettingType::STRING_TYPE);
          return true;
    }
    
    
    
    public function getCodeNaturalPerson(){
        return self::CODIGOPERSONA_NATURAL;
    }
}
