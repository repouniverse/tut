<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\sigi\helpers\comboHelper;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sigi\models\SigiBasePresupuestoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sigi.labels', 'Partidas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-base-presupuesto-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('sigi.labels', 'Crear Partida'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
        'pjax' => true,
    'striped' => true,
    'hover' => true,
       'showPageSummary' => true,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
        'columns' => [
           ['class' => 'kartik\grid\SerialColumn'], 
         
       
                             // 'codigo',
            ['attribute'=>'descripcion',
                            //'format' => ['decimal', 2],
                            'pageSummary' => yii::t('sigi.labels','Subtotal'),
                 
                            ]    ,
                        ['attribute'=>'mensual',
                            'format' => ['decimal', 2],
                            'pageSummary' => true,
                            ]    ,
            //'activo',
            ['attribute'=>'ejercicio',
                            
                            ]    ,
             ['attribute'=>'edificio_id',
                                 'value'=>'edificio.codigo',
                                 'filter'=>comboHelper::getCboEdificios(),
             'group'=>true,
                            
                            ],
              ['attribute'=>'cargosgrupoedificio_id',
                    'value'=> 'cargosGrupoEdificioFirme.descripcion',
                                // 'filter'=>comboHelper::getCboEdificios(),
             'group'=>true,
                      
                            ],
            ['attribute'=>'cargosedificio_id',
                    'value'=>function($model){
                        return $model->grupoConcepto->cargo->descargo;
                    },
               
                                 //'filter'=>comboHelper::getCboEdificios(),
             'group'=>true,
            // 'subGroupOf'=>6
              //'group'=>true,
                //'groupedRow' => true,                
              // 'pageSummary' => true,            
                            ],
                          
          
            
            //'anual',
            //'restringir',
            //'acumulado',
  [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                          'view' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
                         },
                         'delete' => function($url, $model) {                        
                        $options = [
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'title' => Yii::t('base.verbs', 'Delete'),                            
                        ];
                        return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-remove"></span>', $url, $options/*$options*/);
                         }
                    ]
                ],
          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       