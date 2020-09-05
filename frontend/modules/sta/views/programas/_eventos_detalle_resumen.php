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
           [ 'attribute'=>'numerocita',
               'format'=>'raw',
              
               ],
              [ 'attribute'=>'codalu',
               'format'=>'raw',
                 
                        ],         
                       
           'nombres',
            'asistio', 
          'libre', 
        
         
        ];
       echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
     'filename'=>'Alumnos_por_convocar',
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
       
       
     <?php Pjax::begin(['id'=>'grilla-convocatorias']); ?> 
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' =>$dataProvider,
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
         // 'showPageSummary' => true,
        'columns' => $gridColumns,
    ]);
             
         
         
             ?><?php Pjax::end(); ?>
</div>
    </div>   

