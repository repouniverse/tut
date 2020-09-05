<?php
use frontend\modules\sta\models\StaVwCitas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
<h4><?=yii::t('sta.labels','Citas vencidas')?></h4>
<div class="talleres-index">

    
   
     <div class="box-body">
    <?php Pjax::begin(['id'=>'grilla-vencidas']); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' =>new \yii\data\ActiveDataProvider([
    'query' => StaVwCitas::find()->where(['<','fechaprog',date('Y-m-d 00:00::00')])->
                andWhere(['asistio'=>'0'])->andWhere(['talleres_id'=>$model->id]),
                            'pagination' => [
                                'pageSize' => 20,
                ],
                                                        ]),
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
        'columns' => [ 
           'fechaprog',
            [
                'attribute'=>'codalu',
                'format'=>'raw',
                'value' => function ($model, $key, $index, $column) {
                    $options=['id'=>$model->codalu,
                              //'class'=>'class_link_ajax'
                               'data-pjax'=>'0',
                                'target'=>'_blank'
                               ];
                    $url=\yii\helpers\Url::to(['programas/trata-alumno','id'=>$model->talleresdet_id,'idalumno'=>$model->idalumno,'codperiodo'=>$model->codperiodo,'codalu'=>$model->codalu]);
                    if(!empty($model->codtra)){
                        return Html::a($model->codalu,$url, $options);
                    }else{
                        return $model->codalu;
                    }
                    
                        },
                    ],
            'ap',
            'am',
            'codtra'
          
        ],
    ]);
             
         
         
             ?><?php Pjax::end(); ?>
</div>
    </div>
   
</div>
  
       

