<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
 use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sta\models\StaEventosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<div class="sta-eventos-index">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">

  
    <?php 
    $identidad= uniqid();
    Pjax::begin(['id'=>$identidad]); ?>
    <?php $modelo=$model; // echo $this->render('_search', ['model' => $searchModel]); ?>
   
    <?= GridView::widget([
        'dataProvider' => (new \frontend\modules\sta\models\CitasSearch())->searchByEvento($model->talleresdet_id,$model->evento->tipo),
                  
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{asistencia}',
               'buttons'=>[
                'asistencia' => function ($url,$model)use($modelo) {
                        if($model->asistio) {
                            $url = Url::toRoute([$this->context->id.'/revert-asistencia','id'=>$modelo->id,'cita_id'=>$model->id]);
                              return Html::a('<span class="btn btn-sm btn-info fa fa-undo"></span>', 'javascript:void();', ['id'=>$model->id,'title'=>$url,'family'=>'holitas']);
                      
                        }else{
                            return '';
                        }
                        } ,
                    
                    ]
                    
                ],
            'numero',
            ['attribute'=>'fechaprog',
                'value'=>function($model){
                      return substr($model->fechaprog,0,16);      
                }
                ],
            
        ],
    ]); ?>
    <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grupo-pjax',
            'family'=>'holitas',
          'type'=>'POST',
           'evento'=>'click',
       'posicion'=>\yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
    
    <?php Pjax::end(); ?>

  </div>

    </div>
       