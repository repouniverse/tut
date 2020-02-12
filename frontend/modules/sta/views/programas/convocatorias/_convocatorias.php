<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
?>

    
   
  
     <div class="box-body">
   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    
    
<?php

$gridColumns = [
                    
                
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

  
       

