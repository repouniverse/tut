<?php
namespace frontend\modules\sta\filters;
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
       // header('location: http://www.neotegnia.com');
       //var_dump(yii::$app->controller->module);die();
     if(h::user()->isGuest){
         //header('location: http://www.neotegnia.com');
        //echo "hola"; die();
      //var_dump(h::response()->content); die();
         Url::remember(Url::current(),'intentona');
        header('location: http://case.itekron.com/frontend/web/site/login');
         //var_dump(yii::$app->controller->redirect(['/sitryyr8686e/login']));die();
          return yii::$app->controller->redirect(['/site/login']); 
           //return parent::beforeAction($action);
     }else{
         
     }
       return parent::beforeAction($action); 
       
    }

    public function afterAction($action, $result)
    {
       
        return parent::afterAction($action, $result);
    }
}