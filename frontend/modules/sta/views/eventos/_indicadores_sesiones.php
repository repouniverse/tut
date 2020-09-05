<?php
USE yii\grid\GridView;
use yii\widgets\Pjax;
 use yii\helpers\Url;
 use yii\helpers\Html;
?>

<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?PHP    

    ?>
    
</div>
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
<?php 
//if($model->hasAsistencias()){
$url= Url::to(['agrega-indicador-sesion','id'=>$sesion_id,'gridName'=>'indicador_sesion_'.$sesion_id,'idModal'=>'buscarvalor']);
echo  Html::a('<span class="btn-sm fa fa-plus"></span>'.yii::t('sta.labels','Agregar Indicador'), $url, ['class'=>'botonAbre btn btn-success ']);  
//}
Pjax::begin(['id'=>'indicador_sesion_'.$sesion_id]);
 echo GridView::widget([
    'id' => 'kv-grid-demo',
     'summary'=>'',
     'tableOptions' => ['class' => 'table table-striped table-bordered'],
    'dataProvider' =>NEW \yii\data\ActiveDataProvider(
            [
                'query'=> frontend\modules\sta\models\StaIndisesiones::find()->    
                   andWhere(['sesiones_id'=>$sesion_id]),
            ]
            ),
   'columns' => [
       'indicador.nombre',
       'detalles',
       [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}{edit}',
                'buttons' => [
                   'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute([$this->context->id.'/borrar-indicador','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            },
                      
                                    
                       'edit' => function ($url, $model) use($sesion_id) {  
                           $url= Url::to(['edita-indicador-sesion','id'=>$model->id,'gridName'=>'indicador_sesion_'.$sesion_id,'idModal'=>'buscarvalor']);
                            return  Html::button('<span class="fa fa-edit"></span>', ['href' => $url, 'title' => yii::t('sta.labels','Editar'), 'class' => 'botonAbre btn btn-success']); 
                          },
                         
                    ]
                ]
   ], // check the configuration for grid columns by clicking button above
    
   // 'pjax' => true, // pjax is set to always true for this demo
  // 'responsive' => TRUE,
    
]);
  Pjax::end();
?>

</div>
