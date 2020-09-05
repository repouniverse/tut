<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sigi\models\SigiKardexdepaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sigi Kardexdepas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-kardexdepa-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Sigi Kardexdepa'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         //'summary' => '',
        'showPageSummary' => true,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
        'columns' => [
            
         
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
                          
                    ]
                ],
         
         
         
         
         
             ['attribute'=>'edificio_id',
               'filter'=> \frontend\modules\sigi\helpers\comboHelper::getCboEdificios(),
               'value'=>function($model){
                       return $model->codigo; 
               }
                 
                 ],
            'numero',
           // 'nombre',
           // 'facturacion_id',
            'operacion_id',
            //'edificio_id',
           // 'unidad_id',
           // 'mes',
            'fecha',
            //'anio',
            'codmon',
            'numerorecibo',
            ['attribute'=>'monto',
                'format' => ['decimal', 3],
                 'pageSummary' => true,
                'contentOptions'=>['align'=>'right'],
              'value'=>function($model){
                 return $model->getMonto();    
              }  
                ],
            'igv',
            //'detalles:ntext',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       