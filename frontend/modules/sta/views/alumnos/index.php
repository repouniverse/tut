<?php
use kartik\export\ExportMenu;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\spinnerWidget\spinnerWidget;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\bigitems\models\DocbotellasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
ECHO spinnerWidget::widget();

//use kartik\datecontrol\DateControl;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sta\models\AlumnosController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sta.labels', 'Alumnos');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alumnos-index">
    
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    
    
<?php

$gridColumns = [
                     [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}',
                'buttons' => [
                    'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                          'view' => function($url, $model) {    
                             $url=\yii\helpers\Url::toRoute(['ver-detalles','id'=>$model->id]);
                        $options = [
                            'data-pjax'=>'0',
                            'title' => Yii::t('base.verbs', 'Detalles'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
                         },
                         
                    ]
                ],
                [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                                    'detail' => function ($model, $key, $index, $column) {
                            return Yii::$app->controller->renderPartial('_form_view_alu', ['model' => $model]);
                            },
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],
                ['attribute' => 'Riesgo',
                    'format'=>'raw',
                    'value' => function ($model, $key, $index, $column) {
                                $veces=$model->howManyRisks();
                                if($veces>0){
                                    return "<span class='label label-danger' >$veces</span>";
                                }else{
                                    return '';
                                }
                            
                                },
                    ],
                ['attribute' => 'ap',],
                ['attribute' => 'nombres'],
                [ 'attribute' => 'codalu'],
            ['attribute' => 'codfac'],
            ['attribute' => 'codcar'],
            ['class' => 'kartik\grid\CheckboxColumn',
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'pageSummary' => '<small>(amounts in $)</small>',
                'pageSummaryOptions' => ['colspan' => 3, 'data-colspan-dir' => 'rtl']
            ],
            ]   ;

    
    Pjax::begin();
echo $this->render('_search', ['model' => $searchModel]);
  ?>
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
  <?php
 echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<hr>\n".GridView::widget([
    'id' => 'kv-grid-demo',
    'dataProvider' => $dataProvider,
   'columns' => $gridColumns, // check the configuration for grid columns by clicking button above
    
    'pjax' => true, // pjax is set to always true for this demo
   'responsive' => TRUE,
    
]);
  Pjax::end();
?>
    
    
    <?php /*GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}{view}',
                'buttons' => [
                    'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options);
                         },
                          'view' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options);
                         },
                         'delete' => function($url, $model) {                        
                        $options = [
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'title' => Yii::t('base.verbs', 'Delete'),                            
                        ];
                        return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-remove"></span>', $url, $options);
                         }
                    ]
                ],
         
         [
                 'attribute' => 'Fotografia',
                    'headerOptions' => ['style' => 'width:10%'],
                'format' => 'html',
                'value' =>  function ($model, $key, $index, $column){
                        $options=['width' => '40','height' => '42','class'=>"img-thumbnail"];
                        return \yii\helpers\Html::img($model->getUrlImage(), $options);
                       
              },
            ],
         
         

            
            'codalu',
            'ap',
            'am',
            'nombres',
            
                            
           [
                 'attribute' =>  'codcar',
                    'headerOptions' => ['style' => 'width:40%'],
              'value' =>  function ($model, $key, $index, $column){
                        return $model->carrera->descar;
              },
            ],
        

          
        ],
    ]);*/  ?>
    

    </div>
</div>
    </div>
  
       