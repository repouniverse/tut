<?php
 use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
 use yii\widgets\Pjax;
 use yii\grid\GridView;
 use yii\helpers\Html;
  use yii\helpers\Url;
 use frontend\modules\sta\models\ExamenesSearch;
?>
<div>
     <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <div class="row">
             
                   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= Html::dropDownList("combo_test_bateria",null,
          frontend\modules\sta\helpers\comboHelper::baterias(),
            ['prompt'=>'--Seleccione un Valor--',
             'class'=>'form-group form-control',
                'id'=>'combo_test_bateria'])  ?>
                </div>
                  <div class="btn-group">
               <?php Pjax::begin(['id'=>'botones-examenes']); ?>
             <?=($model->asistio && !$vencida)?\yii\helpers\Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Agregar batería'), ['class' => 'btn btn-info','href' => '#','id'=>'btn-add-bateria']):''?>
          
               
                
         <?php /*$url= \yii\helpers\Url::to(['agrega-examen','id'=>$model->id,'gridName'=>'grilla-examenes','idModal'=>'buscarvalor']);*/?>
       <?php /* echo ($model->asistio)?\yii\helpers\Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Agregar evaluacion'), ['href' => $url,'id'=>'btn-add-test','class' => 'botonAbre btn btn-warning']):''*/?>
         <?php /*echo ($model->asistio)?\yii\helpers\Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Refrescar Preguntas'), ['id'=>'boton_bateria','class' => 'btn btn-warning']):''*/?> 
 <?=($model->asistio && !$vencida)?\yii\helpers\Html::button('<span class="fa fa-envelope"></span>   '.Yii::t('sta.labels', 'Notificar'), ['id'=>'boton_notifica','class' => 'btn btn-warning']):''?>  
            <?php Pjax::end(); ?>
               </div>
                </div>
            </div>
        </div>
    </div> 
    
   <?php Pjax::begin(['id'=>'grilla-examenes']); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'id'=>'grid-examenis',
        'dataProvider' =>(new ExamenesSearch())->searchByTaller($model->id),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                 [ 
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{attach}{delete}',
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
                            },
                        'edit' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute([$this->context->id.'/edita-examen','id'=>$model->id,'gridName'=>'grilla-examenes','idModal'=>'buscarvalor']);

                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-pencil"></span>', $url, ['class'=>'botonAbre']);
                            } 
                    ]
                ],
            'codtest',
              [
              'attribute' => '',
               'format'=>'raw',
                'value' => function ($model) {
                   // if($model->testTalleres->hasAttachments()){
                        //var_dump($model->testTalleres);
                       // return Html::a($model->test->descripcion, $model->testTalleres->files[0]->getUrl(), ['data-pjax'=>'0']);      
                     
                    //}else{
                       return $model->test->descripcion ;
                    //}
                   },
                    ],
                [
              'attribute' => 'detalles',
               //'format'=>'raw',
                'value' => function ($model) {
                    return substr($model->detalles,0,30).'...';
                   },
                    ],
                [
              'attribute' => '',
               'format'=>'raw',
                'value' => function ($model) {
                          $tieneFile= $model->countFiles();
                       IF($tieneFile>0){
                           return Html::a('<span class="btn btn-success glyphicon glyphicon-download"></span>', $model->files[0]->getUrl(), ['data-pjax'=>'0']);
                       }else{
                           return '';
                       }
                    },
                    ],
                             [
              'attribute' => '',
               'format'=>'raw',
                'value' => function ($model) {
                        $porc= $model->porcentajeAvance();
                       IF($porc <100){
                           return '<span class="label label-danger">'.$porc.'%</span>';
                       }else{
                           return '<i style="color:green;"><span class="fa fa-check"></span></i>';
                       }
                    },
                    ],
                  ['class' => 'frontend\modules\report\components\columnGridReport',
                   'attribute'=>'report_id']           
        ],
    ]); ?>
    
     <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla-examenes',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
       'posicion'=>\yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
    
       <?php Pjax::end(); ?> 
 
    
    <?php 
  $string="$('#boton_bateria').on( 'click', function(){ 
     
       $.ajax({
              url: '".Url::to(['/sta/citas/banco-preguntas','id'=>$model->id])."', 
              type: 'get',
              data:{id:".$model->id.",pruebas:". \yii\helpers\Json::encode($model->codExamenes())." },
              dataType: 'json', 
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

                             if ( !(typeof json['warning']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['warning']);
                              $.noty.setType(n.options.id, 'warning');  
                             } 
                          if ( !(typeof json['success']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['success']);
                              $.noty.setType(n.options.id, 'success');  
                             }      
                   
                        }
                        });


             })";
  //echo $string;
$string2="$('#boton_notifica').on( 'click', function(){ 
     
       $.ajax({
              url: '".Url::to(['/sta/citas/notifica-banco-digital','id'=>$model->id])."', 
              type: 'get',
              data:{idalu:".$model->tallerdet->alumno->id." },
              dataType: 'json', 
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

                             if ( !(typeof json['warning']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['warning']);
                              $.noty.setType(n.options.id, 'warning');  
                             } 
                          if ( !(typeof json['success']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['success']);
                              $.noty.setType(n.options.id, 'success');  
                             }      
                   
                        }
                        });


             })";

$string3="$('#btn-add-bateria').on( 'click', function(){ 
     var vbateria=$('#combo_test_bateria').val();
     
       $.ajax({
              url: '".Url::to(['/sta/citas/agrega-bateria','id'=>$model->id])."', 
              type: 'get',
              data:{bateria:vbateria},
              dataType: 'json', 
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

                             if ( !(typeof json['warning']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['warning']);
                              $.noty.setType(n.options.id, 'warning');  
                             } 
                          if ( !(typeof json['success']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['success']);
                              $.noty.setType(n.options.id, 'success');  
                             }      
                   
                        }
                        });


             })";


$string4="$('#boton_procesa').on( 'click', function(){ 
     
     
       $.ajax({
              url: '".Url::to(['/sta/citas/resultados','id'=>$model->id])."', 
              type: 'get',
              data:{id:".$model->id."},
              dataType: 'json', 
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

                             if ( !(typeof json['warning']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['warning']);
                              $.noty.setType(n.options.id, 'warning'); 
                              $.pjax.reload({container: '#botones-examenes'});
                             } 
                          if ( !(typeof json['success']==='undefined' )) {
                         
                         
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-ok\'></span>      '+ json['success']);
                             
                            $.noty.setType(n.options.id, 'success');  
                               
                             }      
                   
                        }
                        });


             })";
  $this->registerJs($string, \yii\web\View::POS_END);
  $this->registerJs($string2, \yii\web\View::POS_END);
   $this->registerJs($string3, \yii\web\View::POS_END);
   // $this->registerJs($string4, \yii\web\View::POS_END);
?>
    
    
  
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</div>