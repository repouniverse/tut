<?php
 use yii\widgets\Pjax;
 use yii\grid\GridView;
 use yii\helpers\Html;
  use yii\helpers\Url;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
     
   <?php Pjax::begin(['id'=>'grilla-indicadores']); ?>
    
   <?php 
  
   $query= frontend\modules\sta\models\StaCitaIndicadores::find()->where(['citas_id'=>$model->id]);
//var_dump($query->createCommand()->getRawSql()); die();
   $provider= new \yii\data\ActiveDataProvider([
            'query'=>$query,
        ]);
   $actionColumn= [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}{edit}',
                'buttons' => [
                   'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            },
                      
                                    
                       'edit' => function($url, $model) {  
                           $url= Url::to(['edita-indicador','id'=>$model->id,'gridName'=>'grilla-indicadores','idModal'=>'buscarvalor']);
                            return  Html::button('<span class="fa fa-edit"></span>', ['href' => $url, 'title' => yii::t('sta.labels','Editar'), 'class' => 'botonAbre btn btn-success']); 
                          },
                         
                    ]
                ];
            
    $columns=[
            
            ['attribute'=>'Indicador',
              'value'=>function($model){
                  return  $model->indicador->nombre;
                  }  
                ],
              
                 'relevancia' , 
                // 'indicador.nombre',
            ['attribute'=>'detalles',
                'format'=>'raw',
                     'value'=>function($model){
                        return substr($model->detalles,0,30).'  ...';
                        }
                     ],
                
               ];
   if(!isset($simple)){     
       $columns[]=$actionColumn;
   }
//var_dump($model->examenesId($idCitaEvalInicial)); die(); ?>
    <?= GridView::widget([
        'id'=>'grid-inci',
        'dataProvider' =>$provider,
         'summary' => '',
         //'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' =>$columns,
    ]); ?>
     <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'TETETEgrildddla-indicadores',
            'idGrilla'=>'grilla-indicadores',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
   
    
       <?php Pjax::end(); ?> 