<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;



 Pjax::begin(['id'=>'grilla-detfac']); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
            'dataProvider' =>new \yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sigi\models\SigiDetfacturacion::find()->andWhere(['kardex_id'=>$kardex_id])
        ]),
        'summary' => '',
        'showHeader'=> false,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
              ['attribute'=> 'numerorecibo',
                  'group'=>true,
                  ],  
            ['attribute'=> 'dias',
                  'group'=>true,
                  ],   
               'colector.cargo.descargo',
            ['attribute'=>'aacc',
                'value'=>function($model){
                    return ($model->aacc=='1')?'AACC':'';
                } 
             ] ,
              ['attribute'=>'monto',
                'format' => ['decimal', 3],
                'contentOptions'=>['align'=>'right'],  
             ]   
           //'dias',
            //'montodepa',
             /* 'descripcion', [
    'attribute' => 'activo',
    'format' => 'raw',
    'value' => function ($model) {
        return \yii\helpers\Html::checkbox('activo[]', $model->activo, [ 'disabled' => true]);

             },
          ],*/
        ],
    ]); ?>
         
         
    <?php Pjax::end(); ?>





