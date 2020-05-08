<?php
use yii\helpers\Html;
use yii\helpers\Url;

//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>

<div class="label label-success"><?=$codperiodo?></div>
    <?php Pjax::begin(['id'=>'palogay']); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => [
             [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{delete}{attach}',
               'buttons' => [                    
                        'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute(['/sta/citas/elimina-cita','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', $url, []);
                            },
                       'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>false,'idModal'=>'imagemodal','modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Subir Archivo'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },          
                        
                    ]
                ],
               [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                     'detailUrl' =>Url::toRoute(['/sta/citas/ajax-detalle-cita']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],             
              [ 'attribute' => 'numero',
             'format'=>'raw',
             'value'=>function($model){
                  $options=[
                              //'class'=>'class_link_ajax'
                               'data-pjax'=>'0',
                                'target'=>'_blank'
                               ];
                    $url=\yii\helpers\Url::to(['/sta/citas/update','id'=>$model->id]);
                    return Html::a('<span style="font-size:14px; color:#ad5eb7; font-weight:700;">'.$model->numero.'</span>',$url, $options);                   
                 return '<span style="font-size:14px; color:#ad5eb7; font-weight:700;">'.$model->numero.'</span>';           
             }
             ], 
                     [  'attribute'=>'Hallazgo',
                'format'=>'raw',
                 'value' => function ($model, $key, $index, $column) {
                     return $model->hasProblems()?"<i style='color:#e42a66; font-size:18px;'><span class='fa fa-robot'></span></i>":"";
                        },
                ],
             [ 'attribute' => 'proceso',
                 'value'=>function($model){
                        //mb_strtolower($nombre,'UTF-8')
                 return mb_strtoupper($model->flujo->proceso,'UTF-8');
             } 
             ],
            
            [ 'attribute' => 'repr',
             'format'=>'raw',
             'value'=>function($model){
                 return '<div>'.$model->nReprogramaciones().'</div>';           
             }
             ],
            [  'attribute'=>'fechaprog',
                'format'=>'raw',
                 'value' => function ($model, $key, $index, $column) {
                    $options=[
                              //'class'=>'class_link_ajax'
                               'data-pjax'=>'0',
                                'target'=>'_blank'
                               ];
                    $url=\yii\helpers\Url::to(['/sta/citas/update','id'=>$model->id]);
                    return Html::a(substr($model->fechaprog,0,16),$url, $options);
                        },
                ],
                                
            [
    'attribute' => 'masivo',
    'format' => 'raw',
    'value' => function ($model) {
                   $cadena=($model->masivo)?'     <i style="font-size:20px;"><span class="fa fa-users"></span></i>':'     <i style="font-size:20px;"><span class="fa fa-user"></span></i>';
        return \yii\helpers\Html::checkbox('masivo[]', $model->masivo, [ 'disabled' => true]).$cadena;

             },

          ],                    
                                
         [
    'attribute' => 'asistio',
    'format' => 'raw',
    'value' => function ($model) {
      return '<span class="label label-'.array_keys($model->marcadorStatus())[0].'">'.array_values($model->marcadorStatus())[0].'</span>';
        return \yii\helpers\Html::checkbox('calificacion[]', $model->asistio, [ 'disabled' => true]);

             },

          ],
            //'codfac',
            //'ftermino',
           
           // 'materia.nomcur',
            //'nveces'
        ],
    ]); ?>
 

    <?php Pjax::end(); ?> 