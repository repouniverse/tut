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
use yii\widgets\ActiveForm;
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
       //$model=new \frontend\modules\sta\models\Citas(); 
        //echo $model->findOne(1210)->obtenerEtapaId(); die();
       /* $model=new \frontend\modules\sta\models\StaEventos();
        $model->fechaprog='21/02/2020 13:00:45';
        VAR_DUMP($model->toCarbon('fechaprog')->subHours(1)->format('Y-m-d H:i:s'),
                $model->toCarbon('fechaprog')->addHours(24)->format('Y-m-d H:i:s'),
                date('Y-m-d H:i:s'),$model->isDateToWork());DIE();
        */
      /* echo  \common\models\base\modelBase::getGeneralFormat(
               'd/m/Y',
               'date',
               FALSE
               );
       die(); */
        // print_r(\frontend\modules\sta\components\Indicadores::IAsistenciasPorFacultad());die();
      
       /* \frontend\modules\sta\models\Examenes::findOne(161)->makeResultados();
        \frontend\modules\sta\models\Examenes::findOne(162)->makeResultados();
        \frontend\modules\sta\models\Examenes::findOne(163)->makeResultados();
        \frontend\modules\sta\models\Examenes::findOne(164)->makeResultados();
        \frontend\modules\sta\models\Examenes::findOne(165)->makeResultados();
        \frontend\modules\sta\models\Examenes::findOne(166)->makeResultados();
       \frontend\modules\sta\models\Examenes::findOne(167)->makeResultados();
        die();
        */
        /*print_r(\frontend\modules\sta\models\Test::findOne('T0021')->arrayRawCalificaciones()) ;
        die();*/
       // $model= \frontend\modules\sta\models\StaDocuAlu::findOne(79);
       // $model->hasBehavior
       // var_dump($model->hasMethod('canDownload'),$model->getBehavior('AccessDownloadBehavior'));
       /* $valores=[0,1,2,3,4,5,6];
        $valoresInv=[6,5,4,3,2,1,0];
        var_dump(array_search(2, $valores));
       
        var_dump(array_search(2, $valoresInv));
        die();
        
        
        die();*/
         
        //var_dump(\frontend\modules\sta\models\Facultades::find()->select('codfac')->asArray()->all());die();
        $searchModel = new AlumnosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
     public function actionReincorporados()
    {
       
        //var_dump(\frontend\modules\sta\models\Facultades::find()->select('codfac')->asArray()->all());die();
        $searchModel = new AluriesgoSearch();
        $dataProvider = $searchModel->searchByIncorporado(Yii::$app->request->queryParams);

        return $this->render('reincorporados', [
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
                /*
                 * Sacando los examenes que se han tomado 
                 */
                $examenes=$modelTallerdet->examenesTomados();
                $citasArray=$modelTallerdet->getCitas()->orderby('fechaprog asc')/*->asArray()*/->all();
               
               $dataProviders=$this->generateProviders($model->codalu,$model->periodsInRisk());
                
               return $this->render('/alumnos/auxiliares/_form_view_alu',
               ['model'=>$model,
                'dataProviders'=>$dataProviders,
                'modelTallerdet'=>$modelTallerdet,
                 'citasArray'=> $citasArray,
                 'examenes'=>$examenes,  
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
   
  public function actionIncorporar(){
      $model= new Aluriesgo();
      $model->codperiodo= staModule::getCurrentPeriod();
      $model->setScenario($model::SCENARIO_REGISTER);
       
      if (h::request()->isAjax && $model->load(h::request()->post())) {
         // var_dump($model->codfac);DIE();
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
        }
        
        
        
        if ($model->load(h::request()->post()) && $model->save()) {
            return $this->redirect(['alumnos-riesgo']);
           // return $this->redirect(['incorporados', 'id' => $model->id]);
        }

        return $this->render('crea_reincorporado', [
            'model' => $model,
        ]);
  } 
   
   public function actionEditaIncorporado($id){
      $model=Aluriesgo::findOne($id);
      if($model===null){
         throw new NotFoundHttpException(Yii::t('sta.labels', 'No se ha encontrado el registro con ese id'));
     
      }
      //$model->codperiodo= staModule::getCurrentPeriod();
      $model->setScenario($model::SCENARIO_REGISTER);
      if (h::request()->isAjax && $model->load(h::request()->post())) {
          //var_dump($model->codfac);
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
        }
        
        
        
        if ($model->load(h::request()->post()) && $model->save()) {
            return $this->redirect(['alumnos-riesgo']);
        }

        return $this->render('crea_reincorporado', [
            'model' => $model,
        ]);
  } 
}
