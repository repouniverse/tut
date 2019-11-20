<?php

namespace frontend\controllers\masters;

use Yii;
use common\models\masters\Bancos;
use common\models\masters\BancosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\controllers\base\baseController;
/**
 * SociedadesController implements the CRUD actions for Sociedades model.
 */
class BasicoController extends baseController
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
     * Lists all Sociedades models.
     * @return mixed
     */
    public function actionBancos()
    {
      
 // VAR_DUMP(yii::getalias('@app/views')); die();
 //VAR_DUMP(Yii::$app->user->isGuest);DIE();
                /*VAR_DUMP(Yii::$app->user->identity->username);

        VAR_DUMP(Yii::$app->user->isGuest);
        (Yii::$app->user->Id);die();*/
        $searchModel = new BancosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('listaBancos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sociedades model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionVerBanco($id)
    {
        return $this->render('viewBanco', [
            'model' => $this->loadBanco($id),
        ]);
    }

    /**
     * Creates a new Sociedades model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrearBanco()
    {
        $model = new Bancos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['ver-banco', 'id' => $model->id]);
        }

        return $this->render('createBanco', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Sociedades model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEditarBanco($id)
    {
        $model = $this->loadBanco($id);
        
        
         
        if ($model->load(Yii::$app->request->post())) {
           if( $model->save()){
               
                return $this->redirect(['ver-banco', 'id' => $model->id]);
           
           }else{
               $tran->rollBack();
           }
        }

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->socio]);
        }*/

        return $this->render('updateBanco', [
            'model' => $model,
        ]);
    }

    

    /**
     * Finds the Sociedades model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Sociedades the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function loadBanco($id)
    {
        if (($model = Bancos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('control.errors', 'The requested page does not exist.'));
    }
}
