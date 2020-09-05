<?php
//use frontend\modules\sta\models\StaVwCitas;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\sta\models\StaEventos;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
<h4><?=yii::t('sta.labels','Eventos')?></h4>


    
    
   
     <div class="box-body">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?=Html::a('<span class="fa fa-calendar-day" ></span>'.'  '.yii::t('sta.labels','Crear Evento'),Url::to(['/sta/eventos/create','id'=>$model->id]),['target'=>'_blank','class'=>"btn btn-success"])?>
          <?php $url=Url::toRoute(['/sta/default/mensaje-masivo','idtaller'=>$model->id]);  ?>      
              <?=Html::a('<span class="fa fa-envelope" ></span>'.'  '.yii::t('sta.labels','Enviar correo masivo'),$url,['target'=>'_blank','data-pjax'=>'0','class'=>"btn btn-success"])?>
          
      </div> 
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
       ..  
      </div> 
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
         
    <?php Pjax::begin(['id'=>'grilla-convocatorias']); ?>
    <?php 
$modelPadre=$model;
// echo $this->render('_search', ['model' => $searchModel]); ?>
        
    
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' =>new \yii\data\ActiveDataProvider([
    'query' => StaEventos::find()->
                andWhere(['talleres_id'=>$model->id]),
                            'pagination' => [
                                'pageSize' => 20,
                ],
                                                        ]),
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
          'showPageSummary' => true,
        'columns' => [
           [ 'attribute'=>'numero',
               'format'=>'raw',
               'value'=>function($model){
                    return Html::a($model->numero,Url::to(['/sta/eventos/update','id'=>$model->id]),['data-pjax'=>'0','target'=>'_blank']);
                        }
               ],
              [ 'attribute'=>'tipo',
               'format'=>'raw',
                  'group'=>true,
               'value'=>function($model) use($modelPadre) {
                  
                    return Html::a($model->flujo->proceso,Url::to(['/sta/programas/balance-eventos','id'=>$modelPadre->id,'tipo'=>$model->tipo]),['data-pjax'=>'0']);
                        }
                        ],         
                       
           'fechaprog',
            'descripcion', 
          ['attribute'=>'asist',
             //'format' => ['decimal', 0],
              'format'=>'raw',
                'pageSummary' => true,
              'value'=>function($model){
                 return $model->nAsistencias();
               // return '<i style="font-size:16px;">'.$model->nAsistencias().'</i>';
              }
              ],
          /*['attribute'=>'faltas',
              'format'=>'raw',
               'pageSummary' => true,
              'value'=>function($model){
               return ($model->nAlumnos()-$model->nAsistencias());   
               // return '<i style="font-size:16px;">'.($model->nAlumnos()-$model->nAsistencias()).'</i>';
              }
              ],*/
          ['attribute'=>'total',
              'format'=>'raw',
               'pageSummary' => true,
              'value'=>function($model){
                  return $model->nAlumnos();
               // return '<i style="font-size:16px;">'.$model->nAlumnos().'</i>';
              }
              ],
          ['attribute'=>'status',
              'format'=>'raw',
              'value'=>function($model){
                   if($model->isClosed()){
                       $icon='lock';$color='red';
                   }else{
                        $icon='lock-open';$color='green';
                   }
                return '<i style="color:'.$color.';"><span class="fa fa-'.$icon.'"></span></i>';
              }
              ]
        ],
    ]);
             
         
         
             ?><?php Pjax::end(); ?>
</div>
    </div>
   
</div>
  
       

