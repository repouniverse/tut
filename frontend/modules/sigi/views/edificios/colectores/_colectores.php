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
               
                
                ['attribute' => 'tasamora',],
                'cargo.descargo',
                     [
                          'attribute' => 'regular',
                         'format' => 'raw',
                            'value' => function ($model) {
                            return \yii\helpers\Html::checkbox('regular[]', $model->regular, [ 'disabled' => true]);
                                   },
                      ],
                                           [
                          'attribute' => 'montofijo',
                         'format' => 'raw',
                            'value' => function ($model) {
                            return \yii\helpers\Html::checkbox('montofijo[]', $model->montofijo, [ 'disabled' => true]);
                                   },
                      ],
                                           [
                          'attribute' => 'individual',
                         'format' => 'raw',
                            'value' => function ($model) {
                            return \yii\helpers\Html::checkbox('individual[]', $model->individual, [ 'disabled' => true]);
                                   },
                      ],
                                           
            ]   ;

    $idPjax="pjax_colector_".$grupo_id;
    Pjax::begin(['id'=>$idPjax]);

  ?>
   <div> 
  <?php
 echo GridView::widget([
    'id' => 'kv-grid-demo',
    'dataProvider' => (new frontend\modules\sigi\models\SigiCargosedificioSearch())->searchByGrupo($grupo_id),
   'columns' => $gridColumns, // check the configuration for grid columns by clicking button above
    
    'pjax' => true, // pjax is set to always true for this demo
   'responsive' => TRUE,
    
]);
 
?>
    
 <?php
 $url= \yii\helpers\Url::to(['agrega-concepto-tree','id'=>$grupo_id,'gridName'=>$idPjax,'idModal'=>'buscarvalor']);
   echo \yii\helpers\Html::button(yii::t('base.verbs','Nuevo'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Agrupacion'),'id'=>'btn_grupos_edixr', 'class' => 'botonAbre btn btn-success']); 
 Pjax::end();
   
   ?>   

    </div>
</div>

  
       

