<?php

namespace frontend\modules\sta\controllers;
USE frontend\modules\sta\staModule;
use Yii;
use frontend\modules\sta\models\StaVwCitas;
use frontend\modules\sta\models\Citas;
use frontend\modules\sta\models\Talleres;
use frontend\modules\sta\models\Alumnos;
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
use common\helpers\timeHelper;
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
     
                $searchModel = new \frontend\modules\sta\models\StaVwCitasSearch();
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
        //print_r($model->codExamenes());die();
     
        if (h::request()->isAjax && $model->load(h::request()->post())) {
           
                h::response()->format = Response::FORMAT_JSON;
                
                 //var_dump(h::request()->isAjax,$model->load(h::request()->post()));die();
                ///yii::error('paso por is ajax  load Post');
                return ActiveForm::validate($model);
        }
        
        
        
        
        if ($model->load(Yii::$app->request->post())) {
           
                     
             if($model->hasChanged()){
                  if($model->save()){
                      h::session()->setFlash('success',yii::t('sta.labels','Se han hecho modificaciones en la Cita'));
                   }else{
                         h::session()->setFlash('error',yii::t('sta.labels','Se han presentado errores '.$model->getFirstError()));
                   }
                }else{
                    h::session()->setFlash('warning',yii::t('sta.labels','No ha hecho cambios en la Cita'));
                   }
           // yii::error('paso por Load y save()');
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            //print_r($model->getErrors());die();
        }
       $eventos=$model->putColorThisCodalu($model->eventosPendientes(),$model->tallerdet->codalu,$color="#ff0000");
       //yii::error('Renderizando vista');die();
     
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
            
            if($model->canChangeAsistio() && $model->save()){
                return ['success'=>yii::t('sta.messages','Se confirmó asistencia')];
            }else{
               return ['error'=>yii::t('sta.messages','Hubo error al confirmar asistencia: '.$model->getFirstError())];  
            }
        }
    }
    
    public function actionAjaxRevertAsistencia(){
        if(h::request()->isAjax){
            $model=$this->findModel(h::request()->get('id'));
            $model->setScenario($model::SCENARIO_ASISTIO);
            $model->asistio=false;
             h::response()->format = Response::FORMAT_JSON;
            
            if($model->canChangeFalto() && $model->save()){
                return ['warning'=>yii::t('sta.messages','Se deshizo asistencia')];
            }else{
               return ['error'=>yii::t('sta.messages','Hubo error al confirmar asistencia: '.$model->getFirstError())];  
            }
        }
    }
    
    
    public function actionAjaxAnulaCita(){
        if(h::request()->isAjax){
            $model=$this->findModel(h::request()->get('id'));
            $model->setScenario($model::SCENARIO_ACTIVO);
            $model->activo=false;
             h::response()->format = Response::FORMAT_JSON;
            
            if($model->canInactivate() && $model->save()){
                return ['success'=>yii::t('sta.messages','Se Anuló la cita sin problemas')];
            }else{
               return ['error'=>yii::t('sta.messages','Hubo error al intentar anular: '.$model->getFirstError())];  
            }
        }
    }
    
   public function actionAgregaExamen($id){
    $this->layout = "install";
         
        $modelCita = $this->findModel($id);  
       
       $model=New \frontend\modules\sta\models\Examenes();
       $model->citas_id=$id;
       $model->codfac=$modelCita->codfac;
       
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save();
                //$model->creaExamen();
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

public function  actionNotificaExamenDigital(){

    if(h::request()->isAjax){
       //echo  h::request()->get('id')
        $mensajes=[];
         h::response()->format = \yii\web\Response::FORMAT_JSON;
        $alumno= \frontend\modules\sta\models\Alumnos::findOne(h::request()->get('idalu'));
           $examen= Examenes::findOne(h::request()->get('id'));
       
        
        if(is_null($alumno))
            return ['error'=>yii::t('sta.errors','Error : NO se encontró el registro alumno')];
         if(is_null($examen))
            return ['error'=>yii::t('sta.errors','Error : NO se encontró el registro examen')];
       if(!$examen->cita->asistio)
           return ['error'=>yii::t('sta.errors','NO puede completar esta operación mientras la cita no tenga asistencia')];
       $nombre=$alumno->nombres;
        
       if(empty($alumno->correo)){
           return ['error'=>yii::t('sta.labels','Error : El alumno no tiene dirección de correo')];
       
           
       }
       \common\components\token\Token::deleteAll(['name'=>'token_'.$alumno->id]);
        $token=  \common\components\token\Token::create('citas', 'token_'.$alumno->id, null, time());
       
       // $cita=$examen->cita;
        $replyTo=$examen->cita->taller->correo;
        
        $link= Url::to(['/sta/citas/examen-virtual','id'=>$examen->id,'token'=>$token->token],true);
        $mailer = new \common\components\Mailer();
        $message =new  \yii\swiftmailer\Message();
            $message->setSubject('Notificacion de Examen')
            ->setFrom(['neotegnia@gmail.com'=>'Tutoría UNI'])
            ->setTo($alumno->correo)
            ->SetHtmlBody("Buenas Tardes  $nombre <br>"
                    . "La presente es para notificarle que tienes "
                    . "una examen  programado. <br> Presiona el siguiente link "
                    . "para acceder a la prueba: <br>"
                    . "    <a  href=\"".$link."\" >Presiona aquí </a>");
           if(!empty($replyTo)){
              $message->setReplyTo($replyTo); 
           }
    try {
        
           $result = $mailer->send($message);
           $mensajes['success']='Se envió el correo, invitando al examen, el Alumno tiene que responder ';
    } catch (\Swift_TransportException $Ste) {      
         $mensajes['error']=$Ste->getMessage();
    }
    return $mensajes;
    }

}
 public function  actionNotificaBancoDigital($id){

    if(h::request()->isAjax){
      
       //echo  h::request()->get('id')
        $mensajes=[];
         h::response()->format = \yii\web\Response::FORMAT_JSON;
        $alumno= \frontend\modules\sta\models\Alumnos::findOne(h::request()->get('idalu'));
           $cita= $this->findModel($id);
      
        if(is_null($alumno))
            return ['error'=>yii::t('sta.errors','Error : NO se encontró el registro alumno')];
         if(is_null($cita))
            return ['error'=>yii::t('sta.errors','Error : NO se encontró el registro cita')];
       if($idLastCita=$cita->lastCitaWithExamen()){
             return ['error'=>yii::t('sta.errors','Ya existía la cita {numerocita} con evaluaciones',['numerocita'=>Citas::findOne($idLastCita)->numero])];   
           }
           /*
            * Si ya se contestaron todas las preguntas para que enviar el banco
            */
         if($cita->isBateriaCompleta())
           return ['error'=>yii::t('sta.errors','Error: No puede notificar porque no hay preguntas activas ó las preguntas ya están contestadas')];
      
         if(!$cita->asistio)
            return ['error'=>yii::t('sta.errors','NO puede completar esta operación mientras la cita no tenga asistencia')];
       if(!$cita->hasCompletePreguntas())
            return ['error'=>yii::t('sta.errors','El banco de preguntas aun no esta completo, refresque preguntas')];
       
        $nombre=$alumno->nombres;
       if(empty($alumno->correo)){
           return ['error'=>yii::t('sta.labels','Error : El alumno no tiene dirección de correo')];
       
           
       }
        $token=  \common\components\token\Token::create('citas', 'token_'.$cita->id, null, time());
       
       // $cita=$examen->cita;
         $replyTo=$cita->taller->correo;
        $link= Url::to(['/sta/citas/examen-banco','id'=>$cita->id,'token'=>$token->token],true);
        $mailer = new \common\components\Mailer();
        $message =new  \yii\swiftmailer\Message();
            $message->setSubject('Notificacion de Examen')
            ->setFrom(['neotegnia@gmail.com'=>'Tutoría UNI'])
            ->setTo($alumno->correo)
            ->SetHtmlBody("Buenas Tardes  $nombre <br>"
                    . "La presente es para notificarle que tienes "
                    . "una examen  programado. <br> Presiona el siguiente link "
                    . "para acceder a la prueba: <br>"
                    . "    <a  href=\"".$link."\" >Presiona aquí </a>");
           if(!empty($replyTo)){
              $message->setReplyTo($replyTo); 
           }
    try {
        
           $result = $mailer->send($message);
           $mensajes['success']='Se envió el correo, invitando al examen, el Alumno tiene que responder ';
    } catch (\Swift_TransportException $Ste) {      
         $mensajes['error']=$Ste->getMessage();
    }
    return $mensajes;
    }

} 

public function actionExamenVirtual($id){
     $session = Yii::$app->session;
      $examen=Examenes::findOne($id); 
      //var_dump($session->get('token'));die();
    if(($session->get('token')===null)){
             yii::error('no hya sesion token');  
                $cadenatoken=h::request()->get('token');
                $token=\common\components\token\Token::compare('citas', 'token_'.$examen->cita->tallerdet->alumno->id, $cadenatoken);
                     if(is_null($token)){
                              
                                     echo "no pasa nada con tu roken";die();
                            }else{
                                yii::error('comparo el token es ok,a har creando la sesion');
                                    $session->set('token', $cadenatoken);
                                    yii::error('borrando el token');
                                    $token->delete();
                                     yii::error('Crenado el detalle ');
                                     $examen->creaExamen();
                                    return  $this->render('_examen_virtual',['model'=>$examen]);
       
                                 }
        
    }else{
         yii::error('Si hay sesion token');  
       $modelos=$examen->examenesDet;
       //var_dump($examen->id);die();
       yii::error(h::request()->post('StaExamenesdet'));
       return  $this->render('_examen_virtual',['model'=>$examen,'modelos'=>$modelos]); 
    }
    
    
}

public function getUser(){
   return \common\models\User::findByUsername(\backend\components\Installer::USER_GUEST);
}
        

public function actionExamenBanco($id){
    $this->layout="install";
     $id=(integer)$id;     
     if(!preg_match('/^[0-9]+$/',$id.'')){
         $this->render('_error_acceso',[/*'model'=>$cita,'numeroPreguntas'=>$numeroPreguntas*/]); 
     }
       $cadenatoken=h::request()->get('token');
        // yii::error('cadena token :'.$cadenatoken);
        // yii::error('Comparando el token');
         $token=\common\components\token\Token::compare('citas', 'token_'.$id, $cadenatoken);
                     if(is_null($token)){
                        // yii::error('Token es nulo pucha maquina , n coidide ');
                                    
                                     return  $this->render('_error_token',[/*'model'=>$cita,'numeroPreguntas'=>$numeroPreguntas*/]); 
                            }else{
                               // yii::error('Ya leyo la comparacion del token, ahora lo borramos');
                                  $token->delete();
                                  $cita=Citas::findFree()->where(['id'=>$id])->one();
                                     $numeroPreguntas=$cita->numeroPreguntas();
                                   //  yii::error('Crenado el detalle ');
                                    // $cita->generaExamenes();
                                     //yii::error('creando la cookie');
                                     //echo "hay  ".$cookiesRead->count()." cookies <br> ";
                                     $cookiesSend = Yii::$app->response->cookies;
                                     $cookiesSend->add(new \yii\web\Cookie([
                                        'name' => 'calamaro'.$id,
                                        'value' => 'este es el valor de la cookie paloma',
                                                    ]));
                                     
                                     $session = Yii::$app->session;
                                     $session->open();
                                 if($session->has('repuestasExamen')){
                                    $session->remove('repuestasExamen');
                                    }
                                 if($session->has('IdsPreguntas')){
                                    $session->remove('IdsPreguntas');
                                    }
                                  
                                    //Creansdo  el array de la sesion de IdsPreguntas
                                    $idsExamenes=(new \yii\db\Query())->select(['id'])
                                    ->from(['a'=>'{{%sta_examenes}}'])->where(['citas_id'=>$cita->id])->column();
                                    $idsPreguntas=(new \yii\db\Query())->select(['id'])
                                    ->from(['a'=>'{{%sta_examenesdet}}'])->where(['examenes_id'=>$idsExamenes])->column();
                                    $session['IdsPreguntas']=array_map('intval', $idsPreguntas);
                                    
                                     
                                     
                                     
                                     $steps=$this->prepareDataToRenderExamen($cita);
                                    return  $this->render('_examen_virtual',['id'=>$id,'model'=>$cita,'steps'=>$steps,'numeroPreguntas'=>$numeroPreguntas]); 
                                     //Yii::$app->session->setFlash('success',yii::t('sta.messages','Bienvenido al Examen Virtual'));
                                     //$this->redirect($this->action->id);
                                 }
     
     die();
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
      $cookiesRead = Yii::$app->request->cookies;
    $cookiesSend = Yii::$app->response->cookies;
    $nombrecookie='calamaro_'.$id;
     $this->layout="install";
   
     
    if($cookiesRead->has($nombrecookie)){
        yii::error('Ya tiene  cookie '.$nombrecookie);
        $steps=$this->prepareDataToRenderExamen($cita);
          $session = Yii::$app->session;
                                     $session->open();
                                 if($session->has('repuestasExamen')){
                                    $session->remove('repuestasExamen');
                                    }
       return  $this->render('_examen_virtual',['model'=>$cita,'steps'=>$steps,'numeroPreguntas'=>$numeroPreguntas]); 
        
    }else{
        yii::error('No  tiene  cookie '.$nombrecookie);
         $cadenatoken=h::request()->get('token');
         yii::error('cadena token :'.$cadenatoken);
         yii::error('Comparando el token');
         $token=\common\components\token\Token::compare('citas', 'token_'.$cita->id, $cadenatoken);
                     if(is_null($token)){
                         yii::error('Token es nulo pucha maquina , n coidide ');
                                    $respuesta="no pasa nada con tu roken";
                                      return $respuesta;
                            }else{
                                yii::error('Ya leyo la comparacion del token, ahora lo borramos');
                                  $token->delete();
                                   //  yii::error('Crenado el detalle ');
                                    // $cita->generaExamenes();
                                     yii::error('creando la cookie');
                                     //echo "hay  ".$cookiesRead->count()." cookies <br> ";
                                     $cookiesSend->add(new \yii\web\Cookie([
                                        'name' => $nombrecookie,
                                        'value' => 'este es el valor de la cookie paloma',
                                                    ]));
                                     
                                     $session = Yii::$app->session;
                                     $session->open();
                                 if($session->has('repuestasExamen')){
                                    $session->remove('repuestasExamen');
                                    }
                                     
                                     
                                     
                                     $steps=$this->prepareDataToRenderExamen($cita);
                                    return  $this->render('_examen_virtual',['id'=>$id,'model'=>$cita,'steps'=>$steps,'numeroPreguntas'=>$numeroPreguntas]); 
                                     //Yii::$app->session->setFlash('success',yii::t('sta.messages','Bienvenido al Examen Virtual'));
                                     //$this->redirect($this->action->id);
                                 }
  
  
    
         
    }
    
}
    
    
    
    
    
    
    
    
    
    
    /*
    $this->layout="install";
     $session = Yii::$app->session;
      $cita=$this->findModel($id); 
      //var_dump($session->get('token'));die();
    if(($session->get('tokenBanco')===null)){
             yii::error('no hya sesion token');  
                $cadenatoken=h::request()->get('token');
                yii::error('le token get es:  '.$cadenatoken); 
                $token=\common\components\token\Token::compare('citas', 'token_'.$cita->id, $cadenatoken);
                     if(is_null($token)){
                              
                                     echo "no pasa nada con tu roken";die();
                            }else{
                                yii::error('comparo el token es ok,a har creando la sesion');
                                    $session->set('tokenBanco', $cadenatoken);
                                    yii::error('borrando el token');
                                    $token->delete();
                                     yii::error('Crenado el detalle ');
                                     $cita->generaExamenes();
                                     echo "hola tod fue un exito"; die();
                                    //return  $this->render('_examen_virtual',['model'=>$examen]);
       
                                 }
        
    }else{
      $proveedores=$cita->providersExamenes(); 
      
      $steps=[];
      $i=1;
      foreach($proveedores as $code=>$proveedor){
          $modeloMuestra=$proveedor->models[0];
          $calificaciones=$modeloMuestra->test->arrayCalificaciones();
          $steps[$i]=[
              'title' => $modeloMuestra->descripcion,
               'icon' => 'glyphicon glyphicon-cloud-upload',
              'content' => $this->renderPartial('_examen_step',
                                ['model'=>$cita,'calificaciones'=>$calificaciones,'proveedor'=>$proveedor,'codexamen'=>$code]
                      ),
          ];
          $i++;
      }
      
      
       
       return  $this->render('_examen_virtual',['model'=>$cita,'steps'=>$steps]); 
      */
     
    
    
    


function actionBancoPreguntas($id){
  if(h::request()->isAjax){
       $mensajes=[];
               h::response()->format = \yii\web\Response::FORMAT_JSON;
      $model=$this->findModel($id);
      $model->generaExamenes();
      $mensajes['success']=yii::t('sta.labels','El banco de preguntas está completo');
      return $mensajes;
  }
}  



 public function actionRespuestaExamen(){
     if(h::request()->isAjax){
          $identidad=h::request()->get('identidad');
          $valor=h::request()->get('valor');
          $numeroPreguntas=h::request()->get('npreg');
        if(false){
          $mensajes=[];
      
         $examendet=\frontend\modules\sta\models\StaExamenesdet::findOne($identidad);
         $porcentaje=$examendet->examen->porcentajeAvance();unset($examendet);         
         $exito=\frontend\modules\sta\models\StaExamenesdet::respuesta($identidad, $valor);
                if($exito){
                     return $this->renderAjax('_progress',['porcentaje'=>$porcentaje]);
                        }else{
                        }  
        } else{
           $session = Yii::$app->session;
           $session->open();
           $arrayRespuestas=[];
           if(!$session->has('repuestasExamen')){
             $arrayRespuestas[$identidad]=$valor;
             $session['repuestasExamen']=$arrayRespuestas;
           }else{
               $arrayRespuestas=$session['repuestasExamen']; 
               $arrayRespuestas[$identidad]=$valor;
               $session['repuestasExamen']=$arrayRespuestas;
           }
         
          $porcentaje=((integer)$numeroPreguntas>0)?round((100*count($session['repuestasExamen'])/$numeroPreguntas),3):0;
           $itemsFaltantes=[];
          if($porcentaje>=90){
             if($session->has('IdsPreguntas')){
              $faltan=array_diff($session['IdsPreguntas'],array_keys($arrayRespuestas));
              $testdetsIds=(new \yii\db\Query())->select(['test_id'])
                                    ->from(['a'=>'{{%sta_examenesdet}}'])->where(['id'=>array_values($faltan)])->all();
              $testdetsIds= array_map('intval',array_column($testdetsIds, 'test_id'));
              //yii::error($testdetsIds);
              $itemsFaltantes=(new \yii\db\Query())->select(['item','pregunta','codtest'])
                                    ->from(['a'=>'{{%sta_testdet}}'])->where(['id'=>$testdetsIds])->all();
              // yii::error($session['IdsPreguntas']); 
              //yii::error(array_keys($arrayRespuestas));
              //yii::error('preguntas faltante');
              //yii::error($faltan);
              //yii::error($itemsFaltantes);
             }
              
              
          }
    // yii::error($session['repuestasExamen']);
    // yii::error(count($session['repuestasExamen']));
    // yii::error($numeroPreguntas);
            return $this->renderAjax('_progress',[ 'itemsFaltantes'=> $itemsFaltantes,'porcentaje'=>$porcentaje]);
           
        }
         
         
     }
 }
 
 public function actionTerminaExamen($id){
      $this->layout="install";
      $id=$id.'';
    if(preg_match("/[^a-z\d]/i", $id)){
      echo "cuidado, cuidado que travesuras estás haciendo..., ya te tengo registrado";die();
    
    }
        
     $model=Citas::findFree()->where(['id'=>$id])->one();
  if(is_null($model)){
    $mensaje=yii::t('sta.errors','¡ El enlace no es el correcto...!');
    return $this->render('finalizacion_examen_error',['mensaje'=>$mensaje]);  
  }
   
    $session=Yii::$app->session;
    if($session->has('IdsPreguntas') && $session->has('repuestasExamen')){
             
      $npreguntas=count($session['IdsPreguntas']);
       $nrespuestas=count($session['repuestasExamen']);
       if($npreguntas > $nrespuestas){
           echo " Ups .... Aquí ha pasado algo raro; no has completado la batería de preguntas, acércate a tutoría ";die();
       }
           
     //yii::error($cookiesRead->has($nombrecookie));
     //yii::error(Yii::$app->session->has('repuestasExamen'));
      
          $arrayRespuestas=$session['repuestasExamen'];           
             foreach($arrayRespuestas as $clave=>$valor){
                 Yii::$app->db->createCommand()
             ->update('{{%sta_examenesdet}}', ['valor' => $valor], 'id=:clave',[':clave'=>$clave])
             ->execute();
                   }
                   
             
            //$model->makeResultados();                   
           $session->remove('repuestasExamen');
           //$cookies = Yii::$app->response->cookies;
           //$model->ftermino=$model->CarbonNow()->format($model->formatToCarbon($model::_FDATETIME));
             // $model->save();
        // remueve una cookie
           // $cookies->remove($nombrecookie);
           return $this->render('finalizacion_examen');
      }else{
          $mensaje=yii::t('sta.errors','No, no ..., así no. Estás accediendo de una mala manera..., solicita un nuevo token');
          return $this->render('finalizacion_examen_error',['mensaje'=>$mensaje]); 
      }
     
                                    
 }
 
 

 public function actionCookies(){
     $cookiesRead = Yii::$app->request->cookies;
     $cookiesSend = Yii::$app->response->cookies;
     //var_dump($cookiesRead);die();
     echo "hay ".$cookiesRead->count()."  cookies<br>";
     
     $cookiesSend->add(new \yii\web\Cookie([
                                        'name' => 'camaron_59',
                                        'value' =>  'biblia',
                                                    ]));
     echo "AHORA hay ".$cookiesRead->count()."  cookies<br>";
     var_dump($cookiesRead);
 }
 
 
 private function prepareDataToRenderExamen($cita){
     $proveedores=$cita->providersExamenes(); 
     $numeroPreguntas=$cita->numeroPreguntas();
      $steps=[];
      $i=1;
      foreach($proveedores as $code=>$proveedor){
          //var_dump($proveedor->models);die();
          $modeloMuestra=$proveedor->models[0];
          $calificaciones=$modeloMuestra->test->arrayCalificaciones();
          $steps[$i]=[
              'title' => $modeloMuestra->codtest,
               'icon' => 'glyphicon glyphicon-list-alt',
              'content' => $this->renderPartial('_examen_step',
                                ['mensaje'=>$modeloMuestra->detalletest,'modeloMuestra'=>$modeloMuestra,'model'=>$cita,'calificaciones'=>$calificaciones,'proveedor'=>$proveedor,'codexamen'=>$code,'numeroPreguntas'=>$numeroPreguntas]
                     
                      ),
              'buttons' => [
				'next' => [
					'title' => 'Siguiente', 
					'options' => [
						'class' => 'btn btn-success'
					],
				 ],
                                 'prev' => [
					'title' => 'Previo', 
					'options' => [
						'class' => 'btn btn-success'
					],
				 ],
                                 'save' => [
					'title' => 'Terminar', 
					'options' => [
						'class' => 'btn btn-warning'
					],
				 ],
			 ],
          ];
          $i++;
      }
    return $steps;
 }
 public function actionReprogramaCita(){
    if(h::request()->isAjax){
         h::response()->format = \yii\web\Response::FORMAT_JSON;
     $id=h::request()->get('idcita');
     $model= $this->findModel($id);
     $fechaInicio=h::request()->get('finicio');
     $fechaTermino=h::request()->get('ftermino');
     //var_dump($fechaInicio,$fechaTermino);die();
     //yii::error('fecha inicio '.$fechaInicio);
      //yii::error('fecha termino '.$fechaTermino);
     if(is_null($fechaTermino)){
         $verifiFtem=true;
     }else{
         $verifiFtem=timeHelper::IsFormatMysqlDateTime($fechaTermino);
     }
     //VAR_DUMP(timeHelper::IsFormatMysqlDateTime($fechaInicio) ,$verifiFtem);DIE();
     if (timeHelper::IsFormatMysqlDateTime($fechaInicio) && 
         $verifiFtem) {
    if($model->reprograma($fechaInicio, $fechaTermino)){
         return ['success'=>yii::t('sta.labels','Se reprogramó la cita')];
     }else{
         return ['error'=>yii::t('sta.errors','Hubo problemas: ').$model->getFirstError()]; 
     }
} else {
   return ['error'=>yii::t('sta.errors','Problema en el formato de fechas ')]; 
}
     
     //$mensajes=[];
    }   
    echo "hi"; 
 }
 
 public function actionAgregaBateria($id){
     if(h::request()->isAjax){
          h::response()->format = \yii\web\Response::FORMAT_JSON;
         $model=$this->findModel($id);
        $codbateria=h::request()->get('bateria');
        if(in_array($codbateria, array_keys(\frontend\modules\sta\helpers\comboHelper::baterias()))){
           if($idLastCita=$model->lastCitaWithExamen()){
             return ['error'=>yii::t('sta.errors','Ya existía la cita {numerocita} con evaluaciones',['numerocita'=>Citas::findOne($idLastCita)->numero])];   
           }
            $model->agregaBateria($codbateria); 
           return ['success'=>yii::t('sta.errors','Se agregaron las pruebas de la batería')];
        }else{
          return ['error'=>yii::t('sta.errors','Código de batería no válido')];   
        }
        
     }
     
 }
 
 
  public function  actionResultados($id){

    if(h::request()->isAjax){
         h::response()->format = \yii\web\Response::FORMAT_JSON;
         $cita= $this->findModel($id);
      if(is_null($cita))
            return ['error'=>yii::t('sta.errors','Error : NO se encontró el registro cita')];
       if(!$cita->asistio)
            return ['error'=>yii::t('sta.errors','NO puede completar esta operación mientras la cita no tenga asistencia')];
      if(!$cita->hasCompletePreguntas())
            return ['error'=>yii::t('sta.errors','El banco de preguntas aun no esta completo, refresque preguntas')];
      if(!$cita->isBateriaCompleta())
           return ['error'=>yii::t('sta.errors','Error: Hay preguntas sin contestar o el alumno aun no ha rendido la prueba, verifique por favor')];
      $cita->makeResultados();
       return ['success'=>yii::t('sta.errors','Se han procesado las pruebas, con éxito')];
     
    }

}
 
public function actionEliminaCita($id){
    $model=$this->findModel($id);
    $errores=$model->eliminaCita();
    
    if(count($errores)>0){
        Yii::$app->session->setFlash('error', 'No se pudo eliminar la cita '.$model->getFirstError());
         return $this->redirect(['view', 'id' => $model->id]);
    }else{
         Yii::$app->session->setFlash('success', 'La cita ha sido eliminada');
        return $this->redirect(['view', 'id' => $model->id]);
         
    }
} 
 
public function actionReportInfPsicologico($id){
    $this->layout="reportes";
    if($id==0){
        $id=h::request()->get('identidad');
    }
    $model= \frontend\modules\sta\models\StaDocuAlu::findOne($id);
    $referencia=h::request()->get('urlimagen','');
    
    $ruta= \yii::getAlias('@frontend/web/img_repo/e1');  
    if(strlen($referencia)>0){
          if(!file_exists(\yii::getAlias('@frontend/web/img_repo/e1/'.$id.'.svg'))){
           $recurso=fopen('http://export.highcharts.com/'.$referencia,'r');
            file_put_contents($ruta.'/'.$id.'.svg', $recurso);  
            fclose($recurso);
          }
         $rutaImagen= \yii\helpers\Url::to("@web/img_repo/e1/".$id.'.svg');
    
            
    }else{
         $rutaImagen=''; 
    }
    
    $rutaTemporal=\yii::getAlias('@frontend/modules/sta/archivos/informes/');
    if(is_null($model))
   throw new NotFoundHttpException(Yii::t('sta.labels', 'No se encontro ningun registro con el Cid '.$id));
   $codocu=$model->codocu;
    
    
    /*Filtro de acceso*/
             if($model->hasMethod('canDownload')){
                 if(!$model->canDownload()){
                     return "no puedes Visualizar este documento"; 
                 }
             }
       /*Fin del filtro */
             
    /*Ahora la auditoria*/   
   if(strlen($referencia)==0) //Siempre que no sea una llmada ajax a una report builder
   $model->logAudit(\common\behaviors\AccessDownloadBehavior::ACCESS_VIEW);
   
   
     $view="/citas/reportes/reporte_".$codocu;
     $alumno=$model->talleresdet->alumno;    
    if($codocu=='106'){
         $cita=Citas::findOne($model->cita_id);
            $examenesId=$cita->examenesId();
            //var_dump($examenesId);die();
            $resultados= \frontend\modules\sta\models\StaResultados::find()->andWhere(['examen_id'=>$examenesId])->all();
         $pagina=$this->render($view,['rutaimagen'=>$rutaImagen,'model'=>$model,'alumno'=>$alumno,'resultados'=>$resultados]);
    
    }
    if($codocu=='107'){
         $cita=Citas::findOne($model->cita_id);
            $examenesId=$cita->examenesId();
            //var_dump($examenesId);die();
            //$resultados= \frontend\modules\sta\models\StaResultados::find()->andWhere(['examen_id'=>$examenesId])->all();
         $pagina=$this->render($view,['rutaimagen'=>$rutaImagen,'model'=>$model,'alumno'=>$alumno,'examenesId'=>$examenesId]);
    
    }
    if($codocu=='105'){
       $cita=Citas::findOne($model->cita_id);
            $examenesId=$cita->examenesId();
            //var_dump($examenesId);die();
            //$resultados= \frontend\modules\sta\models\StaResultados::find()->andWhere(['examen_id'=>$examenesId])->all();
         $pagina=$this->render($view,['rutaimagen'=>$rutaImagen,'model'=>$model,'alumno'=>$alumno,'examenesId'=>$examenesId]);
    
    }
   if($codocu=='104'){
      // echo "En proceso... Disculpen las molestias";die();
          //Solo ara el documento 104
         $citas=Citas::find()->andWhere(['asistio'=>'1','talleresdet_id'=>$model->talleresdet_id])->orderBy('fechaprog asc')->all();
       $pagina=$this->render($view,['rutaimagen'=>$rutaImagen,'model'=>$model,'alumno'=>$alumno,'citas'=>$citas]);
    
    }
     //return $this->render("/citas/reportes/cabecera");
     
  if($codocu=='107'){
     if(strlen($rutaImagen)==0){
       // file_put_contents($ruta.'/INFORME_'.$model->id.'.html', $pagina);
       return $pagina;  
    }else{
        $nombre=$model->codocu.'-'.$alumno->codalu.'-'.$alumno->ap.'-'.$model->id.'-'.str_replace('-','_',str_replace(' ','_',date(timeHelper::formatMysqlDateTime()))).'-'.h::userId().'.pdf';
     
      $this->preparePdf($pagina)->Output($rutaTemporal.$nombre,
            \Mpdf\Output\Destination::FILE);
       $model->deleteAllAttachments();
      $model->attachFromPath($rutaTemporal.$nombre);
      $model->changeStatusImpresion();
      unlink($rutaTemporal.$nombre);
      return;
      } 
  }
  
  if($codocu=='105'){
    if(strlen($rutaImagen)==0){
       // file_put_contents($ruta.'/INFORME_'.$model->id.'.html', $pagina);
       return $pagina;  
    }else{
        $nombre=$model->codocu.'-'.$alumno->codalu.'-'.$alumno->ap.'-'.$model->id.'-'.str_replace('-','_',str_replace(' ','_',date(timeHelper::formatMysqlDateTime()))).'-'.h::userId().'.pdf';
     
      $this->preparePdf($pagina)->Output($rutaTemporal.$nombre,
            \Mpdf\Output\Destination::FILE);
       $model->deleteAllAttachments();
      $model->attachFromPath($rutaTemporal.$nombre);
      $model->changeStatusImpresion();
      unlink($rutaTemporal.$nombre);
      return;
    }
  }
  
   if($codocu=='104')
  return $pagina;
  if($codocu=='106'){
       if(strlen($rutaImagen)==0){
       // file_put_contents($ruta.'/INFORME_'.$model->id.'.html', $pagina);
       return $this->preparePdf($pagina)->Output();       
    }else{
        $nombre=$model->codocu.'-'.$alumno->codalu.'-'.$alumno->ap.'-'.$model->id.'-'.str_replace('-','_',str_replace(' ','_',date(timeHelper::formatMysqlDateTime()))).'-'.h::userId().'.pdf';
     
      $this->preparePdf($pagina)->Output($rutaTemporal.$nombre,
            \Mpdf\Output\Destination::FILE);
       $model->deleteAllAttachments();
      $model->attachFromPath($rutaTemporal.$nombre);
      $model->changeStatusImpresion();
      unlink($rutaTemporal.$nombre);
      return;
      } 
      
      
      
  }
   
            
}

private function preparePdf($contenidoHtml){
  //  $contenidoHtml = \Pelago\Emogrifier\CssInlinerCssInliner::fromHtml($contenidoHtml)->inlineCss()->render();
  //->renderBodyContent(); 
    $mpdf= \frontend\modules\report\Module::getPdf();
    // $mpdf->SetHeader(['{PAGENO}']);
   $mpdf->margin_header=1;
   $mpdf->margin_footer=1;
   $mpdf->setAutoTopMargin='stretch';
  $mpdf->setAutoBottomMargin='stretch';
  
   $stylesheet = file_get_contents(\yii::getAlias("@frontend/web/css/bootstrap.min.css")); // external css
   //$stylesheet2 = file_get_contents(\yii::getAlias("@frontend/web/css/reporte.css")); // external css
   $mpdf->WriteHTML($stylesheet,1);
    //$mpdf->WriteHTML($stylesheet2,1);
   
   $mpdf->DefHTMLHeaderByName(
  'Chapter2Header',$this->render("/citas/reportes/cabecera")
);
   //$mpdf->DefHTMLFooterByName('pie',$this->render("/citas/reportes/footer"));
   $mpdf->SetHTMLHeaderByName('Chapter2Header');
  // $contenidoHtml = \Pelago\Emogrifier\CssInliner::fromHtml($contenidoHtml)->inlineCss($stylesheet)->render();
   $mpdf->WriteHTML($contenidoHtml);
      return  $mpdf; 
}



public function actionRefreshEtapa($id){
   $alumnitos= \frontend\modules\sta\models\Talleresdet::except()->where(['talleres_id'=>$id])->all();
    foreach($alumnitos as $alumno){
       $citas=$alumno->getCitas()->orderBy('fechaprog asc')->all();
       $contador=1;
        foreach($citas as $cita){
            if($cita->masivo){
                $cita->flujo_id=1;
                $cita->save();
            }else{
                if($contador==1){                
                  $cita->flujo_id=2;
                  $cita->save();
                 if($cita->asistio){
                    $contador++;
                    }
                }else{
                  $cita->flujo_id=3;
                  $cita->save();
                  $contador++;
                }
              
            }
        }
    }
}


public function actionProcesaBatch($id){
    //hallando las citas que tienen examenes

        if (h::request()->isAjax) {
                h::response()->format = Response::FORMAT_JSON;
                $taller=Talleres::findOne($id);
            if(!is_null($taller)){
                $codfac=$taller->codfac;
                $idsExamenes=\frontend\modules\sta\models\StaExamenesdet::find()->select(['examenes_id'])->distinct()->
                        andWhere(['codfac'=>$codfac,'puntaje'=>null])->andWhere(['not',['valor'=>null]])->column();
                
                $idCitas=Examenes::find()->select(['citas_id'])->distinct()->andWhere(['id'=>$idsExamenes])->column();
                

                    $citas=Citas::find()->andWhere(['id'=>$idCitas])->all();
                       //  var_dump($idCitas);die();
                           //var_dump(count($citas));die();
                    foreach($citas as $cita){     
                            $cita->makeResultados(); 
    
                            }
                                return ['success'=>yii::t('sta.labels','Se procesaron las evaluaciones')];
                //return ActiveForm::validate($model);
        }
 
   
   }
}



/*
 * FUNCION EU CREA O ACTUALIZA EL PADRON DE ASISTENCIAS
 * 
 */
public function actionAsistencias(){
   if(h::request()->isAjax){
         h::response()->format = Response::FORMAT_JSON;         
     $talleres=Talleres::find()->andWhere(['codperiodo'=> staModule::getCurrentPeriod()])->all();
     foreach($talleres as $taller){
        $taller->refrescaAsistencia(); 
     }
     return ['success'=>yii::t('sta.labels','Se ha actualizado el parte de asistencia')];
     
    }
}


public function actionResumenListado(){
      
        $searchModel = new \frontend\modules\sta\models\StaResumenasistenciasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       // h::session()->setFlash('warning',yii::t('sta.labels','No olvide refrescar los datos con el botón naranja de la parte superior'));
        return $this->render('resumen_asistencias', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
}

public function actionReprogramaMasivo(){
   /* $citas=Citas::find()->andWhere(['>','fechaprog','2020-03-30 00:00:00'])->
           andWhere(['<','fechaprog','2020-03-31 23:59:00'])->all();*/
    
    $citas=Citas::find()->andWhere(['>','fechaprog','2020-04-12 00:00:00'])->
           andWhere(['codfac'=>'FC'])->orderBy('fechaprog asc')->all();
    /*ECHO (Citas::find()->andWhere(['>','fechaprog','2020-03-30 00:00:00'])->
           andWhere(['codfac'=>'FIC'])->orderBy('fechaprog asc')->createCommand()->getRawSql());
   die();*/
   
    foreach($citas as $cita){
        $fechaOriginal=$cita->toCarbon('fechaprog');
        $fechaPostergada=$cita->toCarbon('fechaprog')->addDays(7);
        echo $cita->codfac."  : Fecha programada ".$fechaOriginal->format('d/m/Y')."   Fecha Reporgaramada ".$fechaPostergada->format('d/m/Y')." <br>";
        if($cita->reprograma($fechaPostergada)){
            echo "exito <br>";
        }else{
           echo "fracaso <br> ".$cita->getFirstError()."<br>"; 
        }
    }
    die();
    
    foreach($citas as $cita){
        //$diaactual=$cita->toCarbon('fechaprog')->weekDay();
        
        if($cita->toCarbon('fechaprog')->weekDay()==5){
         $nuevaFecha=$cita->toCarbon('fechaprog')->addDay(3);   
        }ELSE{
          $nuevaFecha=$cita->toCarbon('fechaprog')->addDay(1);     
        }
     $codigotra=$cita->taller->psicologoPorDia($nuevaFecha);
          
            if($codigotra==$cita->codtra){
               if($cita->reprograma($nuevaFecha)){
                    yii::error('ok'); 
                }else{
                    yii::error('error');
                } 
            }else{
                
            }
        //$rango=$cita->horarioToday();
      // echo $cita->toCarbon('fechaprog')->format('d D').'('.$cita->toCarbon('fechaprog')->weekDay().')  A  ->    '.$nuevaFecha->format('d D').' ('.$nuevaFecha->weekDay().") <BR>";
        
        
    }
}

/*FUNCION PARA PODER RESCATAR O BORRAR  LOS TOKENS 
 * ENVIADOS EN CASO DE ERROR POR EJEMPLO
 * UN ALUMNO REGISTRO EL CORREO DE UN AMIGO, PERO LUEGO
 * SE EQUIVOCO Y EL TOKEN QUEDA ABIERTO 
 * ESTO ES UN PELIGRO, ENTONCES TENEMOS QUE BORRARLO 
 * $id: Id del alumno
 */
public function actionRescueToken($id){
   
 if (h::request()->isAjax) {
        $registro= Alumnos::findOne(['codalu'=>$id]);  
     
                h::response()->format = Response::FORMAT_JSON;
       if(!is_null($registro)){
   \common\components\token\Token::deleteAll(['name'=>'token_'.$registro->id]); 
     return ['success'=>yii::t('sta.labels','Se rescató el token para este Alumno')];
             } else{
      return ['error'=>yii::t('sta.labels','No se ha encontrado ningún registro para este Id')];            
             }        
        } 
}

public function actionPruebasIncompletas(){
    
        $idsExamenes= \frontend\modules\sta\models\StaExamenesdet::find()->
        select(['examenes_id'])-> andWhere(['valor'=>null])->column();   
       $idCitas=\frontend\modules\sta\models\Examenes::find()->
        select(['citas_id'])->andWhere(['id'=>$idsExamenes])->column(); 
       $searchModel = new StaVwCitasSearch();
        $dataProvider = $searchModel->searchByIds(Yii::$app->request->queryParams,$idCitas);
       
       
    return $this->render('index_faltan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); 
}

public function actionAgregaIndicador($id){        
         $this->layout = "install";
         $cita=$this->findModel($id);
         $model= new \frontend\modules\sta\models\StaCitaIndicadores();
         //$model->setScenario($model::SCENARIO_AGREGA_ALUMNO); 
         $model->citas_id=$cita->id;
         $model->talleresdet_id=$cita->talleresdet_id;
         $model->codfac=$cita->codfac;
         
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
             // $mensajes= $evento->creaDetalle($model->codalu);
              
             $model->save();
             // yii::error($mensajes,__FUNCTION__);
               // $model->save();
                //var_dump($model->talleres_id,$model->getOldAttribute('codtra'),$model->codtra);die();
                //$model->cambiaPsicologo($model->codtra);
                  //$model->taller->sincronizeCant();
                return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_agrega_indicador', [
                       // 'modelTaller' => $model->talleres,
                         'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                       // 'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }

    } 

public function actionEditaIndicador($id){        
         $this->layout = "install";
         //$cita=$this->findModel($id);
         $model= \frontend\modules\sta\models\StaCitaIndicadores::findone($id);
         //$model->setScenario($model::SCENARIO_AGREGA_ALUMNO); 
        
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
             // $mensajes= $evento->creaDetalle($model->codalu);
              
             $model->save();
             // yii::error($mensajes,__FUNCTION__);
               // $model->save();
                //var_dump($model->talleres_id,$model->getOldAttribute('codtra'),$model->codtra);die();
                //$model->cambiaPsicologo($model->codtra);
                  //$model->taller->sincronizeCant();
                return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_agrega_indicador', [
                       // 'modelTaller' => $model->talleres,
                         'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                       // 'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }

    } 
/*
 * Renderiza el delallde una cuta por emdio de un ajax 
 */
 public function actionAjaxDetalleCita(){
   
  if(h::request()->isAjax)  {
     $id=h::request()->post('expandRowKey');
    $model=$this->findModel($id);
    
       return $this->renderAjax('_ajax_view', [
                       // 'modelTaller' => $model->talleres,
                         'model' => $model
            ]); 
  }
  
 } 
 

   

public function actionDataToGraph($id){
      if(h::request()->isAjax){
          
             h::response()->format = \yii\web\Response::FORMAT_JSON;
    $model=\frontend\modules\sta\models\StaDocuAlu::findOne($id);
    return ['success'=>$model->dataGraph()];
      }
}

public function  actionAjaxShowLogInformes(){
       if(h::request()->isAjax){
        $id=h::request()->post('expandRowKey');
         //h::response()->format = \yii\web\Response::FORMAT_JSON;
        return $this->renderPartial("/citas/reportes/_ajax_log",['id'=>$id,'nombreclase'=>'StaDocuAlu']);
       
            }
  
       }
       
public function actionAsistenciasTalleres(){
    return $this->render('resumen_asistencias_taller');
}

}
