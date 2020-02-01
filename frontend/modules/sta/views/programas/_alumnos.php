<?php

use yii\helpers\Html,yii\helpers\Url;
 //use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use kartik\editable\Editable;
//use kartik\grid\GridView ;
use frontend\modules\sta\helpers\comboHelper;

?>


<button id="boton-refrescar" type="button" class="btn btn-warning btn-lg">
    <span class="glyphicon glyphicon-refresh"></span><?=yii::t('sta.labels','  Actualizar lista')?>
</button>


    <div class="box-body">
  
    <?php // echo $thigrids->render('_search', ['model' => $searchModel]); ?>

    
    <div style='overflow:auto;'>
   <?php 
    Pjax::begin(['id'=>'sumilla']);
   ////$dataTutores= comboHelper::getCboTutoresByProg($model->id);
   //print_r($dataTutores);die();
   $gridColumns = [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{edit}',
                'buttons' => [
                   
                         'view' => function ($url,$model) {
                            $status=$model->statusContact();
                            if($status== frontend\modules\sta\models\Talleresdet::CONTACTO_CON_CITA) {
                              //$url= Url::to(['convoca-alumno','id'=>$model->id,'gridName'=>'convocatorias_'.$model->id,'idModal'=>'buscarvalor']);
                              //return Html::a('<span class="btn btn-danger btn-sm fa fa-phone"></span>', $url, ['class'=>'botonAbre']);
                             return '<span class="btn btn-'.$status.' btn-sm fa fa-phone"></span>';
                                
                            }else{
                               $url= Url::to(['convoca-alumno','id'=>$model->id,'gridName'=>'convocatorias_'.$model->id,'idModal'=>'buscarvalor']);
                              return Html::a('<span class="btn btn-'.$status.' btn-sm fa fa-phone"></span>', $url, ['class'=>'botonAbre']);  
                             }
			    },
                            
                            'edit' => function ($url,$model) {
			    $url= Url::to(['cambio-psicologo-alumno','id'=>$model->id,'gridName'=>'grilla-staff','idModal'=>'buscarvalor']);
                             //echo  Html::button(yii::t('base.verbs','Modificar Rangos'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Tutor'),'id'=>'btn_contacts', 'class' => 'botonAbre btn btn-success']); 
                            return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-pencil"></span>', $url, ['class'=>'botonAbre']);
                            },
                    ]
                ],
        [
    'class' => 'kartik\grid\ExpandRowColumn',
    'width' => '50px',
    'value' => function ($model, $key, $index, $column) {
        return GridView::ROW_COLLAPSED;
    },
    // uncomment below and comment detail if you need to render via ajax
    // 'detailUrl'=>Url::to(['/site/book-details']),
    'detail' => function ($model, $key, $index, $column) {
        return Yii::$app->controller->renderPartial('/programas/convocatorias/_convocatorias',  ['grupo_id' => $model->id]);
    },
    'headerOptions' => ['class' => 'kartik-sheet-style'], 
    'expandOneOnly' => true
],                    
                            
[  'attribute' => 'cantidad',
    'format'=>'raw',
    'value' => function ($model, $key, $index, $column) {
                    $options=['id'=>$model->codalu,
                              'class'=>'class_link_ajax'
                               ];
                    return Html::a('<span class="badge badge-danger">'.$model->cantidad.'</span>', '#', $options);
                        }
],
 [  'attribute' => '%Asis',
    'format'=>'raw',
    'value' => function ($model, $key, $index, $column) {
                    return $model->porcentajeAsistencias().'%';
                        }
],
[  'attribute' => 'ap',
],
[  'attribute' => 'nombres', 
],         
[
                'attribute'=>'codalu',
                'format'=>'raw',
                'value' => function ($model, $key, $index, $column) {
                    $options=['id'=>$model->codalu,
                              //'class'=>'class_link_ajax'
                               'data-pjax'=>'0',
                                'target'=>'_blank'
                               ];
                    $url=\yii\helpers\Url::to(['programas/trata-alumno','id'=>$model->id,'idalumno'=>$model->idalumno,'codperiodo'=>$model->codperiodo,'codalu'=>$model->codalu]);
                    if(!empty($model->codtra)){
                        return Html::a($model->codalu,$url, $options);
                    }else{
                        return $model->codalu;
                    }
                    
                        },
],
[ 
    'attribute' => 'codtra', 
],
       [ 
    'attribute' => 'celulares', 
],
                                  [ 
    'attribute' => 'correo', 
],
];
   
   
   
   
   ?>
        <?php 
       
        echo GridView::widget([
             'id' => 'kv-grid-demo',
        'dataProvider' => $dataProviderAlumnos,
         //'summary' => '',
        // 'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchAlumnos,
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
        
    
    </div>
    

  
  <?php    $this->registerJs("
         
$('#boton-refrescar').on( 'click', function(){    
  $.ajax({ 
  
   method:'post',    
      url: '".\yii\helpers\Url::toRoute('/sta/programas/refresca-alumnos')."',
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
                              $.pjax.defaults.timeout = false;  
                       // $.pjax.reload({container: '#grilla-minus'});
                        },
   cache: true
  })
 }
 
);",\yii\web\View::POS_END);  
  ?>
<?PHP
 Pjax::end();
?>
    </div>