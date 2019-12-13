<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\editable\Editable;
use kartik\grid\GridView ;
use frontend\modules\sta\helpers\comboHelper;

?>



    <div class="box-body">
  
    <?php // echo $thigrids->render('_search', ['model' => $searchModel]); ?>

    
    <div style='overflow:auto;'>
   <?php 
   
  
   
   $dataTutores= comboHelper::getCboTutoresByProg($model->id);
   //print_r($dataTutores);die();
   $gridColumns = [
        [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{edit}',
                'buttons' => [
                   
                         'edit' => function ($url,$model) {
			    $url= Url::to(['califica-alumno','id'=>$model->id,'gridName'=>'sumilla','idModal'=>'buscarvalor']);
                             //echo  Html::button(yii::t('base.verbs','Modificar Rangos'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Tutor'),'id'=>'btn_contacts', 'class' => 'botonAbre btn btn-success']); 
                            return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-pencil"></span>', $url, ['class'=>'botonAbre']);
                            }
                    ]
                ],
       
[  'attribute' => 'cantidad',
    'format'=>'raw',
    'value' => function ($model, $key, $index, $column) {
                    $options=['id'=>$model->codalu,
                              'class'=>'class_link_ajax'
                               ];
                    return Html::a('<span class="badge badge-danger">'.$model->cantidad.'</span>', '#', $options);
                        }
],
        
[  'attribute' => 'ap',
],
[  'attribute' => 'nombres', 
],         
[
                'attribute'=>'codalu',
                'format'=>'raw',
                'value' => function ($model, $key, $index, $column) {
                    $options=['id'=>$model->codalu,
                              //'class'=>'class_link_ajax'
                               'data-pjax'=>'0',
                                'target'=>'_blank'
                               ];
                    $url=\yii\helpers\Url::to(['programas/trata-alumno','id'=>$model->id,'idalumno'=>$model->idalumno,'codperiodo'=>$model->codperiodo,'codalu'=>$model->codalu]);
                    return Html::a($model->codalu,$url, $options);
                        },
],
[ 
    'attribute' => 'codtra', 
],
       [ 
    'attribute' => 'celulares', 
],
                                  [ 
    'attribute' => 'correo', 
],
  [ 
    'attribute' => 'rank_tutor', 
    'format'=>'raw',
      'value'=>function($model){
              return '<i style="color:red;font-weight:900; font-size:14px;">'.$model->rank_tutor.'</i>' ;            
      }
],        
];
   
   
   
   
   ?>
        <?php 
        Pjax::begin(['id'=>'sumilla']);
        echo GridView::widget([
             'id' => 'kv-grid-demo',
        'dataProvider' => $dataProviderAlumnos,
         //'summary' => '',
        // 'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchAlumnos,
        'columns' => $gridColumns,
           //  'pjax' => true, // pjax is set to always true for this demo
            //'toggleDataContainer' => ['class' => 'btn-group mr-2'],
           /* 'panel' => [
        'type' => GridView::TYPE_WARNING,
        //'heading' => $heading,
    ],*/
    
    ]);
        Pjax::end();
        ?>
        
    
    </div>
    

  
  
    </div>

