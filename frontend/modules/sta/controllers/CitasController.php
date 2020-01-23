<?php

namespace frontend\modules\sta\controllers;
USE frontend\modules\sta\staModule;
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
        //print_r($model->codExamenes());die();
     
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                 //var_dump(h::request()->isAjax,$model->load(h::request()->post()));die();
                yii::error('paso por is ajax  load Post');
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            yii::error('paso por Load y save()');
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            //print_r($model->getErrors());die();
        }
       $eventos=$model->putColorThisCodalu($model->eventosPendientes());
       yii::error('Renderizando vista');
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
        $token=  \common\components\token\Token::create('citas', 'token_'.$alumno->id, null, time());
       
       // $cita=$examen->cita;
        
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
    //User::findByUsername($this->username)
    //var_dump($this->getUser());DIE();
     $cita=Citas::findFree()->where(['id'=>$id])->one();
      Yii::$app->user->login($this->getUser(),3600 * 24 * 30 );
  if(staModule::isPcRegistered($cita->taller->id)){
     
    $cookiesRead = Yii::$app->request->cookies;
    $cookiesSend = Yii::$app->response->cookies;
    $nombrecookie='calamaro_'.$id;
     $this->layout="install";
   
     
    if($cookiesRead->has($nombrecookie)){
        yii::error('Ya tiene  cookie '.$nombrecookie);
        $steps=$this->prepareDataToRenderExamen($cita);
       return  $this->render('_examen_virtual',['model'=>$cita,'steps'=>$steps]); 
        
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
                                     yii::error('Crenado el detalle ');
                                     $cita->generaExamenes();
                                     yii::error('creando la cookie');
                                     //echo "hay  ".$cookiesRead->count()." cookies <br> ";
                                     $cookiesSend->add(new \yii\web\Cookie([
                                        'name' => $nombrecookie,
                                        'value' => 'este es el valor de la cookie paloma',
                                                    ]));
                                     $steps=$this->prepareDataToRenderExamen($cita);
                                    return  $this->render('_examen_virtual',['model'=>$cita,'steps'=>$steps]); 
                                     //Yii::$app->session->setFlash('success',yii::t('sta.messages','Bienvenido al Examen Virtual'));
                                     //$this->redirect($this->action->id);
                                 }
  }
  }else{
      $this->render('mensaje_no_pc_registrada');
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
         $mensajes=[];
      // h::response()->format = \yii\web\Response::FORMAT_JSON;
         $identidad=h::request()->get('identidad');
         $valor=h::request()->get('valor');
         $examendet=\frontend\modules\sta\models\StaExamenesdet::findOne($identidad);
         $porcentaje=$examendet->examen->porcentajeAvance();unset($examendet);         
         $exito=\frontend\modules\sta\models\StaExamenesdet::respuesta($identidad, $valor);
         if($exito){
            return $this->renderPartial('_progress',['porcentaje'=>$porcentaje]);
         }else{
            
         }
         
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
      $steps=[];
      $i=1;
      foreach($proveedores as $code=>$proveedor){
          $modeloMuestra=$proveedor->models[0];
          $calificaciones=$modeloMuestra->test->arrayCalificaciones();
          $steps[$i]=[
              'title' => $modeloMuestra->descripcion,
               'icon' => 'glyphicon glyphicon-cloud-upload',
              'content' => $this->renderPartial('_examen_step',
                                ['modeloMuestra'=>$modeloMuestra,'model'=>$cita,'calificaciones'=>$calificaciones,'proveedor'=>$proveedor,'codexamen'=>$code]
                      ),
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
     if(is_null($fechaTermino)){
         $verifiFtem=true;
     }else{
         $verifiFtem=timeHelper::IsFormatMysqlDateTime($fechaTermino);
     }
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
     
 }
}
