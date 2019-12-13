<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\sigi\models\SigiUnidadesSearch;
    use kartik\export\ExportMenu;
$colorPluginOptions =  [
    'showPalette' => true,
    'showPaletteOnly' => true,
    'showSelectionPalette' => true,
    'showAlpha' => false,
    'allowEmpty' => false,
    'preferredFormat' => 'name',
    'palette' => [
        [
            "white", "black", "grey", "silver", "gold", "brown", 
        ],
        [
            "red", "orange", "yellow", "indigo", "maroon", "pink"
        ],
        [
            "blue", "green", "violet", "cyan", "magenta", "purple", 
        ],
    ]
];
$gridColumns = [
  [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{update}',
               'buttons' => [
                    'update' => function($url, $model) {  
                         $url = \yii\helpers\Url::to(['/sigi/unidades/update','id'=>$model->id]);
                         $options = [
                            //'title' => Yii::t('sta.labels', 'Editar'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            //'data-method' => 'get',
                            'data-pjax' => '0',
                             'target'=>'_blank'
                        ];
                        //return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => ' btn btn-sm btn-success']);
                        return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>',$url,$options);
                     
                        
                        },
                      
                        
                    ]
                ],
[
    'class' => 'kartik\grid\ExpandRowColumn',
    'width' => '50px',
    'value' => function ($model, $key, $index, $column) {
        return GridView::ROW_COLLAPSED;
    },
    // uncomment below and comment detail if you need to render via ajax
    // 'detailUrl'=>Url::to(['/site/book-details']),
    'detail' => function ($model, $key, $index, $column) {
        return Yii::$app->controller->renderPartial('_detail_unit', ['model' => $model]);
    },
    'headerOptions' => ['class' => 'kartik-sheet-style'], 
    'expandOneOnly' => true
],


[
    
    'attribute' => 'numero',
    'format'=>'raw',
    'value' => function ($model, $key, $index, $column) {
        $formato=($model->isEntregado())?'  <i style="color:#3ead05;font-size:12px"><span class="glyphicon glyphicon-check"></span></i>':
               '  <i style="color:red;font-size:12px"><span class="glyphicon glyphicon-pushpin"></span></i>';
        return $model->numero.$formato;
    },
   
],
            [
             'attribute'=>'parent_id',
             'format'=>'raw',
             'value'=>function($model){
                   if($model->parent_id>0){
                      return   '<i style="color:#08882f;font-size:14px">    '.$model->padre->numero.'     <span class="fa fa-child"></span></i>' ;
                    
                   }
                    return '';
             
                       
             }
         ],
[
    
    'attribute' => 'nombre',    
   
],
[    
    'attribute' => 'area',
],
         [    
    'attribute' => 'tipo',
             'value'=>'tipo.desunidad',
             'group'=>true,
          ],
 [
             'attribute'=>'participacion',
             'format'=>'raw',
             'value'=>function($model){
                   return $model->participacion();
             }
         ],                
                 
[
    'class' => 'kartik\grid\CheckboxColumn',
    'headerOptions' => ['class' => 'kartik-sheet-style'],
    'pageSummary' => '<small>(amounts in $)</small>',
    'pageSummaryOptions' => ['colspan' => 3, 'data-colspan-dir' => 'rtl']
],
];
 $url= Url::to(['agrega-unidad','id'=>$model->id,'gridName'=>'grilla-unidades','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar Unidad'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Unidad'),'id'=>'btn_contacts', 'class' => 'botonAbre btn btn-success']); 
$dataProvider=(New SigiUnidadesSearch())->searchByEdificio($model->id);
 echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
     'filename'=>'unidades',
     'exportConfig'=>[
         ExportMenu::FORMAT_EXCEL=>[
             'filename'=>'Exportacion'
               ],
         ExportMenu::FORMAT_EXCEL_X=>[
             'filename'=>'Exportacion'
               ]
         ],
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) ?>
 
 <hr>
   <?php
   Pjax::begin(['id'=>'grilla-unidades']);
  echo GridView::widget([
    'id' => 'kv-grid-demo',
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => $gridColumns, // check the configuration for grid columns by clicking button above
    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
    'pjax' => true, // pjax is set to always true for this demo
    // set your toolbar
    'toolbar' =>  [
    ],
    'toggleDataContainer' => ['class' => 'btn-group mr-2'],
    // set export properties
    'export' => [
        'fontAwesome' => true
    ],
    // parameters from the demo form
   /* 'bordered' => $bordered,
    'striped' => $striped,
    'condensed' => $condensed,
    'responsive' => $responsive,
    'hover' => $hover,
    'showPageSummary' => $pageSummary,*/
    'panel' => [
        'type' => GridView::TYPE_WARNING,
        //'heading' => $heading,
    ],
    'persistResize' => false,
    'toggleDataOptions' => ['minCount' => 10],
    //'exportConfig' => $exportConfig,
    'itemLabelSingle' => yii::t('sta.labels','Unidad'),
    'itemLabelPlural' => yii::t('sta.labels','Unidades'),
]);  

  
  
  Pjax::end();
  
?>
    
  


