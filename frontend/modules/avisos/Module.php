<?php

namespace frontend\modules\avisos;
USE yii2mod\settings\models\enumerables\SettingType;
use common\helpers\h;
use frontend\modules\avisos\models\AvisosTablonSearch;
/**
 * avisos module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\avisos\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        self::putSettingsModule();
        parent::init();

        // custom initialization code goes here
    }
    
    private static function putSettingsModule(){
        h::getIfNotPutSetting('avisos','userAdministrador',"administrador", SettingType::STRING_TYPE);
         }
         
    public STATIC function hasAvisosActuales(){
       return (AvisosTablonSearch::searchCurrents()->count>0);
    }
    
}
