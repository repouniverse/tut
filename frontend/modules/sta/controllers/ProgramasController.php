<?php

namespace frontend\modules\sta\controllers;

use Yii;
use frontend\modules\sta\models\Talleres;
use frontend\modules\sta\staModule;
use frontend\modules\sta\models\Tallerpsico;
use frontend\modules\sta\models\RangosSearch;
use frontend\modules\sta\models\TalleresSearch;
use frontend\modules\sta\models\VwAlutaller;
use frontend\modules\sta\models\StaVwCitasSearch;
use frontend\modules\sta\models\VwStaTutores;
use frontend\modules\sta\models\Alumnos;
use frontend\modules\sta\models\VwAlutallerSearch;
use frontend\modules\sta\models\VwAluriesgoSearch;
use frontend\modules\sta\models\TallerpsicoSearch;
use frontend\modules\sta\models\StaTestTalleres;
use frontend\modules\sta\models\VwStaTutoresSearch;
use frontend\modules\sta\models\StaIpslab;
use frontend\modules\sta\models\Rangos;
use frontend\modules\sta\models\Test;
use frontend\modules\sta\models\Citas;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use common\helpers\h;
USE common\widgets\buttonsubmitwidget\buttonSubmitWidget;

/**
 * ProgramasController implements the CRUD actions for Talleres model.
 */
class ProgramasController extends baseController
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
        $class = new  \ReflectionClass('\frontend\modules\sta\models\Alumnos');
       $clase='\frontend\modules\sta\models\Entregas';
       
       //var_dump(is_subclass_of($clase, \common\models\base\modelBase::className()));
        //var_dump($class->getParentClass());die();
       /* $expre='/[0-9]{4}-[0-9]{1}[0-2]{1}-[0-3]{1}[0-9]{1} [0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}/';
        $fecha='2019-12-24 09:00:00';
       var_dump(preg_match($expre,$fecha));die();*/
        /*$model= \frontend\modules\sta\models\Examenes::findOne(29);
        var_dump($model->getExamenesDet()->count());die();
        */
        
       /* $model= Citas::findOne(84);
        $model->fechaprog='24/12/2019 13:10:00';
       // var_dump($model->tallerProg()->range($model->toCarbon('fechaprog')));
        var_dump($model->esFeriado(),$model->isInJourney(),$model->isFreeForPsico(),$model->getFirstError());
       die();*/
        
        /*select 
        d.ap as aptutor,d.am as amtutor,d.nombres as nombretutor,
                s.codperiodo,
                b.codalu,
                c.ap,c.am,c.nombres,c.codfac,c.codcar,
                a.* from
 ((((7av4v_sta_talleresdet b inner join 7av4v_sta_alu c 
 on c.codalu=b.codalu)  
                inner join 7av4v_sta_talleres s on s.id=b.talleres_id)  
 left join  7av4v_sta_citas a 
on a.talleresdet_id=b.id)  left join
                        7av4v_trabajadores d on d.codigotra=a.codtra 
  );*/
        
        
   /* $CADENA=   (new \yii\db\Query())
    ->select([
         'd.ap as aptutor',
         'd.am as amtutor',
         'd.nombres as nombrestutor',
        's.codperiodo',
        'b.codalu',
         'c.ap','c.am','c.nombres','c.codfac','c.codcar',
         'a.*',
        ])
    ->from(['b'=>'{{%sta_talleresdet}}'])->
     innerJoin('{{%sta_alu}} c', 'c.codalu=b.codalu')->
     innerJoin('{{%sta_talleres}} s', 's.id=b.talleres_id')->          
      leftJoin('{{%sta_citas}} a', 'a.talleresdet_id=b.id')->
      leftJoin('{{%trabajadores}} d', 'd.codigotra=a.codtra')->
      createCommand()->execute();
    ECHO $CADENA; DIE();*/
     
        
        
        
        
        
        
        $searchModel = new TalleresSearch();
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
       // VAR_DUMP(\frontend\modules\sta\helpers\comboHelper::getCboTutoresByProg($id));DIE();
        
        //$range=$model->range('12/12/2019');
        //var_dump($range->getInitialDate(),$range->getFinalDate());die();
        //yii::error('eNCONTOR MODELO');
//print_r($model->studentsInRiskForThis()); die();
         $searchStaff = new TallerpsicoSearch();
        $dataProviderStaff = $searchStaff->SearchByTaller($id);
        
        $searchRangos = new RangosSearch();
        $dataProviderRangos = $searchRangos->SearchByTaller($id);

         $searchAlumnos = new VwAlutallerSearch();
        $dataProviderAlumnos = $searchAlumnos->searchByTaller(
                h::request()->queryParams,$model->id);
//yii::error('que pasa');
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
           'dataProviderStaff'=>$dataProviderStaff,
             'dataProviderRangos'=> $dataProviderRangos,
           // 'searchStaff' =>$searchStaff,
            'dataProviderAlumnos'=>$dataProviderAlumnos,
            'searchAlumnos' => $searchAlumnos,
        ]);
    }

    /**
     * Deletes an existing Talleres model.
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
     * Finds the Talleres model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Talleres the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Talleres::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('sta.labels', 'The requested page does not exist.'));
    }
    
    public function actionRefrescaAlumnos(){
        if(h::request()->isAjax){
            $model=$this->findModel(h::request()->post('id'));
            $carga=$model->loadStudents();
             h::response()->format = Response::FORMAT_JSON;
             if($carga['total']==$carga['contador']){
             $datos['success']=yii::t('sta.messages',
                     'Se insertaron {insertados} Registros ',
                     ['insertados'=>$carga['contador']]);
             }else{
               if($carga['contador']==0){//Si no se inserto nada
                $datos['warning']=yii::t('sta.messages',
                     'No hay alumnos nuevos que insertar'
                     );     
               }else{
               $datos['warning']=yii::t('sta.messages',
                     'Se insertaron {insertados} Registros de {totales}',
                     ['insertados'=>$carga['contador'],'totales'=>$carga['total']]);  
             }
             }
             return $datos;
        }
    }
    
    
    public function actionAluriesgo(){
         $searchModel = new VwAluriesgoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('riesgo', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
   
    public function actionAgregaPsico($id){        
         $this->layout = "install";
        $modelprograma = $this->findModel($id);
        $varios=$modelprograma->freeStudents();
       
       $modelprograma->sincronizeCant();
        $cantidadLibres=count($varios);unset($varios);
         yii::error('estudiantes libres en '.$cantidadLibres,__METHOD__);
       $model=New Tallerpsico();
       $model->talleres_id=$id;
       $model->codfac=$modelprograma->codfac;
       
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save();
                $model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->talleres_id];
            }
        }else{
           return $this->renderAjax('_psico', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
       
       /*if(h::request()->isAjax && h::request()->isPost){
           yii::error('esqajax');
           h::response()->format = \yii\web\Response::FORMAT_JSON;
            yii::error('ya coloco eñ foramt x');
           $datos=\yii\widgets\ActiveForm::validate($model);
            yii::error('ya asigno los datos ');
       } 
       if( empty($datos) && $model->save() && h::request()->isPost){
           yii::error('model sving ');
           return ['success'=>1,'id'=>$model->talleres_id];
       }elseif(h::request()->isPost){
           yii::error('no paso nada  ');
          return ['success'=>2,'msg'=>$datos]; 
       }else{
           yii::error('Renderizado ');
           return $this->renderAjax('_psico', [
                        'model' => $model,
                        'id' => $id,
                        'cantidadLibres'=>$cantidadLibres,
          
            ]); 
       }
       
       
      /* if(h::request()->isPost){
           if(h::request()->isAjax &&  $model->load(Yii::$app->request->post())){
               h::response()->format = \yii\web\Response::FORMAT_JSON;
              return \yii\widgets\ActiveForm::validate($model); 
           }
            
            $this->closeModal('buscarvalor', 'grilla-staff');
       }else{
          return $this->renderAjax('_psico', [
                        'model' => $model,
                        'id' => $id,
                        'cantidadLibres'=>$cantidadLibres,
          
            ]); 
       }*/
      /* if(h::request()->isAjax && $model->load(h::request()->post())){            
            if ($model->save()) {
                   $model->assignStudentsByRandom();
                 yii::error('ha grabado',__METHOD__);
                 $this->closeModal('buscarvalor', 'grilla-staff');
              
              yii::error('intento cerrar',__METHOD__);
             
                       
                        } else{
                            h::response()->format = \yii\web\Response::FORMAT_JSON;
                       return \yii\widgets\ActiveForm::validate($model);
                        }
         
        }       
      return $this->renderAjax('_psico', [
                        'model' => $model,
                        'id' => $id,
                        'cantidadLibres'=>$cantidadLibres,
          
            ]); 
      */
    }
    
       public function actionEditaPsico($id){        
         $this->layout = "install";
        $model = Tallerpsico::findOne($id);
        $varios=$modelprograma->freeStudents();
        $cantidadLibres=count($varios);unset($varios);
        
               $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save();                
                  return ['success'=>1,'id'=>$model->talleres_id];
            }
        }else{
           return $this->renderAjax('_psico', [
                        'model' => $model,
                        'id' => $id,
                        'cantidadLibres'=>$cantidadLibres,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        
        }
        
        
        /* yii::error('estudiantes libres en '.$cantidadLibres,__METHOD__);
       $model=New Tallerpsico();
       $model->talleres_id=$id;
       $model->codfac=$modelprograma->codfac;*/
       
    
    
    }
     
   public function actionEditTutor(){
       if ($this->is_editable())
            return $this->editField();
   }
   /*
    * Desafilia el tutor
    * y devuelve los mensajes acecidos
    */
     public function actionAjaxDetachPsico($id){
         if(h::request()->isAjax){             
               h::response()->format = \yii\web\Response::FORMAT_JSON;           
             $modelo= Tallerpsico::findOne($id);            
              $modelo->dettachTutor();
              return $modelo->messages();
         }
       
    }
    
    public function actionAgregaTest(){
       if(h::request()->isAjax){
           h::response()->format=\yii\web\Response::FORMAT_JSON;
           $modelTaller=$this->findModel(h::request()->post('id'));
           $codigo=h::request()->post('codtest');
           $model=Test::findOne($codigo);
           if(!is_null($model)){
               
               
               if(StaTestTalleres::firstOrCreateStatic([
                   'taller_id'=>$modelTaller->id,
                   'codtest'=>$codigo,
                  // 'peso'=>1,
                  // 'obligatorio'=>'0',
                       ])){
                  return ['success'=>yii::t('sta.errors','Se ha agregado el Test Satisfactoriamente')];     
                 
               }else{
              return ['error'=>yii::t('sta.errors','Hubo un error al grabar el registro, posiblemente este test ya está agregado')];     
               }
           }else{
               return ['error'=>yii::t('sta.errors','No se encontró ningún registro para el código {}',['codigo'=>$codigo])];
           }
       }
    }
 
 public function actionTutores(){
     
     
     $this->layout="install";
     //yii::error('layout');
      $searchModel = new VwStaTutoresSearch();
      //yii::error('searchmodel');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      // yii::error('dataprovider');
        return $this->render('_tutores', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
 }   
   

  public function actionEditRango($id){
     $this->layout = "install";
        $model = \frontend\modules\sta\models\Rangos::findOne($id);
        $datos=[];
        if(is_null($model)){
            //Si es error buttonSubmitWidget::OP_TERCERA
            //lanza un NOTY msg de error
            return ['success'=>buttonSubmitWidget::OP_TERCERA,'msg'=>$datos];
        }
        
      
        if(h::request()->isPost){
            $model->setScenario(Rangos::SCENARIO_HORAS);
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>buttonSubmitWidget::OP_SEGUNDA,'msg'=>$datos];  
            }else{
                $model->save();
                
                  return ['success'=>buttonSubmitWidget::OP_PRIMERA,'id'=>$model->talleres_id];
            }
        }else{
            //var_dump($model->attributes);die();
           return $this->renderAjax('_rangos', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
       
  } 


  //Id del programa
  public function actionCreateCita($id){
    // $this->layout = "install";
        $modelTaller = $this->findModel($id); 
        $model=new Citas();
        $datos=[];
        if(h::request()->isPost){
           // $model->setScenario(Rangos::SCENARIO_HORAS);
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>buttonSubmitWidget::OP_SEGUNDA,'msg'=>$datos];  
            }else{
                $model->save();
                
                  return ['success'=>buttonSubmitWidget::OP_PRIMERA,'id'=>$model->talleres_id];
            }
        }else{
            //var_dump($model->attributes);die();
           return $this->renderAjax('_cita', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
       
  } 

public function actionProgramarCitas($id){
     $freeStudents=$model->countStudentsFree();
     if($freeStudents <=0){
          
     }else{
         
     }
}

/*
 * $id del detalle
 */
public function actionMakeCitaByStudent(){
    if(h::request()->isAjax){
        h::response()->format = \yii\web\Response::FORMAT_JSON;
        $id=h::request()->get('id');
        $codalu=h::request()->get('codalu');
        $fecha=h::request()->get('fecha');
        $model= Tallerpsico::findOne($id);
       // print_r($model->getTalleresdet($codalu)->attributes);
        //var_dump($model->attributes);die();
        $validator = new \yii\validators\RegularExpressionValidator(['pattern'=> h::gsetting('sta', 'regexcodalu')]);
        if($validator->validate($codalu, $error) && !is_null($model)) {
            $attributes=[
                'talleres_id'=>$model->talleres_id,
                'talleresdet_id'=>$model->modelTalleresdet($codalu)->id,
                'fechaprog'=>$model::SwichtFormatDate($fecha,$model::_FDATETIME,true),
                'codtra'=>$model->codtra,
                 'codfac'=>$model->codfac,
                
            ];
           // var_dump($fecha,$model::_FDATETIME,$model::SwichtFormatDate($fecha,$model::_FDATETIME,true));die();
       
             
            if(Citas::firstOrCreateStatic($attributes,Citas::SCE_CREACION_BASICA)){
              $datos['success']=yii::t('sta.errors','Se ha creado la cita satisfactoriamente');
                
            }else{
                $mod=new Citas();
                $mod->setScenario(Citas::SCE_CREACION_BASICA);
                $mod->setAttributes($attributes);
                $mod->validate();
              $datos['error']=yii::t('sta.errors','Hubo un problema interno al grabar el registro de las citas : '.$mod->getFirstError());
                UNSET($mod);
               // RETURN $datos;
            }
                
           return $datos; 
            
            
                } else{
                  $datos['error']=yii::t('sta.errors','El código de alumno no es el adecuado');
                
                }
 
       
    }
}

public function actionTrataAlumno($id){   
    //ENOCNTRADNO EL TALLER DET
    $modelTallerdet = \frontend\modules\sta\models\Talleresdet::findOne($id);
    //print_r($modelTallerdet->listMailFromField($attribute, $condition));
    //ENCONTRANDO TALLER_PSICO
    $modelPsico=$modelTallerdet->tallerPsico();
     //ENCONTRANDO EL ALUMNO    
    $model=Alumnos::findOne(['codalu'=>$modelTallerdet->codalu]);
    
    //ECHO $modelTallerdet->talleres->descripcion; die();
    /*Provider de Citas por alumno*/
    $dataProvider=(new StaVwCitasSearch())->searchByTallerId($modelTallerdet->id);
    /*****************/
    $color='#d351e2';
    /*Provider de citas pendientes*/    
    $citasPendientes=$modelPsico->
            putColorThisCodalu(
                    $modelPsico->eventosPendientes(),$model->codalu,$color);
    
    
    
    /************************/
    //print_r($citasPendientes);die();
    
    
       return $this->render('_tabsCitas',
               [
                   'model'=>$model, 
                   'modelPsico'=>$modelPsico,
                   'color'=>$color,
                   'modelTallerdet'=>$modelTallerdet,
                'dataProvider'=>$dataProvider,
                   'codalu'=>$modelTallerdet->codalu,
                   'citasPendientes'=>$citasPendientes,
                'codperiodo'=>$modelTallerdet->talleres->codperiodo,
                   ]);
    
}


public function actionNotificaCita(){
    if(h::request()->isAjax){
        $mensajes=[];
         h::response()->format = \yii\web\Response::FORMAT_JSON;
        $alumno= Alumnos::findOne(h::request()->get('idalu'));
        $nombre=$alumno->nombres;
       if(empty($alumno->correo)){
           return ['error'=>yii::t('sta.labels','Error : El alumno no tiene dirección de correo')];
       
           
       }
           
        $cita=Citas::findOne(h::request()->get('idcita'));
        
        
        $mailer = new \common\components\Mailer();
        $message =new  \yii\swiftmailer\Message();
            $message->setSubject('Notificacion de Cita')
            ->setFrom(['neotegnia@gmail.com'=>'Tutoría UNI'])
            ->setTo($alumno->correo)
            ->SetHtmlBody("Buenas Tardes  $nombre <br>"
                    . "La presente es para notificarle que tienes "
                    . "una cita programada<br>Cuando: $cita->fechaprog <br>"
                    . "Duracion de la cita: $cita->duracion <br>  ");
           
    try {
        
           $result = $mailer->send($message);
           $mensajes['success']='Se envió el correo';
    } catch (\Swift_TransportException $Ste) {      
         $mensajes['error']=$Ste->getMessage();
    }
    return $mensajes;
    }
}
        
public function actionAgregaDocs(){
    if(h::request()->isAjax){
       $tallerdet= \frontend\modules\sta\models\Talleresdet::findOne(h::request()->get('id')); 
      if(!is_null($tallerdet)){
          $tallerdet->generaDocumentos();
          unset($tallerdet);
      }
       
    }
}

public function actionProgramaVista($id){
    if ($this->is_editable())
            return $this->editField();
    
        $model = $this->findModel($id);
         $searchAlumnos = new VwAlutallerSearch();
        $dataProviderAlumnos = $searchAlumnos->searchByTaller(
                h::request()->queryParams,$model->id);
        return $this->render('/programas/visualizacion/view', [
            'model' => $model,
           //'dataProviderStaff'=>$dataProviderStaff,
             //'dataProviderRangos'=> $dataProviderRangos,
           // 'searchStaff' =>$searchStaff,
            'dataProviderAlumnos'=>$dataProviderAlumnos,
            'searchAlumnos' => $searchAlumnos,
        ]); 
}

public function actionCalificaAlumno($id){
        
        $this->layout = "install";
        $model = \frontend\modules\sta\models\Talleresdet::findOne($id);
       // var_dump($modeltallerdet);die();
        $model->setScenario($model::SCENARIO_TUTOR);        
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
                  return ['success'=>1,'id'=>$model->talleres_id];
            }
        }else{
           return $this->renderAjax('/programas/visualizacion/_modal_califica_tutor', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
}


public function actionConvocaAlumno($id){
        
        $this->layout = "install";
        $model =NEW  \frontend\modules\sta\models\StaConvocatoria;
         $modelDet = \frontend\modules\sta\models\Talleresdet::findOne($id);
         $model->codfac=$modelDet->talleres->codfac;
          $model->talleresdet_id=$modelDet->id;
       // var_dump($modeltallerdet);die();
        //$model->setScenario($model::SCENARIO_TUTOR);        
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
            // var_dump(h::request()->post(), $model->attributes);die();
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
               yii::error('grabando');
                $model->save();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_convocatoria', [
                        'model' => $model,
               'modeldet'=>$modelDet,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
}


public function actionEditaDocu($id){        
         $this->layout = "install";
         $model= \frontend\modules\sta\models\StaDocuAlu::findOne($id);
         
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
           return $this->renderAjax('_modal_docu_alu', [
                        'model' => $model,
                         'modeldet' => $model->talleresdet,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                       // 'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }

    }

 public function actionRegistraLab($id){
     $modelTaller=$this->findModel($id);
     $model=new StaIpslab();
     $model->ip=h::request()->getUserIP();
     $model->activo=true;
     $model->taller_id=$id;
      if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
        }
        if ($model->load(h::request()->post()) && $model->save()) {
            return $this->redirect(['complete-matricula']);
        }
        return $this->render('_matricula_pc', [
            'model' => $model,
            'modelTaller'=>$modelTaller,
        ]);
   } 
   
   public function actionCompleteMatricula(){    
        return $this->render('_complete_matricula', [            
        ]);
   }  
   
   
   public function actionCambioPsicologo($id){        
         $this->layout = "install";
         $model= \frontend\modules\sta\models\Tallerpsico::findOne($id);
         $model->setScenario($model::SCENARIO_CAMBIO);
        $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
               // $model->save();
                //var_dump($model->talleres_id,$model->getOldAttribute('codtra'),$model->codtra);die();
                $model->transfiereAlus($model->getOldAttribute('codtra'),$model->codtra,$model->cantidad_transferir);
                  $model->taller->sincronizeCant();
                return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_cambio_psico', [
                        'modelTaller' => $model->taller,
                         'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                       // 'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }

    }
 public function actionCambioPsicologoAlumno($id){        
         $this->layout = "install";
         $model= \frontend\modules\sta\models\Talleresdet::findOne($id);
         
        $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
               // $model->save();
                //var_dump($model->talleres_id,$model->getOldAttribute('codtra'),$model->codtra);die();
                $model->cambiaPsicologo($model->codtra);
                  //$model->taller->sincronizeCant();
                return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_cambio_psico_alu', [
                        'modelTaller' => $model->talleres,
                         'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                       // 'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }

    }

}
