<?php

use yii\helpers\Html;
use kartik\grid\GridView;
//use yii\grid\GridView;
use yii\widgets\Pjax;
    use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sta\models\CitasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sta.labels', 'Citas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citas-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
         <hr/>
    
    <?php
    $gridColumns=[
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}',
                'buttons' => [
                    'update' => function($url, $model) {
                     if(strtotime($model->swichtDate('fechaprog',false))==0){
                         return '';   
                     }else{
                          $url= \yii\helpers\Url::toRoute(['update','id'=>$model->id]);
                        $options = [
                            'data-pjax'=>'0',
                            'target'=>'_blank',
                            'title' => Yii::t('base.verbs', 'Editar'),                            
                        ];
                        return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                      
                        
                     }
                        },
                          'view' => function($url, $model) {  
                            if(strtotime($model->swichtDate('fechaprog',false))==0){
                                 return ''; 
                        }else{
                             $options = [
                            'title' => Yii::t('base.verbs', 'Ver'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
                        
                              
                         }
                        },
                         
                    ]
                ],
         [ 'attribute' => 'numerocita',
             'format'=>'raw',
             'value'=>function($model){
                 return '<span style="font-size:14px; color:#ad5eb7; font-weight:700;">'.$model->numerocita.'</span>';           
             }
             ],
                      [
               'attribute' => 'fechaprog',
           
                    ], 
               [
               'attribute' => 'codfac',
                    'group'=>TRUE,
                    ],  
                   [
               'attribute' => 'codperiodo',
                    'group'=>TRUE,
                    ],       
                     
         
                [
               'attribute' => 'codalu',
                    'group'=>TRUE,
                    ],  
                   [
               'attribute' => 'ap',
                    'group'=>TRUE,
                    ], 
                     [
               'attribute' => 'am',
                    'group'=>TRUE,
                    ], 
                    [  'attribute' => 'nombres',
                    'group'=>TRUE,
                    ],
         [  'attribute' => 'aptutor',
                    'group'=>TRUE,
                    ],
           /* 'id',
            'talleres_id',
            'talleresdet_id',*/
           
            
            //'codperiodo',
                       
            //'finicio',
            //'ftermino',
            //'fingreso',
            //'detalles:ntext',
            //'codaula',
            //'duracion',

          
        ];
    
    echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
     'filename'=>'Citas',
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
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       