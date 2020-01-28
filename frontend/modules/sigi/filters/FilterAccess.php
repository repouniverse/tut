<?php
namespace frontend\modules\sigi\filters;

use Yii;
use yii\base\ActionFilter;
use yii\helpers\Url;
use common\helpers\h;
/*
 * Este filtro se implementa para 

 */
class FilterAccess extends ActionFilter
{
    
    public function beforeAction($action)
    {
       // var_dump(yii::$app->controller->module);die();
     if(h::user()->isGuest){
        // echo "salio"; die();
         Url::remember(Url::current(),'intentona');
          yii::$app->controller->redirect(['/site/login']); 
     }
           
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
       
        return parent::afterAction($action, $result);
    }
}