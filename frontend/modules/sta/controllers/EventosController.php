<?php

namespace frontend\modules\sta\controllers;
use frontend\modules\sta\models\Talleres;
use frontend\modules\sta\models\Talleresdet;
use frontend\modules\sta\models\Citas;
use Yii;
use frontend\modules\sta\models\StaEventos;
use frontend\modules\sta\models\StaEventosSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
//use frontend\controllers\base\baseController;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * EventosController implements the CRUD actions for StaEventos model.
 */
class EventosController extends baseController
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
     * Lists all StaEventos models.
     * @return mixed
     */
    public function actionIndex()
    {
        //StaEventos::findOne(9)->notificaCitas();die();
        
        
        $searchModel = new StaEventosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StaEventos model.
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
     * Creates a new StaEventos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        
        $modelTaller=Talleres::findOne($id);
        if(is_null($modelTaller))
         throw new NotFoundHttpException(Yii::t('sta.labels', 'No se encontró el registro del programa con el id '.$id));
            $model = new StaEventos();
            $model->talleres_id=$id;
            $model->semana=date('W')+0;
           // echo $model->semana;DIE();
            $model->codfac=$modelTaller->codfac;
       yii::error('pasando');
        if (h::request()->isAjax && $model->load(h::request()->post())) {  
             yii::error('validando ajax pasando');
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
         yii::error('no es ajax'); 
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           
          
            return $this->redirect(['view', 'id' => $model->id]);
        }
 yii::error('pasa mano'); 
        return $this->render('create', [
            'model' => $model,
            //'searchModel' => $searchModel,
        ]);
    }

    /**
     * Updates an existing StaEventos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        //die();
        $model = $this->findModel($id);
        
         
        $searchModel = new \frontend\modules\sta\models\StaEventosdetSearch();
        $dataProvider = $searchModel->searchByEvento($id,Yii::$app->request->queryParams);
        
        if ($this->is_editable())
            return $this->editField();

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
             'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Deletes an existing StaEventos model.
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
     * Finds the StaEventos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StaEventos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        
       // var_dump(StaEventos::findOne($id)); die();
        if (($model = StaEventos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('sta.labels', 'The requested page does not exist.'));
    }
    
    public function actionCreateAllCitas($id){
        if(h::request()->isAjax){
        h::response()->format = \yii\web\Response::FORMAT_JSON;
        $model=  \frontend\modules\sta\models\StaEventos::findOne($id);
        if(is_null($model))
         return ['error'=>yii::t('sta.errors','No se encontró el registro para este id '.$id)];
        $detalles=$model->getDetalles()->andWhere(['asistio'=>'1'])->all();
        foreach($detalles as $eventodetalle){
            $eventodetalle->createCita($model->codtra,$model->fechaprog, $model->tipo);
        }
        }
    }
     public function actionCreaCita($id){
         if(h::request()->isAjax){
        h::response()->format = \yii\web\Response::FORMAT_JSON;
        $model=  \frontend\modules\sta\models\StaEventosdet::findOne($id);
        if(is_null($model))
         return ['error'=>yii::t('sta.errors','No se encontró el registro para este id '.$id)];
        if(!$model->evento->isDateToWork())
        return ['error'=>yii::t('sta.errors','No se encuentra dentro de las fechas de trabajo')]; 
        
        if(!$model->asistio){
           return ['error'=>yii::t('sta.errors','Confirme la asistencia primero ')];
        }elseif(empty($model->correo)){ 
            return ['error'=>yii::t('sta.errors','Registre el correo primero ')];
        }else{
            
            //var_dump($model->evento->fechaprog,$model::SwichtFormatDate($model->evento->fechaprog,$model::_FDATETIME,false));die();
          
             $evento=$model->evento;
            
         
            /*******************************************************
             * Si se presenta un error desabuliatar esta pedazo de codigo
             ************************************************/
           
          //$codtra=$evento->talleres->psicologoPorDia($evento->toCarbon('fechaprog'));
          //if(!$codtra)
          $codtra=$evento->codtra;
            /****************************
             * Fin del pedazo de codigo
             ************************************/
            
          
          
            /*********************************************
             * Y habilitar esta linea 
             ***********************************************/
           // $codtra=$model->evento->codtra;
             /* fin de la linea  ha habilitar
              ****************************************/
          //return ['error'=>'SE HA ITERUMPIDO EL SERVICIO POR UN MOMENTO ...ESPERE'];
            $cita=$model->createCita($codtra,/*$evento->fechaprog*/null,$evento->tipo);
            if(is_array($cita)){
               // VAR_DUMP(array_values($errores)[0]);DIE();
                return ['error'=>$cita['error']];  
               //return ['error'=>yii::t('sta.errors','Hubo errores al crear la Cita, revise el log de errores ')];  
            }else{
                 
                $numeroCita=$cita->numero;
                $model-> updateNumeroCita($numeroCita);
               $baterias= \frontend\modules\sta\helpers\comboHelper::baterias();
               foreach($baterias as $key=>$bateria){
                   $cita->agregaBateria($key); 
                   break;
               }
              
                $mensajes=$cita->notificaCorreoExamen();
                //print_r($mensajes);die();
                return ['success'=>yii::t('sta.labels','Se ha generado la cita '.$numeroCita)];
            }
        }
         }
          
        }
        
    public function ActionAsistio(){
        if(h::request()->isAjax){
        h::response()->format = \yii\web\Response::FORMAT_JSON;
        $model=  \frontend\modules\sta\models\StaEventosdet::findOne($id);
        if(is_null($model))
         return ['error'=>yii::t('sta.errors','No se encontró el registro para este id '.$id)];
       if(!$model->evento->isDateToWork())
        return ['error'=>yii::t('sta.errors','No se encuentra dentro de las fechas de trabajo')]; 
        
        if($model->updateAsistencia()){
          return ['success'=>yii::t('sta.errors','Asistencia actualizada')];
          
        }else{
           return ['error'=>yii::t('sta.errors','No se pudo actualizar')];
           
        }
    }
    }
 
    public function actionEliminaAlumno($id){
         if(h::request()->isAjax){
        h::response()->format = \yii\web\Response::FORMAT_JSON;
      $model=  \frontend\modules\sta\models\StaEventosdet::findOne($id);
        if(is_null($model))
         return ['error'=>yii::t('sta.errors','No se encontró el registro para este id '.$id)];
        if($model->asistio)
         return ['error'=>yii::t('sta.errors','Este alumno ya confirmó asistencia')];   
         if(!empty($model->numerocita))
         return ['error'=>yii::t('sta.errors','Este alumno ya tiene')];   
        
        $model->delete();
         return ['success'=>yii::t('sta.errors','Se eliminó el alumno')];
         }
    }
    public function actionAsisteAlumno($id){
         if(h::request()->isAjax){
        h::response()->format = \yii\web\Response::FORMAT_JSON;
      $model=  \frontend\modules\sta\models\StaEventosdet::findOne($id);
        if(is_null($model))
         return ['error'=>yii::t('sta.errors','No se encontró el registro para este id '.$id)];
        if($model->asistio)
         return ['error'=>yii::t('sta.errors','Este alumno ya lo registró como asistente')]; 
        if(!$model->evento->isDateToWork())
        return ['error'=>yii::t('sta.errors','No se encuentra dentro de las fechas de trabajo')]; 
        if($model->updateAsistencia()){
            return ['success'=>yii::t('sta.errors','Se confirmó la asistencia')];
        }else{
            return ['error'=>yii::t('sta.errors','Hubo un error')]; 
        }
         
         }
    }
   
    
     public function actionAgregaAlumnos($id){
         if(h::request()->isAjax){
        h::response()->format = \yii\web\Response::FORMAT_JSON;
      $model=  \frontend\modules\sta\models\StaEventos::findOne($id);
      if($model->isDateConfirmed()){
          return ['error'=>yii::t('sta.errors','Ya no puede agregar grupos de alumnos, sólo puede hacerlo con  {horas} horas de anticipación',['horas'=>h::gsetting('sta','nhorasantesevento')])]; 
      }
      
        if(is_null($model))
         return ['error'=>yii::t('sta.errors','No se encontró el registro para este id '.$id)];
        $info=$model->addAlumnos(); 
        $exitos=count(array_column($info,'succes'));
        $fracasos=count(array_column($info,'error'));
        if($fracasos > 0 && $exitos >0 ){
         return ['warning'=>yii::t('sta.errors','Se agregaron "{nalumnos}" pero hubo "{nfracasos}" errores',['nalumnos'=>$exitos,'nfracasos'=>$fracasos])];   
        }
        if($exitos==0 && $fracasos > 0){
           return ['error'=>yii::t('sta.errors','No se agregó ningún alumno')];
        }
        if($fracasos==0 && $exitos > 0){
           return ['success'=>yii::t('sta.errors','Se agregaron los alumnos')];
        }
        
         }
    }
    
    
    public function actionEditaCita($id){
      
       $model= Citas::find()->andWhere('numero=:id', [':id' => $id])->one();
       if(is_null($model)){
          throw new NotFoundHttpException(Yii::t('sta.labels', 'Registro no encontrado'));
    
       }else{
           $this->redirect(['/sta/citas/update','id'=>$model->id]);
       }
    }
   
   public function actionAgregaAlumnoSolo($id){        
         $this->layout = "install";
         $evento=$this->findModel($id);
         $model= new \frontend\modules\sta\models\StaEventosdet();
         $model->setScenario($model::SCENARIO_AGREGA_ALUMNO); 
         $model->eventos_id=$evento->id;
         
        $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
            
           
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                //$model->setScenario('default'); 
               //if(!$evento->isDateToWork())
                 //return ['error'=>2,'msg'=>$datos];     
              $mensajes= $evento->creaDetalle($model->codalu);
              
              
             
             // yii::error($mensajes,__FUNCTION__);
               // $model->save();
                //var_dump($model->talleres_id,$model->getOldAttribute('codtra'),$model->codtra);die();
                //$model->cambiaPsicologo($model->codtra);
                  //$model->taller->sincronizeCant();
                return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_agrega_alumno', [
                       // 'modelTaller' => $model->talleres,
                         'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                       // 'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }

    } 
 
    
    public function actionNotificaPorCorreo($id){
         if(h::request()->isAjax){
        h::response()->format = \yii\web\Response::FORMAT_JSON;
        $model=$this->findModel($id);
        if($model->isDateConfirmed()){
         return ['error'=>yii::t('sta.errors','Ya no puede notificar, está próximo a cumplirse el evento')];
        }
        
        
        return $model->notificaCitas();
         }
    }
    
    
    public function actionCierraEvento($id){
         if(h::request()->isAjax){
        h::response()->format = \yii\web\Response::FORMAT_JSON;
        $model=$this->findModel($id);
        if($model::CarbonNow()->lt($model->toCarbon('fechaprog')->addhours(1))){
           return ['error'=>yii::t('sta.errors','No puede cerrar aun es muy pronto')];
        }
        if($model->hasIncompleteExamen()){
         return ['error'=>yii::t('sta.errors','El evento tiene examenes sin terminar, verifique o subsane la cita')];   
        }
        
         $model->closeEvento();
         return ['success'=>yii::t('sta.errors','El evento ha sido cerrado')];
         }
    }
    
    public function actionLoadAlumnos(){
        if(h::request()->isAjax){
         $id=h::request()->get('id');
        h::response()->format = \yii\web\Response::FORMAT_JSON;
        $model=$this->findModel($id);
        
        $sesion=h::session();
        if($sesion->has(h::SESION_MALETIN)){
            
          $info=$model->addCodesFromSesion();   
        }else{
          if(!$model->hasFileCsv()){
           return ['error'=>yii::t('sta.errors',$model->getFirstError())];
            }
            
          $info=$model->addCodesFromCsv();  
        }
        
        if(count($info)==0){
           return ['warning'=>yii::t('sta.errors','No se encontró nada que importar')];    
        }
       
        $exitos=count(array_column($info,'success'));
        $fracasos=count(array_column($info,'error'));
        //yii::error('existos '.$exitos);
        //yii::error('fracasos '.$fracasos);
        if($fracasos > 0 && $exitos >0 ){
         return ['warning'=>yii::t('sta.errors','Se agregaron "{nalumnos}" pero hubo "{nfracasos}" errores : '.implode(' --  ',array_column($info,'error')),['nalumnos'=>$exitos,'nfracasos'=>$fracasos])];   
        }
        if($exitos==0 && $fracasos > 0){
           return ['error'=>yii::t('sta.errors','No se agregó ningún alumno '.implode(' --  ',array_column($info,'error')))];
        }
        if($fracasos==0 && $exitos > 0){
           return ['success'=>yii::t('sta.errors','Se agregaron los alumnos')];
        }
        
     
        } 
    }
    
     public function actionAsisteAlumnoConCita($id){
         if(h::request()->isAjax){
        h::response()->format = \yii\web\Response::FORMAT_JSON;
      $model=  \frontend\modules\sta\models\StaEventosdet::findOne($id);
        if(is_null($model))
         return ['error'=>yii::t('sta.errors','No se encontró el registro para este id '.$id)];
       $idsesion=$model->obtenerIdNextSesion();
      
        if(!($idsesion>0) or is_null($idsesion))
         return ['error'=>yii::t('sta.errors','No se ha creado ninguna sesión o no se puede aplicar a ninguna sesion')];
        
        $sesion= \frontend\modules\sta\models\StaEventosSesiones::findOne($idsesion);
        if($model->existenSesionesPreviasSinCerrar($sesion->secuencia))
        return ['error'=>yii::t('sta.errors','No puede confirmar asistencia en esta sesión , primero cierre las anteriores')];
       
       /// if($model->asistio)
        // return ['error'=>yii::t('sta.errors','Este alumno ya lo registró como asistente')]; 
        if(!$model->evento->isDateToWork())
        return ['error'=>yii::t('sta.errors','No se encuentra dentro de las fechas de trabajo')]; 
        /*generamos la cistas*/
        $cita=$model->updateAsistenciaConCita($idsesion);
        
        if(is_array($cita)){
            return ['error'=>$cita['error']];             
        }else{
          return ['success'=>yii::t('sta.errors','Se confirmó la asistencia '.$model->nombres)];  
        }
         
         }
    }
   public function actionViewAjaxCitas(){
        if(h::request()->isAjax)  {
     $id=h::request()->post('expandRowKey');
    $model= \frontend\modules\sta\models\StaEventosdet::findone($id); 
    if(!is_null($model)){
       return $this->renderAjax('_ajax_view', [
                       // 'modelTaller' => $model->talleres,
                         'model' => $model
            ]);   
    }else{
        
    }}
    }
    
    public function actionCrearSesion($id){
       $this->layout = "install";
         $evento=$this->findModel($id);
         $model= new \frontend\modules\sta\models\StaEventosSesiones();
         //$model->setScenario($model::SCENARIO_AGREGA_ALUMNO); 
         $model->eventos_id=$evento->id;
        $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post()); 
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
               $model->save();
              return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_agrega_sesion', [
                       // 'modelTaller' => $model->talleres,
                         'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                       // 'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
 
    }
  public function actionEditaSesion($id){
       $this->layout = "install";
         //$evento=$this->findModel($id);
         $model=  \frontend\modules\sta\models\StaEventosSesiones::findOne($id);
         //$model->setScenario($model::SCENARIO_AGREGA_ALUMNO); 
         ///$model->eventos_id=$evento->id;
        $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post()); 
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
               $model->save();
              return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_agrega_sesion', [
                       // 'modelTaller' => $model->talleres,
                         'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                       // 'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
 
    }  
    
public function actionCloseSesion($id){
    if(h::request()->isAjax){        
        h::response()->format = \yii\web\Response::FORMAT_JSON;
      $model=  \frontend\modules\sta\models\StaEventosSesiones::findOne($id);
      if(is_null($model)){
          return ['error'=>yii::t('sta.errores','NO se encontro el registro para este id')];
       }else{
         return $model->closeSesion();
       }
      } 
           }
           
 public function actionNotificaPorCorreoSesion($id){
         if(h::request()->isAjax){
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                $model= \frontend\modules\sta\models\StaEventosSesiones::findOne($id);
                return $model->notificaCitas();
         }
    }
 
 public function actionUncloseSesion($id){
    if(h::request()->isAjax){        
        h::response()->format = \yii\web\Response::FORMAT_JSON;
      $model=  \frontend\modules\sta\models\StaEventosSesiones::findOne($id);
      if(is_null($model)){
          return ['error'=>yii::t('sta.errores','NO se encontro el registro para este id')];
       }else{
         return $model->unCloseSesion();
       }
      } 
  }   
  
  public function actionRevertAsistencia($id){
    if(h::request()->isAjax){  
        h::response()->format = \yii\web\Response::FORMAT_JSON;
      $cita_id=h::request()->get('cita_id');
      $model_cita=  \frontend\modules\sta\models\Citas::findOne($cita_id);
       if(is_null($model_cita))
          return;
        $model=  \frontend\modules\sta\models\StaEventosdet::findOne($id);
       
       
       
        
     
      if(is_null($model)){
          return ['error'=>yii::t('sta.errors','No se encontro el registro para este id')];
       }else{
            //verificando sio la cita corresponde a estas sesiones        
        $idSesiones=$model->evento->getSesiones()->select(['id'])->column();
        //var_dump($model_cita->numero,$model_cita->codaula,$idSesiones);die();
        if(!in_array($model_cita->codaula+0,$idSesiones)){
         return ['error'=>yii::t('sta.errors','El id de la cita no corresponde a este evento')];
          
        }
         return $model->revertAsistenciaConCita($model_cita->id);
       }
      } 
  }  
  
    public function actionAgregaIndicadorSesion($id){        
         $this->layout = "install";
        $modelSesion = \frontend\modules\sta\models\StaEventosSesiones::findOne($id);
      $model=new \frontend\modules\sta\models\StaIndisesiones();
       $model->sesiones_id=$modelSesion->id;
       $model->eventos_id=$modelSesion->eventos->id;
       $model->codfac=$modelSesion->eventos->codfac;
       
       
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
           return $this->renderAjax('_modal_agrega_indicador', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
       
    }
  
     public function actionEditaIndicadorSesion($id){        
        $model= \frontend\modules\sta\models\StaIndisesiones::findOne($id);
      
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
           return $this->renderAjax('_modal_agrega_indicador', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
       
    }
    public function actionBorrarIndicador($id){
         if(h::request()->isAjax){
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $model= \frontend\modules\sta\models\StaIndisesiones::findOne($id);
            if(!is_null($model)){
                if($model->sesion->hasAsistencias()){
                   return ['error'=>yii::t('sta.errors','No puede borrar este indicador porque la sesión ya tiene asistencias')];
            
                }else{
                   $model->delete(); 
                    return ['success'=>yii::t('sta.errors','Se eliminó el indicador')];
            
                }
            }else{
                return ['error'=>yii::t('sta.errors','No se encontró el registro')];
            }
             
          }
    }
    
    public function actionRefrescarIndicador($id){
         if(h::request()->isAjax){
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $model= $this->findModel($id);
            if(!is_null($model)){
                $model->refreshIndicadores();
                return ['success'=>yii::t('sta.errors','Se actualizaron los indicadores sobre los alumnos')];
            }else{
                return ['error'=>yii::t('sta.errors','No se encontró el registro')];
            }
             
          }
    }
}
