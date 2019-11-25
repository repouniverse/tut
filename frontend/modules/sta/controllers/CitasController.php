<?php

namespace frontend\modules\sta\controllers;

use Yii;
use frontend\modules\sta\models\StaVwCitas;
use frontend\modules\sta\models\Citas;
use frontend\modules\sta\models\CitasSearch;
use frontend\modules\sta\models\StaVwCitasSearch;
use frontend\modules\sta\models\Examenes;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use frontend\controllers\base\baseController;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * CitasController implements the CRUD actions for Citas model.
 */
class CitasController extends baseController
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
     * Lists all Citas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaVwCitasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Citas model.
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
     * Creates a new Citas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Citas();
        
        
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
     * Updates an existing Citas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $eventos=$model->putColorThisCodalu($model->eventosPendientes());
        return $this->render('update', [
            'model' => $model,
            'eventos'=>$eventos,
        ]);
    }

    /**
     * Deletes an existing Citas model.
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
     * Finds the Citas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Citas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Citas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('sta.labels', 'The requested page does not exist.'));
    }
    
    public function actionAjaxConfirmaAsistencia(){
        if(h::request()->isAjax){
            $model=$this->findModel(h::request()->get('id'));
            $model->setScenario($model::SCENARIO_ASISTIO);
            $model->asistio=true;
             h::response()->format = Response::FORMAT_JSON;
            if($model->save()){
                return ['success'=>yii::t('sta.messages','Se confirmó asistencia')];
            }else{
               return ['error'=>yii::t('sta.messages','Hubo error al confirmar asistencia: '.$model->getFirstError())];  
            }
        }
    }
    
   public function actionAgregaExamen($id){
    $this->layout = "install";
         
        $modelCita = $this->findModel($id);        
       $model=New \frontend\modules\sta\models\Examenes();
       $model->citas_id=$id;
       
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_examen', [
                        'model' => $model,
                        'modelCita'=>$modelCita,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
}   

 public function actionEditaExamen($id){
    $this->layout = "install";
       $model=Examenes::findOne($id);
        h::response()->format = \yii\web\Response::FORMAT_JSON;
     if(is_null($model))
      return ['error'=>2,'msg'=>yii::t('sta.errors','No se encontro este registro para ')];  
       
       $datos=[];
        if(h::request()->isPost){
             yii::error('dio post');
            $model->load(h::request()->post());
             //h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
                
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save();
                if($model->hasErrors()){
                    yii::error($model->getErrors());
                  return ['error'=>1,'id'=>$model->id];   
                }
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_examen', [
                        'model' => $model,
                        'modelCita'=>$model->cita,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
}   
    
    
}
