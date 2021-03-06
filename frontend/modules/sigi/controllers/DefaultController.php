<?php
namespace frontend\modules\sigi\controllers;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii;
use frontend\modules\sigi\Module;
use common\helpers\h;
USE frontend\modules\sigi\models\SigiUserEdificios;
use mdm\admin\models\searchs\User as UserSearch;
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    
    public function actionCrearBanco()
    {
        $model = new SigiBancos();
        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('crearBanco', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Edificios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEditarBanco($id)
    {
        $model = $this->findModel($id);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('editarBanco', [
            'model' => $model,
        ]);
    }

    
     public function actions()
    {
        return [
            'manage-settings' => [
                'class' => \yii2mod\settings\actions\SettingsAction::class,
                // also you can use events as follows:
                'on beforeSave' => function ($event) {
                    // your custom code
                },
                'on afterSave' => function ($event) {
                    // your custom code
                },
                'modelClass' => \frontend\modules\sigi\models\ConfigurationForm::class,
            ],
        ];
    }
  
     public function actionProfile(){
         SigiUserEdificios::refreshTableByUser();
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
        
         $newIdentity=h::user()->identity->findOne($iduser);
      if(is_null($newIdentity))
          throw new BadRequestHttpException(yii::t('base.errors','Usuario no encontrado con ese id '.$iduser));  
           //echo $newIdentity->id;die();
     // h::user()->switchIdentity($newIdentity);
         SigiUserEdificios::refreshTableByUser($iduser);
        $profile =$newIdentity->getProfile($iduser);
        $profile->setScenario($profile::SCENARIO_INTERLOCUTOR);
        if(h::request()->isPost){
            $arrpost=h::request()->post();
             
            $profile->tipo=$arrpost[$profile->getShortNameClass()]['tipo'];
           $newIdentity->status=$arrpost[$newIdentity->getShortNameClass()]['status'];
          //var_dump($arrpost, $newIdentity->status);die();
           if ($profile->save() &&  $newIdentity->save()) {
            $this->updateUserFacultades($arrpost[SigiUserEdificios::getShortNameClass()]);
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
            'useredificios'=> SigiUserEdificios::providerEdificiosAll($iduser)->getModels(),
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
    
    
    
    /*
     * Actualizacion de los valores del aacultades uausuarios 
     */
    private function updateUserFacultades($arrpostUserFac){
        $ar=array_combine(ArrayHelper::getColumn($arrpostUserFac,'id'),
                ArrayHelper::getColumn($arrpostUserFac,'activa'));
        foreach($ar as $clave=>$valor){
           \Yii::$app->db->createCommand()->
             update(SigiUserEdificios::tableName(),
             ['activa'=>$valor],['id'=>$clave])->execute();
        }
        
    }
    
      /*
     * Visualiza otros perfiles 
     */
   
    
   public function actionPanelResidente(){
       $user= h::user();
       $profileTipo=$user->profile->tipo;
       if(Module::PROFILE_RESIDENTE==$profileTipo){
           $userName=$user->identity->username;
           if(!(strpos($userName,'_')===false)){
              $numeroDepa=substr($userName,0,strpos($userName,'_'));
              $edificioId=substr($userName,strpos($userName,'_')+1);
             // var_dump($edificioId,$numeroDepa);die();
              $unidad= \frontend\modules\sigi\models\SigiUnidades::find()
                      ->andWhere(['edificio_id'=>$edificioId,'numero'=>$numeroDepa])
                      ->one();
             $unidadId=$unidad->id;
                    $medidor=$unidad->firstMedidor(\frontend\modules\sigi\models\SigiSuministros::COD_TYPE_SUMINISTRO_DEFAULT);
                   return  $this->render('panel_residente',['unidadId'=>$unidadId,'medidor'=>$medidor]);
              }else{
               
           }
           
       }else{
           
       }
   } 
    
    
}
