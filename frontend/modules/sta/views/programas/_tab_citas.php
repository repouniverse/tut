<?php
use yii\helpers\Html;
use yii\grid\GridView;
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
            'template' => '{delete}',
               'buttons' => [                    
                        'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute(['/sta/citas/elimina-cita','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', $url, []);
                            }
                        
                    ]
                ],
            [ 'attribute' => 'numero',
             'format'=>'raw',
             'value'=>function($model){
                 return '<span style="font-size:14px; color:#ad5eb7; font-weight:700;">'.$model->numerocita.'</span>';           
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
                    return Html::a($model->fechaprog,$url, $options);
                        },
                ],
            //'codfac',
            //'ftermino',
            'detalles',
           // 'materia.nomcur',
            //'nveces'
        ],
    ]); ?>
 

    <?php Pjax::end(); ?> 