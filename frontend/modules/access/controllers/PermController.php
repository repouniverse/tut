<?php

namespace frontend\modules\access\controllers;
use common\helpers\ComboHelper;
use frontend\modules\access\models\modelSensibleAccess;
use Yii;
use frontend\modules\access\models\AccessModelPermiso;
use frontend\modules\access\models\AccessModelPermisoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use frontend\controllers\base\baseController;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * PermController implements the CRUD actions for AccessModelPermiso model.
 */
class PermController extends baseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AccessModelPermiso models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccessModelPermisoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AccessModelPermiso model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AccessModelPermiso model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AccessModelPermiso();
         $modelos=$this->filterModels(ComboHelper::getCboModels());
        //return $this->render('permisos',['modelos'=>$modelos]);
        
        $model->permiso=$model::generateNamePersmission();
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        
            //var_dump($model->load(Yii::$app->request->post()));
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
           // print_r($model->getErrors());
        }

        return $this->render('create', [
            'model' => $model,'modelos'=>$modelos
        ]);
    }

    /**
     * Updates an existing AccessModelPermiso model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
  $modelos=$this->filterModels(ComboHelper::getCboModels());
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,'modelos' => $modelos,
        ]);
    }

    /**
     * Deletes an existing AccessModelPermiso model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AccessModelPermiso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AccessModelPermiso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AccessModelPermiso::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('sta.labels', 'The requested page does not exist.'));
    }
    
    private function filterModels($rawModels){
        $filteredModels=[];
        foreach($rawModels as $modelPath=>$modelShortName){
           // $class = new \ReflectionClass($modelPath);
            //$class->getConstants()
           if(is_subclass_of($modelPath, modelSensibleAccess::className())){
              $filteredModels[$modelPath]=$modelShortName;
           }
          
        }
        return $filteredModels;
    }
    
}
