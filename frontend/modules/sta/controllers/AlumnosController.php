<?php

namespace frontend\modules\sta\controllers;

use Yii;
use frontend\modules\sta\models\Alumnos;
use frontend\modules\sta\models\Aluriesgo;
use frontend\modules\sta\models\AluriesgoSearch;
use frontend\modules\sta\models\AlumnosSearch;
use frontend\modules\sta\models\VwAluriesgoSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use frontend\modules\sta\staModule;
/**
 * AlumnosController implements the CRUD actions for Alumnos model.
 */
class AlumnosController extends baseController
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
     * Lists all Alumnos models.
     * @return mixed
     */
    public function actionIndex()
    {
          
         
        //var_dump(\frontend\modules\sta\models\Facultades::find()->select('codfac')->asArray()->all());die();
        $searchModel = new AlumnosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    
    public function actionAlumnosRiesgo()
    {
        
        //var_dump(\frontend\modules\sta\models\Facultades::find()->select('codfac')->asArray()->all());die();
        $searchModel = new VwAluriesgoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

       
        return $this->render('alumnosRiesgo', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Alumnos model.
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
     * Creates a new Alumnos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Alumnos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Alumnos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Alumnos model.
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
     * Finds the Alumnos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Alumnos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Alumnos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('sta.labels', 'The requested page does not exist.'));
    }
    
    
   public function actionVerDetalles($id){
       $model=$this->findModel($id);
       //var_dump(Aluriesgo::cursosByStudentPeriod());
       $codperiodo=staModule::getCurrentPeriod();
       if(is_null(h::request()->get('codperiodo'))){
          $codperiodo=staModule::getCurrentPeriod();  
       }else{
           $codperiodo=h::request()->get('codperiodo');
       }
       if(is_null(h::request()->get('codfac'))){
          $codfac=$model->codfac;  
       }else{
           $codfac=h::request()->get('codfac');
       }
       $taller= \frontend\modules\sta\models\Talleres::find()->
               where(['codfac'=>$codfac,'codperiodo'=>$codperiodo])->one();
       if(is_null($taller) ){
             return $this->render('_nohayprograma',['model'=>$model,'codperiodo'=>$codperiodo]);
       }ELSE{
         $modelTallerdet= \frontend\modules\sta\models\Talleresdet::find()->where(['codalu'=>$model->codalu,'talleres_id'=>$taller->id])->one();
          if(is_null($modelTallerdet) ){
                return $this->render('_nohayprograma',['model'=>$model,'codperiodo'=>$codperiodo]);
       
            }ELSE{
               
               $dataProviders=$this->generateProviders($model->codalu,$model->periodsInRisk());
                
               return $this->render('/alumnos/auxiliares/_form_view_alu',
               ['model'=>$model,
                'dataProviders'=>$dataProviders,
                'modelTallerdet'=>$modelTallerdet,
                'codperiodo'=>$codperiodo]);    
            }
       }
        
       
       
       
   } 
   private function generateProviders($codalu,$periods){
       $arr=[];
    foreach($periods as $period){
        $arr[$period]= Aluriesgo::cursosByStudentPeriodProvider($codalu,$period);
     }
     return $arr;
   }
   
   public function actionAjaxRenderInforme(){
       if(h::request()->isAjax){
           //$codalu=h::request()->get('codalu');
          // $urlReport=h::request()->get('idreport');
           $this->layout="install";
          return $this->render('/alumnos/auxiliares/_informePDF',[
               //'codalu'=>$codalu,
               // 'urlReport'=>$urlReport,
           ]);
       }
   }
}
