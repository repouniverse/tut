<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
<div class="talleres-index">

    
   
     <div class="box-body">
    <?php Pjax::begin(['id'=>'grilla-staff']); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => $dataProviderStaff,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}{view}',
                'buttons' => [
                   
                         'view' => function ($url,$model) {
			    $url= Url::to(['cambio-psicologo','id'=>$model->id,'gridName'=>'grilla-staff','idModal'=>'buscarvalor']);
                             //echo  Html::button(yii::t('base.verbs','Modificar Rangos'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Tutor'),'id'=>'btn_contacts', 'class' => 'botonAbre btn btn-success']); 
                            return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-pencil"></span>', $url, ['class'=>'botonAbre']);
                            },
                         'delete' => function ($url,$model) {
			    $url = Url::toRoute($this->context->id.'/ajax-detach-psico',['id'=>$model->id]);
                             return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=> \yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                    ]
                ],
         
         
         
         
         

           'codtra',
            'trabajador.ap',
                             'trabajador.am',
                             'trabajador.nombres',
            [
                'attribute'=>'nalumnos',
                'format'=>'raw',
                'value' => function ($model, $key, $index, $column) {
                    return '<span class="badge badge-success" >'.$model->nalumnos.'</span>';
                        },
                ],
                                [
                'attribute'=>'reporte',
                'format'=>'raw',
                'value' => function ($model, $key, $index, $column) {
                    $url=\yii\helpers\Url::to(['/report/make/creareporte/','id'=>8, 'idfiltro'=>\yii\helpers\Json::encode(['codtra'=>$model->codtra,'talleres_id'=>$model->talleres_id])]);
                   return Html::a('<span class="fa fa-clock" ></span>',$url,['target'=>'_blank','data-pjax'=>'0']);
                        },
                ],
                                [
    'attribute' => 'calificacion',
    'format' => 'raw',
    'value' => function ($model) {
        return \yii\helpers\Html::checkbox('calificacion[]', $model->calificacion, [ 'disabled' => true]);

             },

          ],
            //'fclose',
            //'codcur',
            //'activa',
            //'codperiodo',
            //'electivo',
            //'ciclo',

          
        ],
    ]);
             
        echo linkAjaxGridWidget::widget([
           'id'=>'mifpapaxx',
            'idGrilla'=>'grilla-staff',
            'family'=>'holas',
          'type'=>'GET',
           'evento'=>'click',
            //'foreignskeys'=>[1,2,3],
        ]); 
         
             ?>
    <?php Pjax::end(); ?>
</div>
    </div>
    <?php
 $url= Url::to(['agrega-psico','id'=>$model->id,'gridName'=>'grilla-staff','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar Psicólogo'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Tutor'),'id'=>'btn_contacts', 'class' => 'botonAbre btn btn-success']); 
?> 
</div>
  
       

