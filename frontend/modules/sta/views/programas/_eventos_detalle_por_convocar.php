<?php
//use frontend\modules\sta\models\StaVwCitas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
  use kartik\export\ExportMenu;
//use frontend\modules\sta\models\StaEventos;
//use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
  <?php  
  $gridColumns=[
           [ 'attribute'=>'codalu',
               'format'=>'raw',
              
               ],
             
           'alumno.ap',
            'alumno.am', 
            'alumno.nombres', 
         'alumno.celulares',
        
         
        ];
  
  echo ExportMenu::widget([
    'dataProvider' => $dataProviderFaltantes,
     'filename'=>'Alumnos_por_convocar',
     'exportConfig'=>[
         ExportMenu::FORMAT_EXCEL=>[
            'label' => Yii::t('sta.labels', 'Excel 95 +'),
       
        'iconOptions' => ['class' => 'text-success'],
        'linkOptions' => [],
        'options' => ['title' => Yii::t('sta.labels', 'Microsoft Excel 95+ (xls)')],
        //'alertMsg' => Yii::t('kvexport', 'The EXCEL 95+ (xls) export file will be generated for download.'),
        'mime' => 'application/vnd.ms-excel',
        'extension' => 'xls',
        'writer' => ExportMenu::FORMAT_EXCEL
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
    <?php Pjax::begin(['id'=>'grilla-faltantes']); ?>
    <?php 

// echo $this->render('_search', ['model' => $searchModel]); ?>
        
     
    
    <?= GridView::widget([
        'dataProvider' =>$dataProviderFaltantes,
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
         // 'showPageSummary' => true,
        'columns' => $gridColumns
    ]);
             
         
         
             ?><?php Pjax::end(); ?>

    </div>   

