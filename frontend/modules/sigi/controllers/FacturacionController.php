<?php

namespace frontend\modules\sigi\controllers;

use Yii;
use frontend\modules\sigi\models\SigiFacturacion;
use frontend\modules\sigi\models\SigiFacturacionSearch;
use frontend\modules\sigi\models\SigiCuentasporSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * FacturacionController implements the CRUD actions for SigiFacturacion model.
 */
class FacturacionController extends baseController
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
     * Lists all SigiFacturacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SigiFacturacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SigiFacturacion model.
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
     * Creates a new SigiFacturacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SigiFacturacion();
        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SigiFacturacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
          $searchModel = new SigiCuentasporSearch();
         $dataProviderCuentasPor = $searchModel->searchByFactu($model->id);

        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'dataProviderCuentasPor' =>$dataProviderCuentasPor,
        ]);
    }

    /**
     * Deletes an existing SigiFacturacion model.
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
     * Finds the SigiFacturacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SigiFacturacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
            
    {
        if (($model = SigiFacturacion::findOne($id)) !== null) {
            return $model;
        }
        

        throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
    }
   
    
    
    public function actionFacturacionMes($id){
        if (h::request()->isAjax) {
            $errores=[];
                h::response()->format = Response::FORMAT_JSON;
           $model=$this->findModel($id);
           $errores=$model->generateFacturacionMes();
           if(count($errores)>0){
               return $errores;
           }else{
               return ['success'=>'Se ha generado la facturación del mes'];
           }
       }
       
    }
    
    public function actionResetFacturacionMes($id){
        if (h::request()->isAjax) {
            //$errores=[];
                h::response()->format = Response::FORMAT_JSON;
           $model=$this->findModel($id);
\frontend\modules\sigi\models\SigiDetfacturacion::deleteAll(['facturacion_id'=>$model->id]);
           return ['success'=>yii::t('sigi.labels','Se ha reinicado la facturación')];
       }
       
    }
}
