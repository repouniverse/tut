<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

?>
<div class="edificittos-index">
    
    
    <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
          <?php
 $url= Url::to(['agrega-concepto','id'=>$model->id,'gridName'=>'grilla-conceptos','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Insertar Concepto'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Concepto'),'id'=>'btn_cueentas_edi', 'class' => 'botonAbre btn btn-success']); 
?>
            </div>
        </div>
    </div>
    
    
    
    
    
    
   
    
    <?php Pjax::begin(['id'=>'grilla-conceptos']); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
 <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
        'columns' => [
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}{view}',
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
            'cargo.descargo',
            'grupo.descripcion',
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
                     'attribute' => 'frecuencia',
                        
                            ],
                                            [
                     'attribute' => 'tasamora',
                        
                            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    

    