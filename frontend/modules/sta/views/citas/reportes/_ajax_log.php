<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\audit\AccessDocuLog;
use common\behaviors\AccessDownloadBehavior as MyBeha;
 //use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sta\models\StaEventosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<div class="sta-eventos-index">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
    <p class="text-green"><span class="fa fa-dolly-flatbed"></span>  Distribución</p>
  
    <?php 
    $identidad= uniqid();
    Pjax::begin(['id'=>$identidad]); ?>
      <?= GridView::widget([
        'dataProvider' =>new \yii\data\ActiveDataProvider([
            'query'=>AccessDocuLog::find()->andWhere(['id_model'=>$id,'model_class'=>$nombreclase]),
            
            ]),
                  
         'summary' => '',
         'tableOptions'=>[
             'class'=>'table no-margin',
             'bootstrap'=>false,],
       // 'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'canal',
                 'format'=>'raw',
                'value'=>function($model){
                      return '<i style="font-size:18px; color:#444"><span class="'.MyBeha::iconCanal($model->canal).'" ></span></i>';  
                }
             ],
            ['attribute'=>'user_id',
                'format'=>'raw',
                'value'=>function($model){
                      return '<i style="font-size:18px; color:#444"><span class="fa fa-user" ></span></i>    '.h::getNameUserById($model->user_id);      
                }
                ],
            'fecha_hora',
        ],
    ]); ?>
    <?php 
   /*echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grupo-pjax',
            'family'=>'holitas',
          'type'=>'POST',
           'evento'=>'click',
       'posicion'=>\yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); */
   ?>
    
    <?php Pjax::end(); ?>

  </div>

    </div>
       