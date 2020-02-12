<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sta\models\TalleresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sta.labels', 'Talleres');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="talleres-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php //echo $this->render('_searchriesgo', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('sta.labels', 'Crear Programa'), ['create'], ['class' => 'btn btn-success']) ?>
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
               'template' => '{update}{view}',
                'buttons' => [
                    'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'), 
                            'data-pjax'=>0,
                            'target'=>'_blank'
                            
                        ];
                        return Html::a('<span class="btn btn-success btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                          'view' => function($url, $model) { 
                           $url=\yii\helpers\Url::to(['programa-vista','id'=>$model->id]);
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),
                              'data-pjax'=>0,
                              'target'=>'_blank'
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
                         },
                        /* 'delete' => function($url, $model) {                        
                        $options = [
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'title' => Yii::t('base.verbs', 'Delete'),                            
                        ];
                        return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-remove"></span>', $url, $options);
                        }*/
                    ]
                    
                ],
         
         
         
         
         

            'numero',
            ['attribute' => 'codfac',
              'filter'=> \frontend\modules\sta\helpers\comboHelper::getCboFacultades(),  
                ],
            [ 'attribute' => 'descripcion', 'headerOptions' => ['style' => 'width:30%'], ],
           ['attribute' => 'codperiodo',
              'filter'=> \frontend\modules\sta\helpers\comboHelper::getCboPeriodos(),  
                ],
            'fopen',
            //'fclose',
            //'codcur',
            //'activa',
            //'codperiodo',
            //'electivo',
            //'ciclo',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       