<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
?>

    
   
  
     <div class="box-body">
   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    
    
<?php

$gridColumns = [
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
                             $url=\yii\helpers\Url::toRoute(['ver-detalles','id'=>$model->id]);
                        $options = [
                            'data-pjax'=>'0',
                            'title' => Yii::t('base.verbs', 'Detalles'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
                         },
                         
                    ]
                ],
               
                
                ['attribute' => 'canal',
                    
                     'format' => 'raw',
                            'value' => function ($model) {
                            return $model->comboValueField('canal') ;
                                   },
                    ],
                'fecha',
                     [
                          'attribute' => 'resultado',
                         'format' => 'raw',
                            'value' => function ($model) {
                            return \yii\helpers\Html::checkbox('resultado[]', $model->resultado, [ 'disabled' => true]);
                                   },
                      ],
                                          
            ]   ;

    $idPjax="convocatorias_".$grupo_id;
    Pjax::begin(['id'=>$idPjax]);

  ?>
 
  <?php
 echo GridView::widget([
    'id' => 'kv-grid-demo',
    'dataProvider' => (new frontend\modules\sta\models\StaConvocatoriaSearch())->searchByDetalle($grupo_id),
   'columns' => $gridColumns, // check the configuration for grid columns by clicking button above
    
    'pjax' => true, // pjax is set to always true for this demo
   'responsive' => TRUE,
    
]);
 Pjax::end();
?>
  

  
</div>

  
       

