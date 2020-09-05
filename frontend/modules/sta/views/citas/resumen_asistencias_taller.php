<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use kartik\grid\GridView;
use frontend\modules\sta\models\Citas;
use yii\grid\GridView;
use yii\widgets\Pjax;
    use kartik\export\ExportMenu;
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sta\models\CitasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sta.labels', 'Resumen Asistencias Taller');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citas-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
   
         <hr/>
    
    <?php
    $gridColumns=[
            
        [ 'attribute' => 'numero',
             ],
            // 'alumno.celulares', 
             // 'alumno.correo', 
           [ 'attribute' => 'fecha',
             ],
       [
           'attribute' => 'codfac',
          // 'visible' =>false,
           ],
           [
           'attribute' => 'codperiodo',
          // 'visible' =>false,
           ],
      
         [ 'attribute' => 'proceso',
             ],
        [ 'attribute' => 'grupo',
             ],
            [ 
             'attribute' => 'secuencia',
                'header'=>'Sesión'
             ],
            [ 
             'attribute' => 'asistencias'
             ],
             [ 
             'attribute' => 'Convocados',
                'value'=>function($model){
                  return $model->totalConvocados();
                }
             ],
             
        ];
    $dataProvider= new \yii\data\ActiveDataProvider(
            [
                'query'=> frontend\modules\sta\models\VwStaAsistenciasTaller::find(),
            ]
            );
    echo ExportMenu::widget([
    'dataProvider' =>$dataProvider,
     'filename'=>'Asistencias Talleres',
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
    
    
    <div style='overflow:auto;'>
    <?php Pjax::begin(['id'=>'listado_asistencias', 'timeout'=>false]); ?>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         //'summary' => '',
         'tableOptions'=>['class'=>'table no-margin'],
        //'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>
        
        <div class="btn-group">
            
        </div> 
   </div> 
 
 
  
                
        
        
 
</div>   
    </div>
</div>
    
  
   