<?php

namespace frontend\modules\sta\controllers;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use frontend\modules\sta\models\VwAlutallerSearch;
use yii;
use common\helpers\h;
use common\models\User;
use frontend\modules\sta\models\UserFacultades;
use frontend\modules\sta\models\Facultades;
use frontend\modules\sta\models\Aluriesgo;
use frontend\modules\sta\models\Tallerpsico;
use frontend\modules\sta\models\Talleresdet;
use mdm\admin\models\searchs\User as UserSearch;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
/**
 * Default controller for the `sta` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        /*
     * Esto no debe ser manual debe leerse de tablas,
     * mejora resto
     */
    $etapas=[
       1=>'EVALUACIÓN DE ENTRADA',
       2=>'ENTREVISTA INICIAL',
       3=>'TUTORIAS INDIVIDUALES',
       4=>'TALLERES',
       5=>'EVALUACION FINAL'
    ];
    $iconos=[
       1=>'fa fa-stethoscope',
       2=>'fa fa-comments',
       3=>'fa fa-user-clock',
       4=>'fa fa-users-cog',
       5=>'fa fa-stethoscope'  
    ];
    $codperiodo=h::request()->get('codperiodo', \frontend\modules\sta\staModule::getCurrentPeriod());
   
    $query=\frontend\modules\sta\models\StaResumenasistencias::
     find()->where(['codperiodo'=>$codperiodo]);
    
    
   
 $userLogin=(new \yii\db\Query())->select("count(*) as nlogin , b.username") ->  
  from("{{%useraudit}} a")->innerJoin('{{%user}} b','a.user_id=b.id')->
       where(['action'=>'login'])->groupBy('user_id')->orderBy('count(*) desc')->all();
 
 
  $userActivity=(new \yii\db\Query())->select("count(*) as nactividad, username")->
    from("{{%activerecordlog}} a")->groupBy('username')->orderBy('count(*) desc')->all();

   
    $indiAvances= \frontend\modules\sta\components\Indicadores::IndiAvances($codperiodo);
    //print_r($indiAvances['examenes']);die();
   //  $indiAvances=\frontend\modules\sta\components\Indicadores::IndiAvanceByFac('FAUA','2020I');
  return   $this->render('index',
          [
              'indiAvances'=>$indiAvances,
              'userLogin'=>$userLogin,
              'userActivity'=>$userActivity,
              'etapas'=>$etapas,
              'iconos'=>$iconos
          ]);
    }
    
    public function actionProfile(){
        UserFacultades::refreshTableByUser();
        $model =Yii::$app->user->getProfile() ;
       // var_dump($model);die();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           // var_dump($model->getErrors()   );die();
            yii::$app->session->setFlash('success','grabo');
            return $this->redirect(['profile', 'id' => $model->user_id]);
        }else{
           // var_dump($model->getErrors()   );die();
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }
    
    /*
     * Visualiza otros perfiles 
     */
     public function actionViewProfile($iduser){
         UserFacultades::refreshTableByUser($iduser);
         $newIdentity=h::user()->identity->findOne($iduser);
      if(is_null($newIdentity))
          throw new BadRequestHttpException(yii::t('base.errors','User not found with id '.$iduser));  
           //echo $newIdentity->id;die();
     // h::user()->switchIdentity($newIdentity);
         
        $profile =$newIdentity->getProfile($iduser);
        $profile->setScenario($profile::SCENARIO_INTERLOCUTOR);
        if(h::request()->isPost){
            $arrpost=h::request()->post();
              
            $profile->tipo=$arrpost[$profile->getShortNameClass()]['tipo'];
            $profile->codtra=$arrpost[$profile->getShortNameClass()]['codtra'];
            //var_dump(get_class($profile),$profile->validate());die();
            if (h::request()->isAjax) {
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($profile);
             }
           if ($profile->save()) {
            $this->updateUserFacultades($arrpost[UserFacultades::getShortNameClass()]);
            yii::$app->session->setFlash('success',yii::t('sta.messages','Se grabaron los datos '));
            return $this->redirect(['view-users']);
           }
            //var_dump(h::request()->post());die();
        }
        //echo $model->id;die();
       // var_dump(UserFacultades::providerFacus($iduser)->getModels());die();
        return $this->render('_formtabs', [
            'profile' => $profile,
            'model'=>$newIdentity,
            'userfacultades'=> UserFacultades::providerFacusAll($iduser)->getModels(),
        ]);
    }
    
     public function actionViewUsers(){
         $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('users', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionComplete(){
       return $this->render('completar');
    }
    
    
    /*
     * Actualizacion de los valores del aacultades uausuarios 
     */
    private function updateUserFacultades($arrpostUserFac){
        $ar=array_combine(ArrayHelper::getColumn($arrpostUserFac,'id'),
                ArrayHelper::getColumn($arrpostUserFac,'activa'));
        foreach($ar as $clave=>$valor){
           \Yii::$app->db->createCommand()->
             update(UserFacultades::tableName(),
             ['activa'=>$valor],['id'=>$clave])->execute();
        }
        
    }
    
    public function actionResumenFacultad(){
        $codfac = h::request()->get('codfac', h::user()->getFirstFacultad());
        $codperiodo = h::request()->get('codperiodo', \frontend\modules\sta\staModule::getCurrentPeriod());
        $model=$this->loadFacultad($codfac);
        $provAlumnos= Aluriesgo::worstStudentsByFacProvider($codfac,$codperiodo);
        $provCursos= Aluriesgo::worstCursosByFacProvider($codfac,$codperiodo);
        $nalumnos=Talleresdet::except()->select(['codalu'])->distinct()->join('INNER JOIN','{{%sta_talleres}} b','talleres_id=b.id')->andWhere(['t.codfac'=>$codfac,'codperiodo'=>$codperiodo])->count();//Aluriesgo::studentsInRiskByFacQuery($codfac,$codperiodo)->count();
    // ECHO Talleresdet::except()->select(['codalu'])->distinct()->join('INNER JOIN','{{%sta_talleres}} b','talleres_id=b.id')->andWhere(['t.codfac'=>$codfac,'codperiodo'=>$codperiodo])->createCommand()->getRawSql();
        //VAR_DUMP($nalumnos);DIE();
       $taller=\frontend\modules\sta\models\Talleres::findOne(['codfac'=>$codfac,'codperiodo'=>$codperiodo]);
        
       $frecuencia=$taller->periodo;
       $rotacion=round($taller->aluactivos*100/$taller->nAlumnos(),1);
       
//var_dump($taller->kp_contactados());die();
        return $this->render('resumenFacultad',[
            'taller_id'=>$taller->id,
                   'model'=>$model,
             'codfac'=>$codfac,
            'codperiodo'=>$codperiodo,
            'frecuencia'=>$frecuencia,
             'rotacion'=>$rotacion,
            'codperiodo'=>$codperiodo,
            'nalumnos'=>$nalumnos,
                   'provAlumnos'=>$provAlumnos,
                   'provCursos'=>$provCursos,
                    'kpiContacto'=>(!is_null($taller))?$taller->kp_contactados():\frontend\modules\sta\models\Talleres::kp_contactadosEmpty(),
                    ]);
    } 
    
    private function loadFacultad($codfac){
        
       if (($model = Facultades::findOne($codfac)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('base.names', 'The requested page does not exist.'));
             

    } 
    
  public function actionPanelPrograma(){
      $codfac=h::user()->getFirstFacultad();
       $nalumnos=Aluriesgo::studentsInRiskByFacQuery($codfac)->count();
       $taller=\frontend\modules\sta\models\Talleres::findOne(['codfac'=>$codfac,'codperiodo'=> \frontend\modules\sta\staModule::getCurrentPeriod()]);
       
       $tallerPsico=New Tallerpsico();
     $tallerPsico->codfac=$codfac;
     $citasPendientes=$tallerPsico->
            putColorThisCodalu(
                   $tallerPsico->eventosPendientes(),'',null);
    
     
       
     return $this->render('secretaria',[
         'codfac'=> $codfac,
          'citasPendientes'=> $citasPendientes,
          'nalumnos'=> $nalumnos,
        'kpiContacto'=>(!is_null($taller))?$taller->kp_contactados():\frontend\modules\sta\models\Talleres::kp_contactadosEmpty(),
                    
     ]);
  }  
  
  public function actionPanelPsicologo(){
      $formato= \common\helpers\timeHelper::formatMysqlDate();
      $fechadefaultHoy=Aluriesgo::CarbonNow()->format($formato);
     $fecha=h::request()->get('fecha',$fechadefaultHoy );
      $codperiodo= \frontend\modules\sta\staModule::getCurrentPeriod();
     $verifFecha=\common\helpers\timeHelper::IsFormatMysqlDate($fecha);
     //var_dump($verifFecha);die();
    $fecha=($verifFecha)?$fecha:$fechadefaultHoy;
     $nombresesion='correos_'.h::userId();
      //$codfac=h::user()->getFirstFacultad();     
      $codtra=h::user()->profile->codtra;
      $registro=\frontend\modules\sta\models\Rangos::findOne(['codtra'=>$codtra,'activo'=>'1','codperiodo'=>$codperiodo,'dia'=>date('w')]);
            yii::error($registro,__FUNCTION__);
      if(!is_null($registro)){
           // yii::error('se asigna del registro',__FUNCTION__);
       $codfac= $registro->talleres->codfac; 
       // yii::error('se escogio de registro  '.$codfac,__FUNCTION__);
      }else{
          //yii::error('se esgoge la pirmer afacultad que encuentra ',__FUNCTION__);
         $codfac=h::user()->getFirstFacultad(); 
          //yii::error('se escogio '.$codfac,__FUNCTION__);
      }
      //yii::error('La fecha es  '.$fecha,__FUNCTION__);
     
      
      
      
     // $provider = \frontend\modules\sta\models\StaVwCitasSearch::searchByPsicoToday($codfac/*,$fecha*/);
       $provider = \frontend\modules\sta\models\StaVwCitasSearch::searchByDay($codfac,$fecha);
       $sesion=h::session();
      if(!(date($formato)==$fecha)){
        
        $correos=[];
        $models=$provider->getModels();
        foreach($models as $model){
          $correos[$model->codalu]=[
              'correo'=>$model->correo,
              'nombres'=>$model->ap.'-'.$model->am.'-'.$model->nombres,
              'numerocita'=>$model->numerocita,
              'fechaprog'=>$model->fechaprog,
              ];
         }
         $sesion[$nombresesion]=$correos; 
      } else{
          $sesion->remove($nombresesion);
      }
      $tallerPsico=New Tallerpsico();
     $tallerPsico->codfac=$codfac;
     $citasPendientes=$tallerPsico->
            putColorThisCodalu(
                   $tallerPsico->eventosPendientes(),'',null);
    
     $tallerId= \frontend\modules\sta\models\Talleres::findOne(['codfac'=>$codfac,'codperiodo'=>$codperiodo])->id;
     
     /*
      * aQUI SELECCIONAMOS LOS ALUMNOS DE ESTE PSICOLOGO
      */
    $searchAlumnos = new VwAlutallerSearch();
        $providerAlu = $searchAlumnos->searchByPsicologo(
                h::request()->queryParams,$tallerId,$codtra);
        
         return $this->render('panelPsicologo',[
         'fecha'=>$fecha,
         'providerAlu' =>$providerAlu, 
              'provider' =>$provider, 
              'searchAlumnos' => $searchAlumnos,
          'citasPendientes'=> $citasPendientes,
          'codperiodo'=> $codperiodo,
             'codfac'=>$codfac,
               'codtra'=>$codtra
                  
     ]);  
   /* }else{
      return $this->render('psicologo',[
         'fecha'=>$fecha,
         'provider' =>$provider,
         
          'citasPendientes'=> $citasPendientes,
          'codperiodo'=>  \frontend\modules\sta\staModule::getCurrentPeriod(),
                  
     ]);  
    }*/
     
      
  }
  
  public function actionPanelInicio(){
    
     $codfac=$this->resolveFacultad();
     if(strlen($codfac)>10){
         return $codfac;
     }
      
     $fecha=$this->resolveFecha();
     $codperiodo= \frontend\modules\sta\staModule::getCurrentPeriod();
      
     $nombresesion='correos_'.h::userId();
     
     //$codtra=h::user()->profile->codtra;
     
     /////if(h::userId()==51){
         $codtra=$this->resolveCodtra($codfac,$codperiodo,$fecha);
         //var_dump($codtra);die();
     //}else{
        // $codtra=h::user()->profile->codtra;
     ///}
     $provider = \frontend\modules\sta\models\StaVwCitasSearch::searchByDay($codfac,$fecha);
     $sesion=h::session();
      if(!(date(\common\helpers\timeHelper::formatMysqlDate())==$fecha)){      
         $sesion[$nombresesion]=$this->correosDeAlumnosHoy($fecha, $provider); 
      } else{
          $sesion->remove($nombresesion);
      }
      $citasPendientes=$this->citaspendientes($codfac);
      
      /*
      * aQUI SELECCIONAMOS LOS ALUMNOS DE ESTE PSICOLOGO
      */
      //var_dump($codtra);die();
      $modelTaller=\frontend\modules\sta\models\Talleres::findOne(['codfac'=>$codfac,'codperiodo'=>$codperiodo]);
      $citasPendientes[]=$modelTaller->eventosPlanificacionSemana();
      
      $tallerId= $modelTaller->id;
      $searchAlumnos = new VwAlutallerSearch();
        $providerAlu = $searchAlumnos->searchByPsicologo(
                h::request()->queryParams,$tallerId,$codtra);
         return $this->render('panelPsicologo',[
         'fecha'=>$fecha,
         'providerAlu' =>$providerAlu, 
              'provider' =>$provider, 
              'searchAlumnos' => $searchAlumnos,
          'citasPendientes'=> $citasPendientes,
          'codperiodo'=> $codperiodo,
             'codfac'=>$codfac,
               'codtra'=>$codtra
                  
     ]);  
   /* }else{
      return $this->render('psicologo',[
         'fecha'=>$fecha,
         'provider' =>$provider,
         
          'citasPendientes'=> $citasPendientes,
          'codperiodo'=>  \frontend\modules\sta\staModule::getCurrentPeriod(),
                  
     ]);  
    }*/
     
     
     
     
     
  }
  /*
   * Esta funcion resuleve el codtra
   * si es secretaria intenta asigar un 
   * psicologo para eso se vale de la facultad
   * debe llmarse despue de hacer resolveFacultad
   * 
   */
  private function resolveCodtra($codfac,$codperiodo,$fecha){  
      
            
      if(h::user()->profile->tipo== \frontend\modules\sta\staModule::PROFILE_PSICOLOGO){
          //var_dump(h::user()->profile->codtra);die();
          $codtra=h::user()->profile->codtra;
           
          return $codtra;
      }elseif(h::user()->profile->tipo== \frontend\modules\sta\staModule::PROFILE_ASISTENTE){
           $sesion=h::session();
           if($sesion->has('psico_por_dia')){              
               return $sesion['psico_por_dia'];
           }else{
                $dia= \Carbon\Carbon::createFromFormat(
               \common\helpers\timeHelper::formatMysqlDate(),
                      $fecha)->dayOfWeek;             
          /*Intentamos encotrar el psicolo par aeste dia*/
                $query=\frontend\modules\sta\models\Rangos::find()->where([
                    'codfac'=>$codfac,
                    'codperiodo'=>$codperiodo,
                    'dia'=>$dia
                    ]);
                $cuantosHay=$query->count();  
                           
            if($cuantosHay >1 ){                 
                 $this->redirect(['seleccionar-psicologo','codfac'=>$codfac,'codperiodo'=>$codperiodo]);
            }               
          $codtra=\frontend\modules\sta\models\Rangos::find()->
             select(['codtra'])->andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo,'dia'=>$dia]
              )->scalar();
              if(IS_NULL($codtra) OR $codtra==false)
                    throw new BadRequestHttpException(yii::t('base.errors','Falta asignar psicólogo a esta facultad'));  
            }
           
       return $codtra;
      }else{
           throw new BadRequestHttpException(yii::t('base.errors','Accedió a esta ruta con un perfil no adecuado  '));  
          
      }
  }
  
  private function citaspendientes($codfac){
      $tallerPsico=New Tallerpsico();
     $tallerPsico->codfac=$codfac;
     return $tallerPsico->
            putColorThisCodalu(
                   $tallerPsico->eventosPendientes(),'',null);
  }
  
  private function correosDeAlumnosHoy($fecha,$provider){
      $correos=[];
        $models=$provider->getModels();
        foreach($models as $model){
          $correos[$model->codalu]=[
              'correo'=>$model->correo,
              'nombres'=>$model->ap.'-'.$model->am.'-'.$model->nombres,
              'numerocita'=>$model->numerocita,
              'fechaprog'=>$model->fechaprog,
              ];
         }
         return $correos;      
  }
  
  private function resolveFecha(){
      $formato= \common\helpers\timeHelper::formatMysqlDate();
      $fechadefaultHoy=Aluriesgo::CarbonNow()->format($formato);
      $fecha=h::request()->get('fecha',$fechadefaultHoy);
      //$codperiodo= \frontend\modules\sta\staModule::getCurrentPeriod();
     $verifFecha=\common\helpers\timeHelper::IsFormatMysqlDate($fecha);
     //var_dump($verifFecha);die();
     return ($verifFecha)?$fecha:$fechadefaultHoy;
  }
  
  public function resolveFacultad(){
      
      $codperiodo= \frontend\modules\sta\staModule::getCurrentPeriod();
      /*Primero verificamos si se pado el parametro codfac*/
      //var_dump( h::request()->get());die();
     if(!is_null(h::request()->get('codfac'))){
        //var_dump(h::request()->get('codfac'),h::user()->facultades);die();
         if(in_array(h::request()->get('codfac'),h::user()->facultades)){
             /*Si este parametro es correcto y coincide con las facultades del usuario, perfecto*/
             return h::request()->get('codfac');
         }else{/*Si no coi ndiice con ninguna facultad asiganda siomplente  arrojamos un error*/
            //var_dump(\yii\helpers\Url::current(),h::request()->get('codfac'),h::user()->facultades);die();
             return  $this->render('error_facultad');  
         }         
     }else{ //*Si no se paso el parametro buscamos el codfac por otros medios
         /*Primero averiguamos si el día de hoy tiene asignado una atención 
          * segun los horaros definidos en la tabla RANGOS 
          */
       
      $codtra=h::user()->profile->codtra;
      $facultadesAutorizadas=h::user()->facultades;
      $codfac=\frontend\modules\sta\models\Rangos::find()->
             select(['codfac'])->
              andWhere(
              ['codtra'=>$codtra,'codperiodo'=>$codperiodo,
                'codfac'=>$facultadesAutorizadas,'dia'=>date('w')]
              )->scalar();
     
        if($codfac){  
             
             $codfac= $codfac; 
           }else{ /*Si no lo 
              * encontró es porque:
            *   1)  Es un invitado viene de otra facultad
                Así que debemos darle a escoger a qué facultad quiere ir 
            *   2) ó el día de hoy no tiene programado donde atender  y debemos
            *     darle esta opción
            */ 
               
             /*PARA ESTO ABORDAMOS DE LA SIGUIENTE MANERA */  
           if(h::user()->isMultiFacultad()){ /*Si es invitado es multifacultad de hecho*/
                return $this->render('invitado',['facultades'=>$facultadesAutorizadas]);
           }else{ /*Em otro caso sacar su unica facultad*/
               $codfac=h::user()->firstFacultad;
           }
          
         }
         return $codfac;
     }
  }
  
  
   public function actionPanelSecretaria(){
      $formato= \common\helpers\timeHelper::formatMysqlDate();
      $fechadefaultHoy=Aluriesgo::CarbonNow()->format($formato);
     $fecha=h::request()->get('fecha',$fechadefaultHoy );     
     $verifFecha=\common\helpers\timeHelper::IsFormatMysqlDate($fecha);
     $fecha=($verifFecha)?$fecha:$fechadefaultHoy;
     $nombresesion='correos_'.h::userId();
     
     // $codtra=h::user()->profile->codtra;
     
         $codfac=h::user()->getFirstFacultad(); 
     
       $provider = \frontend\modules\sta\models\StaVwCitasSearch::searchByDay($codfac,$fecha);
       $sesion=h::session();
      if(!(date($formato)==$fecha)){
        $correos=[];
        $models=$provider->getModels();
        foreach($models as $model){
          $correos[$model->codalu]=[
              'correo'=>$model->correo,
              'nombres'=>$model->ap.'-'.$model->am.'-'.$model->nombres,
              'numerocita'=>$model->numerocita,
              'fechaprog'=>$model->fechaprog,
              ];
         }
         $sesion[$nombresesion]=$correos; 
      } else{
          $sesion->remove($nombresesion);
      }
      
      $tallerPsico=New Tallerpsico();
     $tallerPsico->codfac=$codfac;
     $citasPendientes=$tallerPsico->
            putColorThisCodalu(
                   $tallerPsico->eventosPendientes(),'',null);
    
     return $this->render('psicologo',[
         'fecha'=>$fecha,
         'provider' =>$provider,
         'codfac'=>$codfac,
          'citasPendientes'=> $citasPendientes,
          'codperiodo'=>  \frontend\modules\sta\staModule::getCurrentPeriod(),
                  
     ]);
      
  } 
  public function actionAcurricular(){
     
       $wsdl = "https://serviciosfim.uni.edu.pe/nuevo_webservices/webservice-server.php";
        $id = "20114052D";
            $client = new \SoapClient($wsdl);
            $client->setCredentials("NUEVO_USER","A%2020_NUEVO_USER");
            $err = $client->getError();
            if ($err) {
                echo '<h2>error</h2>'.$err;
                exit();
            }
            try {
                //utilize la variable $action  para solicitar el pdf "avance curricular" o "ficha academica"
                $action = "avance_curricular";
                // $action = "ficha_academica";
               
                $pdf = $action."_".$id.".pdf";
                   $result = $client->call($action,array('id'=>$id));
                    $err = $client->getError();
                    $byteArr = json_decode($result);
                    $fp = fopen($pdf, 'wb');
                    while (!empty($byteArr)) {
                        $byte = array_shift($byteArr);
                        fwrite($fp, pack('c',$byte));
                    }
                    fclose($fp);
                    header('Content-type: application/pdf');
                    readfile($pdf);
            }catch (Exception $e) {
                echo 'Error: ',  $e->getMessage(), "\n";
            }
           
  }
  
  
public function actionExportaciones(){
    return $this->render('exportaciones');
}  


public function actionMensajeMasivo(){
    $lista=h::request()->get('lista',null);
  if(!is_null($lista)){
     // $lista=h::request()->get('lista');
     $lista=\yii\helpers\Json::decode($lista);
  
  }else{
      $idtaller=h::request()->get('idtaller',null);
      if(is_null($idtaller)){
         if(h::user()->can('r_god')){
             h::session()->setFlash('warning',yii::t('sta.labels','Esta Acción enviará un correo a todos los alumnos de la tutoría '));
                    $lista=\frontend\modules\sta\models\bases\modelMensajeCorreo::allCorreos();
                    }else{
                    return $this->redirect(Yii::$app->getHomeUrl());
                    } 
          }else{ /*Quiere decir ques para una tutoria completa */
               $taller=\frontend\modules\sta\models\Talleres::findOne((integer)$idtaller);
               if(!is_null($taller)){
                 $lista=$taller->correosPrograma();  
                 }else{
                      h::session()->setFlash('error',yii::t('sta.labels','No se encontró la lista de correos '));
                      return $this->redirect(Yii::$app->getHomeUrl());
                 }
          }
        
        }
    
     // $lista= \frontend\modules\sta\helpers\comboHelper::geCboCorreosProgramas();
   $model= new \frontend\modules\sta\models\bases\modelMensajeCorreo([
       'name'=>'TUTORIA PISCOLOGICA UNI',
       // 'email'=>,
    ]);
   ;
    if (h::request()->isAjax && $model->load(h::request()->post())) {  
               $model->body=trim($model->body);
                h::response()->format =\yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
        }
        
   
   $correosReply=\frontend\modules\sta\helpers\comboHelper::geCboCorreosProgramas();
    $model->replyTo=array_keys($correosReply)[0];
   //$lista=['hipogea@hotmail.com','caballitosietecolores@gmail.com'];
    if ($model->load(Yii::$app->request->post()) ) {
          $model->body=trim($model->body);
               if($model->validate()){
                      $model->sendEmail($lista);
                       h::session()->setFlash('success',yii::t('sta.labels','Se ha enviado el correo a los destinatarios '.implode($lista,'  -  ')));
                      return $this->redirect(Yii::$app->getHomeUrl());
                  }else{
            //print_r($model->getErrors());die();
                }
        }else{
            
        }
           // yii::error('paso por Load y save()');
       
       
        return $this->render('_correo_facultades', [
            'model' => $model,
            'lista'=>$lista,
            'correosReply'=>$correosReply
           // 'eventos'=>$eventos,
        ]);
}


private function mailCitas($correos){
    $replyTo=null;
   if(h::userId()==51){
     $mensajes=[];
    if(count($correos)>0){
        $codalu=array_keys($correos)[0];
        $codperiodo= \frontend\modules\sta\staModule::getCurrentPeriod();
          $idtalleres=Talleresdet::find()->select(['talleres_id'])->andWhere(['codalu'=>$codalu])->column();
          $arreglo=\frontend\modules\sta\models\Talleres::find()->select(['codperiodo','correo'])->andWhere(['id'=>$idtalleres])->asArray()->all();
          foreach($arreglo AS $taller){
             if($codperiodo==$taller['codperiodo']){
              $replyTo= $taller['correo'];
             }
          }
          
    }
    $replyTo=empty($replyTo)?null:$replyTo;
    
   }
    $codalu=array_keys($correos)[0];
    $idtalleres=Talleresdet::find()->select(['talleres_id'])->andWhere(['codalu'=>$codalu])->column();
      $codperiodo= \frontend\modules\sta\staModule::getCurrentPeriod();
        
    
     //yii::error($correos);
          foreach($correos as $codigo=>$valores){
             // yii::error('el codigoe s');
              //yii::error($codigo);
           $mailer = new \common\components\Mailer();
        $message =new  \yii\swiftmailer\Message();
            $message->setSubject('Tienes una cita programada')
            ->setFrom([h::gsetting('mail', 'userservermail')=>'Oficina Tutoría Psicológica UNI'])
           ->setTo($valores['correo'])
               //->setTo('hipogea@hotmail.com')       
                   // ->setReplyTo('hipogea@hotmail.com')
                    ->SetHtmlBody("Buenas Tardes  ".$valores['nombres']."<br>"
                    . "La presente es para notificarle que tiene "
                    . "una cita  programada VIRTUAL ".$valores['numerocita'].". <br> para el día ".$valores['fechaprog']."<br>"
                    . " Agradeceremos nos otorgues parte de tu valioso tiempo para llevar a cabo la misma ");
            
            if(!is_null($replyTo)) {
                $message->setReplyTo($replyTo);
            } 
            
                    try {
                        $result = $mailer->send($message);
                        $mensajes['success']='Se envió el correo, invitando a la convocatoria ';
                        } catch (\Swift_TransportException $Ste) {      
                            $mensajes['error']=$Ste->getMessage();
                        } 
            
                        
                        
                unset($mailer);unset($message);
                $tallerdet= Talleresdet::findOne(['codalu'=>$codigo,'talleres_id'=>$idtalleres]); 
                 if(!is_null($tallerdet))
                $tallerdet->logConvocatoriaMail();
             }
         return $mensajes;
    }
public function actionNotifica(){
    if(h::request()->isAjax){
         $formato= \common\helpers\timeHelper::formatMysqlDate();
       // $fechadefaultHoy=Aluriesgo::CarbonNow()->format($formato);
         $fecha=h::request()->get('fecha');
         if(is_null($fecha)){
             $fecha=Aluriesgo::CarbonNow()->format($formato);
         }else{
           $fecha= \yii\helpers\Json::decode($fecha);   
         }
      
      
        
      
    
     
     $verifFecha=\common\helpers\timeHelper::IsFormatMysqlDate($fecha);
     
    $fecha=($verifFecha)?$fecha:$fechadefaultHoy;
    //var_dump($fecha);die();
    h::response()->format = \yii\web\Response::FORMAT_JSON;
    //var_dump($fecha,date($formato),!(date($formato)==$fecha),$fecha > date($formato));die();
        if($fecha > date($formato)){
          
           
           //var_dump('$verifFecha');die();
        $sesion=h::session();
       if($sesion->has('correos_'.h::userId())){
          $correos=$sesion['correos_'.h::userId()];
          
          if(count($correos)>0){
          $this->mailCitas($correos);
           return ['success'=>yii::t('sta.errors','Se enviaron los correos')]; 
          }else{
            return ['error'=>yii::t('sta.errors','No hay ningún correo en la lista')];  
          }
       }else{
           return ['error'=>yii::t('sta.errors','No existe la sesión')];   
       } 
        }else{
           return ['error'=>yii::t('sta.errors','Los correos se hacen con anticipación no para hoy')];  
        }
    
    
         
       
    }
}


public function actionAvanceGeneral(){
    /*
     * Esto no debe ser manual debe leerse de tablas,
     * mejora resto
     */
    $etapas=[
       1=>'EVALUACIÓN DE ENTRADA',
       2=>'ENTREVISTA INICIAL',
       3=>'TUTORIAS INDIVIDUALES',
       4=>'TALLERES',
       5=>'EVALUACION FINAL'
    ];
    $iconos=[
       1=>'fa fa-stethoscope',
       2=>'fa fa-comments',
       3=>'fa fa-user-clock',
       4=>'fa fa-users-cog',
       5=>'fa fa-stethoscope'  
    ];
    $codperiodo=h::request()->get('codperiodo', \frontend\modules\sta\staModule::getCurrentPeriod());
   
    $query=\frontend\modules\sta\models\StaResumenasistencias::
     find()->where(['codperiodo'=>$codperiodo]);
    
    
    $examenes=\frontend\modules\sta\models\StaResumenasistencias::
     find()->where(['codperiodo'=>$codperiodo])->select(['count(c_1) as nexam'])->
            andWhere(['>','c_1',substr($codperiodo,0,4).'-01-01'])
            ->groupBy('codfac')->asArray()->all();
    
    //var_dump($query->select(['count(c_1) as nexam'])->
    //andWhere(['>','c_1',substr($codperiodo,0,4).'-01-01'])
    //->groupBy('codfac')->createCommand()->getRawSql());die();
    $informes=\frontend\modules\sta\models\StaResumenasistencias::
     find()->where(['codperiodo'=>$codperiodo])->select(['count(n_informe) as ninforme'])->
            andWhere(['>=','n_informe',3])->groupBy('codfac')->
            asArray()->all();
   
    
    
    
    $totales=\frontend\modules\sta\models\StaResumenasistencias::
     find()->where(['codperiodo'=>$codperiodo])->select(['count(*) as ntotal','codfac'])->
    groupBy('codfac')->asArray()->all();
    
    
   
 $userLogin=(new \yii\db\Query())->select("count(*) as nlogin , b.username") ->  
  from("{{%useraudit}} a")->innerJoin('{{%user}} b','a.user_id=b.id')->
       where(['action'=>'login'])->groupBy('user_id')->orderBy('count(*) desc')->all();
 
 
  $userActivity=(new \yii\db\Query())->select("count(*) as nactividad, username")->
    from("{{%activerecordlog}} a")->groupBy('username')->orderBy('count(*) desc')->all();

   
    $indiAvances=[
        'facultades'=>array_column($totales,'codfac'),
        'ntotales'=>array_map('intval',array_column($totales,'ntotal')),
         'informes'=>array_map('intval',array_column($informes,'ninforme')),
        'examenes'=>array_map('intval',array_column($examenes,'nexam'))
        ];
    //print_r($indiAvances['examenes']);die();
    
  return   $this->render('avance_general',
          [
              'indiAvances'=>$indiAvances,
              'userLogin'=>$userLogin,
              'userActivity'=>$userActivity,
              'etapas'=>$etapas,
              'iconos'=>$iconos
          ]);
}
  
public function actionTiposCorreos(){
   return $this->render('tipos_correo');
}


public function actionZoom(){
   $this->layout="zoom";
  return  $this->render('zoom');
}

public function actionBuscaAlumno(){
    if(h::request()->isAjax){
         $query = \frontend\modules\sta\models\VwAluriesgo::find();
          $valores=h::request()->post('VwAluriesgoSearch');
        $query->andFilterWhere(['like', 'ap', $valores['ap']])
            ->andFilterWhere(['like', 'am',$valores['am']])
            ->andFilterWhere(['like', 'nombres', $valores['nombres']])
           ->andFilterWhere(['like', 'codalu', $valores['codalu']])
           ->andFilterWhere(['like', 'codfac', $valores['codfac']])
            ->andFilterWhere(['like', 'codperiodo', $valores['codperiodo']]);
       $model=$query->one();
      IF(is_null($model)){
          echo "No se encontraron registros para estos datos";
      }else{
          echo $this->
         renderpartial('/alumnos/auxiliares/_form_view_alu_basico',['model'=>$model]);
     
        }
     }
}

public function actionPanelCoordinacion(){
    return $this->render('coordinacion');
    
}

public function actionCoordinacionPsicologos(){
   $codperiodo= \frontend\modules\sta\staModule::getCurrentPeriod();
   $idtalleres= \frontend\modules\sta\models\Talleres::find()-> 
    select(['id'])->andWhere(['codperiodo'=>$codperiodo])-> column();  
 
   
  $psicologos= Tallerpsico::find()->
    andWhere(['talleres_id'=>$idtalleres])->all();  
   return $this->render('coord_psico',['psicologos'=>$psicologos,'codperiodo'=>$codperiodo]);  
  
}

public function actionPanelCoord(){
    $codperiodo= \frontend\modules\sta\staModule::getCurrentPeriod();
    $codperiodo= \frontend\modules\sta\staModule::getCurrentPeriod();
   $idtalleres= \frontend\modules\sta\models\Talleres::find()-> 
    select(['id'])->andWhere(['codperiodo'=>$codperiodo])-> column();  
 
   
  $psicologos= Tallerpsico::find()->
    andWhere(['talleres_id'=>$idtalleres])->all();  
  return  $this->render('coord_panel',['psicologos'=> $psicologos,'codperiodo'=>$codperiodo]);
}

public function actionCantidadesEnRiesgo(){
    $this->layout="install";
    $codperiodo=h::request()->
    get('codperiodo',\frontend\modules\sta\staModule::getCurrentPeriod());
    
   $cantidades= \frontend\modules\sta\components\Indicadores::cantidades($codperiodo);
  return  $this->render('modal_cantidades',['codperiodo'=>$codperiodo,'cantidades'=>$cantidades]);
}

public function actionAtenciones(){
    $this->layout="install";
    $codperiodo=h::request()->
    get('codperiodo',\frontend\modules\sta\staModule::getCurrentPeriod());
    
   $cantidades= \frontend\modules\sta\components\Indicadores::cantidadAtenciones($codperiodo);
   return  $this->render('modal_atenciones',['codperiodo'=>$codperiodo,     
       'cantidades'=> $cantidades,
          ]);
}


public function actionExamenes(){
    $this->layout="install";
    $codperiodo=h::request()->
    get('codperiodo',\frontend\modules\sta\staModule::getCurrentPeriod());
    
   $cantidades= \frontend\modules\sta\components\Indicadores::cantidades($codperiodo);
   $cantidadesNoEvaluadas=\frontend\modules\sta\components\Indicadores::cantidadesNoEvaluadas($codperiodo);
   $facultades=array_column($cantidades,'codfac');
   $nevaluados=array_column($cantidades,'nalumnos');
   $nNoEvaluados=array_column($cantidadesNoEvaluadas,'nalumnos');
  return  $this->render('modal_evaluaciones',['codperiodo'=>$codperiodo,
      'facultades'=>$facultades,
      'nevaluados'=>$nevaluados,
       'nNoEvaluados'=> $nNoEvaluados,
          ]);
}

public function actionSeleccionarPsicologo(){
    $codfac=h::request()->get('codfac');
    $codperiodo=h::request()->get('codperiodo');
    $trabajadores= \frontend\modules\sta\models\Rangos::find()
       ->select(['codtra'])->andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo])->column();
    /*var_dump(\frontend\modules\sta\models\Rangos::find()
       ->select(['codtra'])->andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo])->createCommand()->getRawSql());die();
   */$tra=new \common\models\masters\TrabajadoresSearch();
   //var_dump( $trabajadores);die();
       $dataProvider=$tra->searchByCodes($trabajadores);
       
    return $this->render('seleccionar_psico',['dataProvider'=>$dataProvider]);
    
}

public function actionSesionSelectPsicologo(){
    
    $psico=h::request()->get('codtra');
    //var_dump($psico);die();
    $model= \common\models\masters\Trabajadores::findOne(['codigotra'=>$psico]);
    if(!is_null($model)){
       $sesion=h::session();
       $sesion['psico_por_dia']=$psico;
       
      return   $this->redirect(['panel-inicio']);
    }else{
        echo "mal valor"; die();
    }
    
}

}
