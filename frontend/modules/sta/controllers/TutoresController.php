<?php
namespace frontend\modules\sta\controllers;
use Yii;
use frontend\modules\sta\models\Talleres;
use frontend\modules\sta\models\Talleresdet;
use common\models\masters\Trabajadores;
use frontend\modules\sta\staModule;
use frontend\modules\sta\models\TalleresSearch;
use frontend\modules\sta\models\Tallerpsico;
use frontend\modules\sta\models\VwAlutallerSearch;
use frontend\modules\sta\models\AlumnosSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use common\helpers\h;
USE common\widgets\buttonsubmitwidget\buttonSubmitWidget;

/**
 * ProgramasController implements the CRUD actions for Talleres model.
 */
class TutoresController extends baseController
{
     public $nameSpaces = ['frontend\modules\sta\models'];
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
     * Lists all Talleres models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new \frontend\modules\sta\models\VwStaTutoresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Talleres model.
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
     * Creates a new Talleres model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Talleres();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Talleres model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDetalle($id)
    {
        $model=  $this->findModel($id);
        //$codfacultad=$model->taller->codfac;
        $citasPendientes=$model->eventosPendientes();
         $searchAlumnos = new VwAlutallerSearch();
        $dataProviderAlumnos = $searchAlumnos->searchByFacultad(
                h::request()->queryParams,$model->taller->codfac);
        $items=$model->alumnosPendientes();
        //sacamos las citas pendientes de este Psicólogo
        //desde el presente hasta el futuro
        
        
        
      return $this->render('consola_psicologo',[
                    'model'=>$model,
                    'items'=>$items,
                     'citasPendientes'=>$citasPendientes,
                       'dataProvider'=> $dataProviderAlumnos
                    ] ); 
        
       
    }
protected function findModel($id)
    {
        if (($model = Tallerpsico::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('sta.labels', 'No se encontro el registro '));
    }
 
    
   public function actionPruebaModal(){
     $this->layout = "install";
      $searchModel = new AlumnosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         return $this->renderAjax('_alumnos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
       
       
     } 
  
   public function actionPsicologo($codtra){
     $model=Trabajadores::findOne(['codigotra'=>$codtra]);
       if(is_null($model)){
           
       } else{
           //var_dump($model->codpuesto,staModule::COD_TRABAJADOR_PSICOLOGO);
           if($model->codpuesto== staModule::COD_TRABAJADOR_PSICOLOGO){
              $idProgramas= Talleresdet::find()->select('talleres_id')->where(['codtra'=>$codtra])->column();
              $providerTalleresAntiguos=  new \yii\data\ActiveDataProvider([
                                'query' => Talleres::find()->where(['id'=>$idProgramas])->andWhere(['<>','codperiodo',staModule::getCurrentPeriod()])->orderBy('codperiodo DESC'),
                                    'pagination' => [
                                        'pageSize' => 20,
                                            ],
                                        ]);
             $providerTalleresActivos=  new \yii\data\ActiveDataProvider([
                                'query' => Talleres::find()->where(['id'=>$idProgramas])->andWhere(['codperiodo'=> staModule::getCurrentPeriod()])->orderBy('codperiodo DESC'),
                                    'pagination' => [
                                        'pageSize' => 20,
                                            ],
                                        ]);
             
             return $this->render('consola/_psicologo',['model'=>$model, 'providerTalleresActivos'=>$providerTalleresActivos,  'providerTalleresAntiguos'=>$providerTalleresAntiguos]);
             
           }
       }

    }
    
public function actionPendientes($id){
    $this->layout="install";
    $taller=Talleres::findOne($id);
   return $this->render('consola/pendientes',[
     'cpendientes'=>$taller->citasPendientesQuery()->count(),
       'crealizadas'=>$taller->citasRealizadasQuery()->count(),      
      'choy'=>$taller->citasForTodayQuery()->count(),      
     'week'=>$taller->citasForThisWeekQuery()->count()]);
}


}
