<?php

namespace frontend\modules\sigi\controllers;

use Yii;
use frontend\modules\sigi\models\SigiUnidades;
use frontend\modules\sigi\models\SigiUnidadesSearch;
use frontend\modules\sigi\helpers\comboHelper;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
//use frontend\controllers\base\baseController;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * UnidadesController implements the CRUD actions for SigiUnidades model.
 */
class UnidadesController extends baseController
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
     * Lists all SigiUnidades models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SigiUnidadesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SigiUnidades model.
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
     * Creates a new SigiUnidades model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SigiUnidades();

        
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
     * Updates an existing SigiUnidades model.
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

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SigiUnidades model.
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
     * Finds the SigiUnidades model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SigiUnidades the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SigiUnidades::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
    }
    
     public function actionAgregaResidente($id){        
         $this->layout = "install";
         
        $modelunidad = $this->findModel($id);        
       $model=New \frontend\modules\sigi\models\SigiPropietarios();
       $model->unidad_id=$id;
        $model->edificio_id=$modelunidad->edificio_id;
        $model->codepa=$modelunidad->numero;
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                
                $model->save();
                //yii::error();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->unidad_id];
            }
        }else{
           return $this->renderAjax('_modal_residentes', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
    public function actionEditaResidente($id){        
         $this->layout = "install";
        $model=\frontend\modules\sigi\models\SigiPropietarios::findOne($id);
        if(is_null($model))
        throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                
                $model->save();
                //yii::error();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_residentes', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
     public function actionAgregaMedidor($id){        
         $this->layout = "install";
         
        $modelunidad = $this->findModel($id);        
       $model=New \frontend\modules\sigi\models\SigiSuministros();
       $model->unidad_id=$id;
       $model->edificio_id=$modelunidad->edificio_id;
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                
                $model->save();
                //yii::error();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->unidad_id];
            }
        }else{
           return $this->renderAjax('_modal_medidores', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
     public function actionEditaMedidor($id){        
         $this->layout = "install";
         
        //$modelunidad = $this->findModel($id);        
       $model=\frontend\modules\sigi\models\SigiSuministros::findOne($id);
        if(is_null($model))
        throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
      
       
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                
                $model->save();
                //yii::error();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model-id];
            }
        }else{
           return $this->renderAjax('_modal_medidores', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
     public function actionAgregaHijo($id){        
         $this->layout = "install";
         
        $modelunidad = $this->findModel($id);        
       $model=New \frontend\modules\sigi\models\SigiUnidades();
       $model->parent_id=$id;
       $model->edificio_id=$modelunidad->edificio->id;
       $model->codpro=$modelunidad->codpro;
       $model->esnuevo=$modelunidad->esnuevo;
        $model->imputable=$modelunidad->imputable;
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                
                $model->save();
                //yii::error();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->parent_id];
            }
        }else{
           return $this->renderAjax('_modal_hijos', [
                        'model' => $model,
                        'modelunidad' => $modelunidad,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
    
  public function actionFillApoderados(){
      
      if(h::request()->isAjax){
         // var_dump(h::request()->get('id'));die();
          $model=$this->findModel(h::request()->get('id'));
          
         $items= comboHelper::getCboApoderados(h::request()->get('id'));
         //var_dump($items);die();
         echo \yii\helpers\Html::renderSelectOptions('', $items);
      }
  }  
}
