<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sigi\models\SigiCuentasporSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sigi.labels', 'Recibos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-cuentaspor-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('sigi.labels', 'Crear Recibos'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
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
           ['class' => 'frontend\modules\report\components\columnGridReport',
                   'attribute'=>'report_id'],
         
         
         
         

           // 'id',
              ['attribute'=>'edificio_id',
                  'filter'=> frontend\modules\sigi\helpers\comboHelper::getCboEdificios(),
                  'value'=>'edificio.codigo'
                  ],
           /* ['attribute'=>'codocu',
                  'filter'=> frontend\modules\sigi\helpers\comboHelper::getCboDocuments(),
                  'value'=>'documento.desdocu'
                  ],*/
                            
             ['attribute'=>'colector_id',
                  //'filter'=> frontend\modules\sigi\helpers\comboHelper::getCboColectores($model->edificio_id),
                  'value'=>'colector.cargo.descargo'
                  ],               
           // 'codocu',
            'descripcion',
            'fedoc',
                            
            'mes',
            'anio',
            //'detalle:ntext',
            //'fevenc',
            'monto',
            //'igv',
            //'codestado',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       