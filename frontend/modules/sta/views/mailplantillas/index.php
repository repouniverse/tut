<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\sta\models\PlantillaCorreos;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sta\models\PlantillaCorreosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Plantilla Correos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plantilla-correos-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('base.names', 'Create Plantilla Correos'), ['create'], ['class' => 'btn btn-success']) ?>
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
                            'title' => Yii::t('base.verbs', 'Editar'),                            
                        ];
                        return Html::a('<span class="btn btn-success btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                         
                         
                    ]
                ],
         
         
         
         
         

            //'id',
            //'programa_id',
           ['attribute'=>'codfac',
             'filter'=> \frontend\modules\sta\helpers\comboHelper::getCboFacultades(),
               'value'=>function($model){
                  return $model->codfac;          
               }
               ],
         ['attribute'=>'disparador',
             'filter'=>PlantillaCorreos::comboDataField('disparador'),
               'value'=>function($model){
                  return $model->comboValueField('disparador');          
               }
               ],
             [
    'attribute' => 'masivo',
    'format' => 'raw',
    'value' => function ($model) {
        return \yii\helpers\Html::checkbox('masivo[]', $model->masivo, [ 'disabled' => true]);

             },

          ],
            'descripcion',
           
            //'disparador',
            //'titulo',
            //'cuerpo:ntext',
            //'detalles:ntext',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       