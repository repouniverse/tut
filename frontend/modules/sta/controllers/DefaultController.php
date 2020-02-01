<?php

namespace frontend\modules\sta\controllers;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii;
use common\helpers\h;
use common\models\User;
use frontend\modules\sta\models\UserFacultades;
use frontend\modules\sta\models\Facultades;
use frontend\modules\sta\models\Aluriesgo;
use frontend\modules\sta\models\Tallerpsico;
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
        //$registro= UserFacultades::find()->where(['id'=>27])->one();
        
        return $this->render('index');
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
    
    public function actionResumenFacultad($codfac){
        $model=$this->loadFacultad($codfac);
        $provAlumnos= Aluriesgo::worstStudentsByFacProvider($codfac);
        $provCursos= Aluriesgo::worstCursosByFacProvider($codfac);
        $nalumnos=Aluriesgo::studentsInRiskByFacQuery($codfac)->count();
       $taller=\frontend\modules\sta\models\Talleres::findOne(['codfac'=>$codfac,'codperiodo'=> \frontend\modules\sta\staModule::getCurrentPeriod()]);
        
//var_dump($taller->kp_contactados());die();
        return $this->render('resumenFacultad',[
                   'model'=>$model,
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
       
     return $this->render('secretaria',[
         'codfac'=> $codfac,
          'nalumnos'=> $nalumnos,
        'kpiContacto'=>(!is_null($taller))?$taller->kp_contactados():\frontend\modules\sta\models\Talleres::kp_contactadosEmpty(),
                    
     ]);
  }  
  
  public function actionPanelPsicologo(){
      
      $codfac=h::user()->getFirstFacultad();
      $codtra=h::user()->profile->codtra;
      $provider = \frontend\modules\sta\models\StaVwCitasSearch::searchByPsicoToday($codtra);
      $tallerPsico=New Tallerpsico();
      $tallerPsico->codtra=$codtra;
      $eventosPendientes=$tallerPsico->eventosPendientes();
      
     return $this->render('psicologo',[
         'provider' =>$provider,
          'citasPendientes'=> $eventosPendientes,
          'codperiodo'=>  \frontend\modules\sta\staModule::getCurrentPeriod(),
                  
     ]);
  }  
}
