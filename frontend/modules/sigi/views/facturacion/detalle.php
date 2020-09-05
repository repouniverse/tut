<?php
use kartik\export\ExportMenu;

use kartik\grid\GridView;
use kartik\helpers\Html;
?>
<?php $this->title = Yii::t('sigi.labels', 'Detalle de Facturación');
$this->params['breadcrumbs'][] = ['label' =>Yii::t('sigi.labels', 'Facturación'), 'url' => ['update', 'id' => $id]];
$this->params['breadcrumbs'][] = $this->title;
?>


    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">

<?php
$gridColums=[
    ['attribute'=>'grupocobranza',
               //'group'=>true,
                 
                ],
            ['attribute'=>'codigo',
               //'group'=>true,
                 
                ],
     ['attribute'=>'numero',
               'group'=>true,  
                'format'=>'raw',
                'value'=>function ($model) {
                   return '<span style="font-size=15px;font-weight:bold;color:red;">'.$model->numero.'</span>';
                },
               //'groupedRow'=>true,
            'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                return [
                    'mergeColumns' => [[0,1,2,3,4,5,6]], // columns to merge in summary
                    'content' => [             // content to show in each summary cell
                        6 => 'Subtotal  (   ' . $model->nombre. '   )',
                       
                        7 => GridView::F_SUM,
                        8 => GridView::F_SUM,
                    ],
                    'contentFormats' => [      // content reformatting for each summary cell
                        //4 => ['format' => 'number', 'decimals' => 2],
                        7 => ['format' => 'number', 'decimals' => 2],
                        8 => ['format' => 'number', 'decimals' => 2],
                    ],
                    'contentOptions' => [      // content html attributes for each summary cell
                        1 => ['style' => 'font-variant:small-caps'],
                       
                        7 => ['style' => 'text-align:right'],
                        8 => ['style' => 'text-align:right'],
                    ],
                    // html attributes for group summary row
                    'options' => ['class' => 'info table-info','style' => 'font-weight:bold;']
                ];
            }
         
                ],
     ['attribute'=>'anio',
               //'group'=>true,
                ],
     ['attribute'=>'mes',
              // 'group'=>true,
                ],
                 
           ['attribute'=>'areadepa',
              // 'group'=>true,
                ],        
             ['attribute'=>'descargo',
               'group'=>true,
                 'pageSummary' => yii::t('sigi.labels','Total'),
               'pageSummaryOptions' => ['class' => 'text-right'],
                ],
            ['attribute'=>'monto',
               //'mergeHeader' => true,
           // 'width' => '150px',
            'hAlign' => 'right',
            'format' => ['decimal', 2],
            'pageSummary' => true
                ],
                        
              ['attribute'=>'igv',
               //'mergeHeader' => true,
           // 'width' => '150px',
            'hAlign' => 'right',
            'format' => ['decimal', 2],
            'pageSummary' => true
                ],
          
        ];
?>

     <div style='overflow:auto;'>
<?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
        'batchSize'=>1500,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<hr>\n".GridView::widget([
        'dataProvider' => $dataProvider,
    'showPageSummary' => true,
        // 'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' =>$gridColums,
    ]); ?>

         


</div>
</div>
</div>















