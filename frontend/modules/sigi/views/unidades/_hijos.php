<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use frontend\modules\sigi\models\SigiPropietariosSearch;
use frontend\modules\sigi\models\SigiUnidadesSearch;
?>
<div class="edificios-index_docus">

     <div class="box-body">
         
<?php
 $url= Url::to(['agrega-hijo','id'=>$model->id,'gridName'=>'grilla-hijos','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Insertar Adjunto'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Adjunto'),'id'=>'btn_hijos_edi', 'class' => 'botonAbre btn btn-success']); 
?> 
         
    <?php Pjax::begin(['id'=>'grilla-hijos']); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'id'=>'grilla-grid-hijos',
        'dataProvider' =>(new SigiUnidadesSearch())->searchByUnidad($model->id),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                 [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [
                    'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>false,'idModal'=>'imagemodal','modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Subir Archivo'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },
                        'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                        
                    ]
                ],
            'nombre',
              'numero',              
           
              /* [
    'attribute' => 'activo',
    'format' => 'raw',
    'value' => function ($model) {
        return \yii\helpers\Html::checkbox('activo[]', $model->activo, [ 'disabled' => true]);

             },

          ],*/
        ],
    ]); ?>
         <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetytytgruidBancos',
            'idGrilla'=>'grilla-hijos',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
         
    <?php Pjax::end(); ?>

    </div>
      </div>