<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
USE common\helpers\h;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use mdm\admin\components\UserStatus;
use mdm\admin\models\searchs\User as UserSearch;
use yii\helpers\Url;
/**
 * Site controller
 */
class SiteController extends \frontend\controllers\base\baseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()    {       
        // $this->layout="install";       
     // echo "Estamos trabajando ..regresamos pronto...";die();
        $urlBackend=str_replace('frontend','backend',yii::$app->urlManager->baseUrl);
        //if(yii::$app->user->isGuest){            
            if(\backend\components\Installer::readEnv('APP_INSTALLED')=='false'){
                          
                $this->redirect($urlBackend);             
            }else{
                
                if(yii::$app->user->isGuest){
                   // echo "holsa"; die();
                  return  $this->redirect(['site/login']);
                    
                }else{
                     //$this->redirect(Url::toRoute([Yii::$app->user->resolveUrlAfterLogin()]));
                      $profile=h::user()->profile;
                    $url= $profile->url;
                       $tipo=$profile->tipo;
           //yii::error(' tipo '.$tipo);
           // yii::error(' url '.$url);
           //yii::error(' tipo '.$tipo);
            if(empty($url)){
              //yii::error(' url empty sacando de settings ');   
              $url=h::gsetting('general','url.profile.'.$tipo);   
             // yii::error(' url  '.$url); 
            }
              //yii::error('LA URL ES  '.$url);                   
           if(!empty($url))
             $this->redirect(Url::to([$url]));
                      
                     //return h::user()->resolveUrlAfterLogin();
                     return $this->render('index');
                }
               
              // $this->redirect(\Yii::$app->urlManager->home);
            }
       // }else{     
          
         
           
        //}
       
        
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
     
        $this->layout="install";
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
 //Yii::info(" paracopmrobar   ", __METHOD__);  
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //$this->redirect(['/sta/programas']);
            //echo Url::to(Yii::$app->user->resolveUrlAfterLogin());die();
            //
            //echo Yii::$app->user->resolveUrlAfterLogin(); die();
            $this->redirect(Url::toRoute([Yii::$app->user->resolveUrlAfterLogin()]));
                 //$this->redirect(['index']); 
            //var_dump(Yii::$app->request->referrer);die();
              //return $this->redirect(is_null(Url::previous('intentona'))?Yii::$app->homeUrl:Url::previous('intentona'));
	// $this->redirect(['sta/default/view-profile','iduser'=>h::userId()]);           // return $this->goBack();
        } else {
          
            $model->password = '';
   
            return $this->render('loginSite', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
       $this->layout="install";
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                /*Agregar el rol basico*/
                
                
                
                
               if($user->status== UserStatus::INACTIVE){
                  return $this->render('waitsignup', [
                    'model' => $model,
                     ]);
                   
               }else{
                   if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                         
               }
                
                
            }
        }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

   

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout="install";
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', yii::t('base.actions','Nueva contrasena grabada.'));

            return $this->goHome();
        }
       
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    public function actionProfile(){
        
       // echo \common\helpers\FileHelper::getUrlImageUserGuest();die();
     /* if(h::app()->hasModule('sta')){
          $this->redirect(\yii\helpers\Url::toRoute('/sta/default/profile'));
      }*/
        $model =Yii::$app->user->getProfile() ;
        
        $identidad=Yii::$app->user->identity;
        $identidad->setScenario($identidad::SCENARIO_MAIL);
       // var_dump($model);die();
        if ($identidad->load(Yii::$app->request->post()) && $identidad->save() &&                
                $model->load(Yii::$app->request->post()) && $model->save()) {
           // var_dump($model->getErrors()   );die();
            yii::$app->session->setFlash('success','grabo');
            return $this->redirect(['profile', 'id' => $model->user_id]);
        }else{
           // var_dump($model->getErrors()   );die();
        }

        return $this->render('profile', [
            'identidad'=>$identidad,
            'model' => $model,
        ]);
    }
    
    /*
     * Visualiza otros perfiles 
     */
     public function actionViewProfile($iduser){
         $newIdentity=h::user()->identity->findOne($iduser);
      if(is_null($newIdentity))
          throw new BadRequestHttpException(yii::t('base.errors','User not found with id '.$iduser));  
           //echo $newIdentity->id;die();
     // h::user()->switchIdentity($newIdentity);
        $profile =$newIdentity->getProfile($iduser);
        //echo $model->id;die();
        return $this->render('profileother', [
            'profile' => $profile,
            'model'=>$newIdentity,
        ]);
    }
    
     public function actionAddfavorite(){
         $this->layout="install";
        $url=Yii::$app->request->referrer;  
        
        if(!is_null($url)){
            $url=str_replace(\yii\helpers\Url::home(true),'',$url);
           
            $model= new \common\models\Userfavoritos();
            $model->setAttributes([
                            'url'=>$url,
                             'user_id'=>h::userId(),
                                ]);        
          if ($model->load(Yii::$app->request->post()) && $model->save()) {           
           return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
                }        
        return $this->render('favorites', [
            'model' => $model,
        ]);
        }else{
            return;
        }
         
    }
    
    
    public function actionClearCache(){
       
       $datos=[];
       if(h::request()->isAjax){           
              h::settings()->invalidateCache();
              //\console\components\Command::execute('cache/flush-all', ['interactive' => false]);
              //\console\components\Command::execute('cache/flush-schema', ['interactive' => false]);
           $datos['success']=yii::t('base.actions','
Datos de caché de configuración se han actualizado');
           
           h::response()->format = \yii\web\Response::FORMAT_JSON;
           return $datos;
        }
    }
    
    
    public function actionRequestPasswordReset()
    {
        $this->layout="install";
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            try{
                set_time_limit(300); // 5 minutes   
                $model->sendEmail();
                Yii::$app->getSession()->setFlash('success',yii::t('base.actions','Revisa tu correo para ver las instrucciones.'));
                return $this->goHome();
            } catch (\Swift_TransportException $Ste) { 
                //echo "intenado"; die();
                Yii::$app->getSession()->setFlash('error',yii::t('base.errors', 'Sorry, we are unable to reset password for email provided.'.$Ste->getMessage()));
           }
            
           
        }

        return $this->render('requestPasswordResetToken', [
                'model' => $model,
        ]);
    }
    
    public function actionManageUsers(){
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('users', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }
    
    /*
     * Esta funcion es simlar a sign-UP
     * solo que la usa el daminsitrador de
     * de la pagina o un usuario con toles para
     * manejar RBAC
     */
       public function actionCreateUser()
    {
      // $this->layout="install";
        $model = new SignupForm();
        $model->setScenario('createx');
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {   
                 yii::$app->session->
               setFlash('success',
            yii::t('base.actions','The user has been created'));
		
                  $this->redirect('manage-users');
            }
        }
        

        return $this->render('createuser', [
            'model' => $model,
        ]);
    }
public function actionRutas(){
    $ar=[1,2,3,4,5,6];
    array_map('strval', $ar);
    var_dump(array_map('strval', $ar));die();
    
    $valor= new \frontend\modules\sta\models\Citas;
    echo $valor::SwichtFormatDate(date(\common\helpers\timeHelper::formatMysqlDateTime()),'datetime',true);
    die();
    $valor= \frontend\modules\sta\models\StaDocuAlu::dataGraph();
    $options=\yii\helpers\Json::decode($valor['options']);
    $ejex=$options['xAxis'][0]['categories'];
    $ejey=$options['series'][0]['data'];
     $options['xAxis'][0]['categories']=['uno','dos','tres'];
     $options['series'][0]['data']=[1,2,3];
     
     $valor['options']=\yii\helpers\Json::encode($options);
    VAR_DUMP( $valor);DIE();
    
    
    
    
    
    $registros=\frontend\modules\sta\models\StaEventosdet::find()->all();
    foreach($registros as $registro){
       $registro->updateAll(['codcar'=>$registro->alumno->codcar], ['codalu'=>$registro->alumno->codalu]); 
    }
    die();
    
    
    
    
    
   $ruta='http://export.highcharts.com/charts/chart.0f2f32aa928249a3a4e29efd256cd78c.svg';
    echo file_get_contents($ruta);die();
   $recurso=fopen($ruta);
    
    
    echo date('Y-m-d H:i:s'); die();
    
    $alumnos=\frontend\modules\sta\models\Aluriesgo::find()->
     select(['max(nveces15) as n15','codalu','codfac'])->
     groupBy(['codalu','codfac'])->asArray()->all();
   
   foreach($alumnos as $alumno){
       \frontend\modules\sta\models\StaResumenasistencias::updateAll(
               ['nveces'=>$alumno['n15']],
               ['codalu'=>$alumno['codalu']]);
         }
    die();
    
    $cita=new \frontend\modules\sta\models\Citas();
     $cita->talleresdet_id=1352;
   // $cita->obtenerEtapaId();
   //var_dump($cita->obtenerEtapaId());
   //die();
     $filtro=$cita->CarbonNow()->subHours(24)->format(\common\helpers\timeHelper::formatMysqlDateTime());
    
   $query= $cita->find()->select(['flujo_id'])->andWhere([
         'talleresdet_id'=>$cita->talleresdet_id,
         'masivo'=>'0','asistio'=>'1'])->orWhere(['and',
          'talleresdet_id=:talleresdet_id',
         'masivo=0',['>','fechaprog',$filtro ]
         ],[':talleresdet_id'=>$cita->talleresdet_id])->andWhere(['<>','id',23]);
   var_dump($query->createCommand()->getRawSql()); die();
    
    
    
    
    
    $valores=[2553,2623,2547,2526];
    foreach($valores as $valor){
        $cita->talleresdet_id= $valor;
        echo "ID  ".$valor."   :   FLUJO ".$cita->obtenerEtapaId()."<br>";
    }
   DIE(); 
   
   echo " Url::home()  :   ".Url::home()."<br>";
   echo " Url::home('https')  :   ".Url::home('https')."<br>";
   echo " Url::base()  :   ".Url::base()."<br>";
   echo " Url::to(['controlador/accion','param2'=>'uno','param2'=>'dos'],true)  :   ".Url::to(['controlador/accion','param1'=>'uno','param2'=>'dos'],true)."<br>";
   echo " Url::base(true)  :   ".Url::base(true)."<br>";
   echo " Url::base('https')  :   ".Url::base('https')."<br>";
   echo " Url::canonical()  :   ".Url::canonical()."<br>";
   echo " Url::current()  :   ".Url::current()."<br>";
   echo " Url::previous()  :   ".Url::previous()."<br>";
   echo " UrlManager::getBaseUrl()  :   ".yii::$app->urlManager->getBaseUrl()."<br>";
   echo " UrlManager::getHostInfo()  :   ".yii::$app->urlManager->getHostInfo()."<br>";
   echo " UrlManager::getScriptUrl()  :   ".yii::$app->urlManager->getScriptUrl()."<br>";
   //yii::$app->urlManager->setHostInfo('');
   //echo " Url::base()  :   ".Url::base()."<br>";
   //echo " UrlManager::setHostInfo()   :   ".yii::$app->urlManager->setHostInfo('http://case.itekron.com/frontend/web/sta/entregas/update?id=32')."<br>";

    
   
   
    var_dump($cita->obtenerEtapaId());
   die();
    
    
    $valor=null;
    var_dump($valor.'');die();
  
   var_dump($cita->obtenerEtapaId());die();
   //echo $cita::SwichtFormatDate('21/04/2020 11:55:13',$cita::_FDATETIME,false); 
   die();
   
   $cita->talleresdet_id=2008;
   // $cita->obtenerEtapaId();
   var_dump($cita->obtenerEtapaId());
   die();
    
    $carbon=New \Carbon\Carbon();
    $carbon=$carbon->addHours(5)->addMinutes(45);
    var_dump($carbon,$carbon->parse('09:30'));die();
    
     $formato= \common\helpers\timeHelper::formatMysqlDate();
      $fechadefault=\frontend\modules\sta\models\Aluriesgo::CarbonNow()->format($formato);
     var_dump($fechadefault);
    die();
    $carbon=\Carbon\Carbon::createFromFormat('Y-m-d','2020-08-01');
    var_dump($carbon->endOfDay()->format('Y-m-d H:i:s'));
    die();
     $formatoMySql=\common\helpers\timeHelper::formatMysqlDateTime();
    $cita= \frontend\modules\sta\models\Citas::findOne(729);
    echo $cita->CarbonNow()->addMinutes(20)->format($formatoMySql);die();
    $cita= \frontend\modules\sta\models\Citas::findOne(1350);
    var_dump($cita->CarbonNow()->format($cita->formatToCarbon($cita::_FDATETIME)));die();
    
    
    $taller= \frontend\modules\sta\models\Talleresdet::findOne(2518);
    
    $taller->retiraDelPrograma(false);
    die();

    
    
    $cita= \frontend\modules\sta\models\Citas::findOne(1350);
    
    
   $registros= \frontend\modules\sta\models\Citas::find()->with([
    'examenes'
   
])->andWhere(['id'=>275])->limit(5)->asArray()->all();
    print_r($registros);die();
    
    
    
    //echo date('Y-m-d H:i:s');die();
    $cita= \frontend\modules\sta\models\Citas::findOne(729);
    $cita->fechaprog='03/04/2020 08:50:34';
    var_dump($cita->isInJourney(),$cita->getErrors()); die();
    
    $carbon=New \Carbon\Carbon();
    $carbon=$carbon->addHours(5)->addMinutes(45);
    var_dump($carbon,$carbon->parse('09:30'));die();
    //\frontend\modules\sta\staModule::notificaMailCitasProximas();
    //die();
   /* $fecha1='2020-02-26 07:00:00';  
    $fecha2='2020-04-15 00:45:13';    ECHO $fecha1."<BR>";
    ECHO $fecha2."<BR>";
    var_dump(\common\helpers\timeHelper::IsFormatMysqlDateTime($fecha1),
            \common\helpers\timeHelper::IsFormatMysqlDateTime($fecha2)
            );
    die();
    
    
    
    
    
    
    
    
    
    var_dump(h::gsetting('sta','notificacitasmail'));die();
  $registro=New \frontend\modules\sta\models\Citas();
 $fechax=date(\common\helpers\timeHelper::formatMysqlDateTime());
 echo  $registro::SwichtFormatDate($fechax,$registro::_FDATETIME, true);
  die();
 $registro->talleresdet_id=1444;
  /*$query=$registro->find()->orWhere(['and',
                'talleresdet_id='.$registro->talleresdet_id,
                'asistio=0',
                'masivo=0',
      'fechaprog >'.$registro::CarbonNow()->subHours(5)->format(\common\helpers\timeHelper::formatMysqlDateTime())                
            ]);
  echo $query->createCommand()->getRawSql();die();*/
  echo $registro->obtenerEtapaId();die();
    
    
    
 $registro= \frontend\modules\sta\models\StaResumenasistencias::findOne(6);
 $cita= \frontend\modules\sta\models\Citas::findOne(280);
 var_dump($registro->c_1);
 var_dump($cita->fechaprog);
 die();
    
    
    Yii::$app->session->setFlash('success',yii::t('sta.labels','Se ha efectuado el ingreso'));
     return $this->redirect(['sta/programas/update',
         'id'=> \frontend\modules\sta\models\Talleres::CurrentProgramaId( h::user()->getFirstFacultad())]);
    die();
    
    
    
    
    $model=new \frontend\modules\sta\models\Aluriesgo();
    $model->setAttributes([
        'codcur'=>'EE214',
        'codalu'=>'20100230B',
        'codperiodo'=>'2020I',        
    ]);
    $model->validate();
    print_r($model->getErrors());
    die();
    
    
    
    
    
    
    
    
    $mailer= Yii::$app
            ->mailer;
  $mailer->htmlLayout = 'layouts/html';
  $message=$mailer->compose();
        return
            $message/*->compose(
                [ 'html' => 'passwordResetToken-html', 
                  'img' => $message->embed(\Yii::getAlias('@frontend/web/img/logo_cabecera.png')),
                    //'html' => 'layouts/html', 
                    'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
           */->setHtmlBody($mailer->render('saludo_correo-html', [
    'img' => $message->embed(\Yii::getAlias(\Yii::getAlias('@frontend/web/img/logo_cabecera.png'))),
     'destinatario' => 'Dra Dany',   
               ], $mailer->htmlLayout))     
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' -Restablecer contraseña'])
            ->setTo('lbarrientosm@gmail.com')
            ->setSubject('Saludos desde el nuevo correo ')
            ->send();
    
    
    
    
    
    
   echo yii::getAlias('@frontend/web/img/anonimo.png');
    echo "<br>";
   echo  "<img src='".\common\helpers\FileHelper::UrlImage(yii::getAlias('@frontend/web/img/anonimo.png'),false)."' >";die();
    die();
    /*$query=\frontend\modules\sta\components\Indicadores::queryCountCategoriasResultadosBase();
    echo $query->createCommand()->getRawSql();
    die();
    
    
    
    var_dump(\common\models\Useraudit::UsersInLine());
    die();
    
    $modeli=\frontend\modules\sta\models\Rangos::findOne(48);
    var_dump($modeli->talleres);die();*/
   /* $model=New \frontend\modules\sta\models\Citas();
    $model->fechaprog='22/03/2020 13:50:00';
    $model->talleres_id=50;
    
    var_dump($model->isInJourney(),$model->getErrors());
    die();*/
    
    }
public function actionCookies(){
    $cookiesRead = Yii::$app->request->cookies;
    $cookiesSend = Yii::$app->response->cookies;
    if($cookiesRead->has('token')){
         echo "Existe la cookie token y el valor es ".$cookiesRead->get('token')->value;
    }else{
         $cookiesSend->add(new \yii\web\Cookie([
    'name' => 'token',
    'value' => 'myvalor de cookie',
             ]));
         echo "no existia la cooike toke,perio ya se agrego";
    }
    // var_dump($cookies );
  
   }

  public function actionPutUrlDefault(){
     if(h::request()->isAjax){
           h::response()->format = \yii\web\Response::FORMAT_JSON;
           $cambio= h::user()->putUrlDefault(Yii::$app->request->referrer);
          if($cambio){
              return ['success'=>yii::t('sta.labels','Se estableció la ruta sin problemas')];
          }else{
              return ['error'=>yii::t('sta.labels','Hubo un error')]; 
          }
        }  
     
  }  
   
  public function actionSetHomeUrl($id){
      if(h::request()->isAjax){
          
         h::response()->format = \yii\web\Response::FORMAT_JSON;
        $registro=  \common\models\Userfavoritos::findOne($id);
        if(is_null($registro)){
            return ['error'=>yii::t('base.errors','No se encontró el registro para este id')];
        }else{
            $registro->setHomeUrl();
            return ['success'=>yii::t('base.errors','Se cambió la página de inicio')]; 
        }
      }
  }
  
 public function  actionManual(){
     echo " En construcción"; 
 }
  
 public function  actionControlCambios(){
     echo " En construcción"; 
 }
 
 /*
  * Captura una funcion de captura datos al maletin
  * recibe un array de la siguiente forma
  * 
  *   'nombreModelo'=[ id1, id2, id3, ...] 
  */
 public function  actionInputMaletin(){
    if (\Yii::$app->request->isAjax) {

    // Sets the response format (in case you want json response)

    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


    $data = \Yii::$app->request->post();
    var_dump(count($data),$data);
  return ['success'=>'SALIO BIEN'];
   // do something with the data


}
 }
 
 public function actionRenderAjaxAdjuntos(){
    if(h::request()->isAjax){
        $this->layout="install";
     $id=h::request()->post('expandRowKey');    
        $clase=str_replace('_','\\',h::request()->get('nombreclase'));       
        $model=$clase::findOne($id);
       
   return $this->renderAjax('@frontend/views/comunes/previo', [
                        'model' => $model,
                 //'allowedExtensions' => $allowedExtensions,
                        //'vendorsForCombo' => $vendorsForCombo,
            ]);     
         
    }
 }
 
 public function actionMantenimiento(){
   $this->layout="install"; 
   return $this->render('mantenimiento');     
         
    }
 }
 

