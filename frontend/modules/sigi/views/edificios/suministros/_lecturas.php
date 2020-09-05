<?php  
use yii\helpers\Html;
use yii\helpers\Url;

use kartik\grid\GridView;
?>
<div style='overflow:auto;'>
   <?php 
    
   ////$dataTutores= comboHelper::getCboTutoresByProg($model->id);
   //print_r($dataTutores);die();
   $gridColumns = [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                   
                        'update' => function($url, $model) {  
                       $url= Url::to(['/sigi/unidades/edita-lectura','id'=>$model->id,'gridName'=>'grilla_lecturas','idModal'=>'buscarvalor']);
                         $options = [
                           'class'=>'botonAbre',
                            //'title' => Yii::t('sta.labels', 'Editar'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            //'data-method' => 'get',
                           // 'data-pjax' => '0',
                             //'target'=>'_blank'
                        ];
                        //return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => ' btn btn-sm btn-success']);
                       
                         return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>',$url,$options);
                     
                        
                        },
                    ]
                ],
        [
   
    
],                    
                            
[  'attribute' => 'flectura',
    'format'=>'raw',
    'value' => function ($model, $key, $index, $column) {
                    return $model->flectura;
                        }
],
 [  'attribute' => 'lectura',
    'format'=>'raw',
    'value' => function ($model, $key, $index, $column) {
                    return $model->lectura;
                        }
],
[  'attribute' => 'delta',
],
[  'attribute' => 'lecturaant', 
],         
[  'attribute' => 'mes',
],
[  'attribute' => 'anio', 
], 
[
 'attribute' => 'facturable',
'format' => 'raw',
 'value' => function ($model) {
return \yii\helpers\Html::checkbox('facturable[]', $model->facturable, [ 'disabled' => true]);
 },
],

];
   
   
   
   
   ?>
        <?php 
       
        echo GridView::widget([
             'id' => 'kv-grid-demo',
        'dataProvider' => $dataProvider,
         //'summary' => '',
        // 'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
           //  'pjax' => true, // pjax is set to always true for this demo
            //'toggleDataContainer' => ['class' => 'btn-group mr-2'],
           /* 'panel' => [
        'type' => GridView::TYPE_WARNING,
        //'heading' => $heading,
    ],*/
    
    ]);
        //Pjax::end();
        ?>
        
    
    </div>
