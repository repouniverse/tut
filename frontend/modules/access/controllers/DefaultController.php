<?php

namespace frontend\modules\access\controllers;
use common\helpers\ComboHelper;
use frontend\modules\access\models\modelSensibleAccess;
use yii\web\Controller;

/**
 * Default controller for the `access` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionPermissionModel()
    {
        $modelos=$this->filterModels(ComboHelper::getCboModels());
        return $this->render('permisos',['modelos'=>$modelos]);
    }
    
    
    
    public function actionAjaxCreatePermission(){
        
    }
}
