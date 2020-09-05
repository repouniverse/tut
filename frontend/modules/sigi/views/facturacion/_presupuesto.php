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
<H4><?=yii::t('sigi.labels','Partidas presupuestales')?></H4>
<div class="sigi-base-presupuesto-index">

  
   
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => $dataProviderPartidas,
         'summary' => '',
        'pjax' => true,
    'striped' => true,
    'hover' => true,
       'showPageSummary' => true,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModelPartidas,
        'columns' => [
            
          /*['attribute'=>'cargosgrupoedificio_id',
                    'value'=> 'cargosGrupoEdificioFirme.descripcion',
                                // 'filter'=>comboHelper::getCboEdificios(),
             'group'=>true,
                      
                            ],*/
            ['attribute'=>'cargosedificio_id',
                 'width' => '25px',
                    'value'=>function($model){
                        return $model->grupoConcepto->cargo->descargo;
                    },
                   'group'=>true,          
               /* 'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                return [
                    'mergeColumns' => [[0,1,2]], // columns to merge in summary
                    'content' => [             // content to show in each summary cell
                        2 => 'Subtotal  (   ' . $model->grupoConcepto->cargo->descargo. '   )',
                       
                        3 => GridView::F_SUM,
                        //7 => GridView::F_SUM,
                    ],
                    'contentFormats' => [      // content reformatting for each summary cell
                        //4 => ['format' => 'number', 'decimals' => 2],
                       // 6 => ['format' => 'number', 'decimals' => 2],
                        3 => ['format' => 'number', 'decimals' => 2],
                    ],
                    'contentOptions' => [      // content html attributes for each summary cell
                        2 => ['style' => 'font-variant:small-caps'],
                       
                        //6 => ['style' => 'text-align:right'],
                        3 => ['style' => 'text-align:right'],
                    ],
                    // html attributes for group summary row
                    'options' => ['class' => 'info table-info','style' => 'font-weight:bold;']
                ];
            }*/
                                 //'filter'=>comboHelper::getCboEdificios(),
             //'group'=>true,
            // 'subGroupOf'=>6
              //'group'=>true,
                //'groupedRow' => true,                
              // 'pageSummary' => true,            
                            ],
                          
          
         
       
                             // 'codigo',
            ['attribute'=>'descripcion',
                            //'format' => ['decimal', 2],
                            'pageSummary' => yii::t('sigi.labels','Subtotal'),
                 'width' => '25px',
                 //'group'=>true,   
                            ]    ,
                        ['attribute'=>'mensual',
                            'format' => ['decimal', 3],
                            'contentOptions'=>['align'=>'right'],
                            'pageSummary' => true,
                            ]    ,
            //'activo',
            
              
            
            //'anual',
            //'restringir',
            //'acumulado',
 
          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>

       