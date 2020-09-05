<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
<div></div>
<?php
if(!$model->unidad->imputable){
                 
 //$url= Url::to(['/sigi/edificios/fill-afiliados','id'=>$model->id,'gridName'=>'grilla-lecturas','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Llenar afiliados'), ['title' => yii::t('sta.labels','Llenar afiliados'),'id'=>'btn_afiliados', 'class' => 'btn btn-success']); 
 
}

?>
  <?php    $this->registerJs("
         
$('#btn_afiliados').on( 'click', function(){    
  $.ajax({ 
  
   method:'get',    
      url: '".\yii\helpers\Url::toRoute(['/sigi/unidades/llena-afiliados','id'=>$model->id])."',
   delay: 250,
 data: {id:".$model->id."},
             error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(json) {  
                        var n = Noty('id');
                       if ( !(typeof json['error']==='undefined') ) {
                                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error'); 
                              }
                         if ( !(typeof json['success']==='undefined') ) {
                                        $.noty.setText(n.options.id, json['success']);
                             $.noty.setType(n.options.id, 'success');
                              } 
                               if ( !(typeof json['warning']==='undefined') ) {
                                        $.noty.setText(n.options.id, json['warning']);
                             $.noty.setType(n.options.id, 'warning');
                              } 
                              //$.pjax.defaults.timeout = false;  
                        //$.pjax.reload({container: '#grilla-lecturas'});
                        },
   cache: true
  })
 }
 
);",\yii\web\View::POS_END);  
  ?>

 <?php 
       $gridColumns = [
                         
[  'attribute' => 'unidad',
    'format'=>'raw',
    'value' => function ($model, $key, $index, $column) {
                    return $model->unidad->numero;
                        }
],
 
[
 'attribute' => 'afiliado',
'format' => 'raw',
 'value' => function ($model) {
return \yii\helpers\Html::checkbox('afiliado[]', $model->afiliado, [ 'class' =>'holas','title'=>Url::to(['/sigi/unidades/desafiliar','id'=>$model->id])]);
 },
],

];
     Pjax::begin(['id'=>'grid-afiliados']); 
        echo GridView::widget([
           //  'id' => 'grid-afiliados',
        'dataProvider' => $model->providerAfiliados(),
         //'summary' => '',
        // 'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => $gridColumns,
           //  'pjax' => true, // pjax is set to always true for this demo
            //'toggleDataContainer' => ['class' => 'btn-group mr-2'],
           /* 'panel' => [
        'type' => GridView::TYPE_WARNING,
        //'heading' => $heading,
    ],*/
    
    ]);
        //Pjax::end();
        ?>
<?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgridBanggcos',
            'idGrilla'=>'grid-afiliados',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
  <?php Pjax::end(); ?>   