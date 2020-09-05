<?php
use yii\helpers\Html,yii\helpers\Url;
 use kartik\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\sta\helpers\comboHelper;
?>
    <div class="box-body">
  
    <?php // echo $thigrids->render('_search', ['model' => $searchModel]); ?>

    
    <div style='overflow:auto;'>
   <?php 
    Pjax::begin(['id'=>'lecturasgrid']);
   ////$dataTutores= comboHelper::getCboTutoresByProg($model->id);
   //print_r($dataTutores);die();
   $gridColumns = [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{add}',
                'buttons' => [
                   'add' => function($url, $model) {  
                       $url= Url::to(['/sigi/unidades/agrega-lectura','id'=>$model->id,'gridName'=>'lecturasgrid','idModal'=>'buscarvalor']);
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
                       
                         return Html::a('<span class="btn btn-danger glyphicon glyphicon-plus-sign"></span>',$url,$options);
                     
                        
                        },
                    ]
                ],
                            
 [  'attribute' => 'id',
    
],
                          
[  'attribute' => 'Unidad',
    'format'=>'raw',
    'value' => function ($model, $key, $index, $column) {
                    
                    return $model->unidad->numero;
                        }
],
 
[  'attribute' => 'numerocliente',
],
[  'attribute' => 'codum', 
   'value' => function ($model, $key, $index, $column) {
                    return $model->codum;
                        } 
],         

  
];
   
   
   
   
   ?>
        <?php 
       
        echo GridView::widget([
             'id' => 'kv-grid-demo',
        'dataProvider' => $dataProviderLecturasFaltan,
         //'summary' => '',
        // 'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchAlumnos,
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
    

  
<?PHP
 Pjax::end();
?>
    </div>