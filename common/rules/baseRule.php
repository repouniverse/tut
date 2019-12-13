<?php
use common\rule\baseRule;
use yii\rbac\Rule;
/**
 * Comprueba si authorID coincide con el usuario pasado como parámetro
 */
class baseRule extends Rule
{
    public $name = 'isOwnerForThisModel';

    public function execute($user, $item, $params)
    {
        $model=$params['model'];
        if(is_object($model)){
            
        }else{
           $model=$model::instance();
        }
        
        /*Sacamos 
        
        //return isset($params['post']) ? $params['post']->createdBy == $user : false;
    }
}
