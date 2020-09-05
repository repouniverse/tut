 <?php
 use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
  use frontend\modules\sta\models\Alumnos;
 use kartik\datetime\DateTimePicker;
 use kartik\export\ExportMenu;
use kartik\editable\Editable;
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;
use yii\widgets\ActiveForm;
use kartik\grid\GridView as grid;
use yii\widgets\Pjax;
use yii\validators\EmailValidator;
//use yii\grid\GridView AS grid;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\StaEventos */
/* @var $form yii\widgets\ActiveForm */
$validator=new EmailValidator;
?>

<div class="sta-eventos-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField',
     
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
              
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('sta.labels', 'Grabar'), ['class' => 'btn btn-success']) ?>
           
            <?PHP
          $isClosed=$model->isClosed();
          IF(!$model->isNewRecord && !$isClosed){
            //echo  Html::button('<span class="fa fa-user-plus"></span>   '.Yii::t('sta.labels', 'Agregar'), ['id'=>'boton_agrega','class' => 'btn btn-warning']);
          
            echo  ($model->isTallerEvaluacion())?Html::button('<span class="fa fa-envelope"></span>   '.Yii::t('sta.labels', 'Mail'), ['id'=>'boton_mail','class' => 'btn btn-success']):'';
            echo  Html::button('<span class="fa fa-lock"></span>   '.Yii::t('sta.labels', 'Cerrar'), ['id'=>'boton_close','class' => 'btn btn-info']);
            echo  Html::button('<span class="fa fa-import"></span>   '.Yii::t('sta.labels', 'Importar Alumnos'), ['id'=>'boton_import','class' => 'btn btn-success']);
            }
             echo  Html::button('<span class="fa fa-refresh"></span>   '.Yii::t('sta.labels', 'Refrescar Indicadores'), ['id'=>'boton_refreshindi','class' => 'btn btn-warning']);
              if(!$model->isNewRecord){
                  echo common\widgets\auditwidget\auditWidget::widget(['model'=>$model]); 
              }
              
             
                  ?>  
     

            </div>
        </div>
    </div>
      <div class="box-body">
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model->talleres, 'numero')->textInput(['disabled' => true])->label('Número Programa') ?> 

 </div>
  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
     <?= $form->field($model->talleres, 'descripcion')->textInput(['maxlength' => true,'disabled' => true])->label('Nombre Programa') ?>

 </div> 
 
 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['maxlength' => true,'disabled' => true]) ?>

 </div>
  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
       <?= $form->field($model, 'tipo')->
            dropDownList(\frontend\modules\sta\helpers\comboHelper::getCboFlujoEventos(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                  
                    //  'disabled'=>($isClosed)?true:false,
                        ]
                    ) ?>
 </div>        
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?= $form->field($model, 'codtra')->
            dropDownList(\frontend\modules\sta\helpers\comboHelper::getCboTutoresByProg($model->talleres_id),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div> 
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
   
   <?php if(!$model->hasChilds()){
       echo $form->field($model, 'fechaprog',['enableAjaxValidation'=>true])->widget(
   
        DateTimePicker::classname(), [
         'name' => 'finicio',
            'language' => h::app()->language,
            'options' => ['placeholder' =>yii::t('sta.labels', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDateTime(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
   }else{
     echo $form->field($model, 'fechaprog')->textInput(['disabled'=>true]);
     
   }
                ?>
 </div>

 
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?= $form->field($model, 'grupo')->
            dropDownList(['A'=>'Primer Grupo','B'=>'Segundo Grupo','C'=>'Tercer Grupo','D'=>'Cuarto Grupo'],
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div> 
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?php
    if($model->isTallerEvaluacion()){  
          // echo $this->render('grilla_ev_inicial', ['dataProvider'=>$dataProvider,'validator'=>$validator,'model'=>$model,'searchModel' => $searchModel]); 
               }else{/* Si trata de un taller    */
                   
          echo $form->field($model, 'objetivo')->textArea(['rows'=>2]);           
                   
          // echo $this->render('grilla_taller', ['dataProvider'=>$dataProvider,'validator'=>$validator,'model'=>$model,'searchModel' => $searchModel]); 
              }
    
    /*echo $form->field($model, 'semana')->
            dropDownList(common\helpers\timeHelper::semanas(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )*/ ?>
 </div>  
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <?= \common\widgets\imagewidget\ImageWidget::widget([
        'name'=>'imagenrep',
        'isImage'=>false,  
        'model'=>$model,
        'extensions'=>['csv'],
            ]); ?>
   </div> 
 </div>
     
    <?php ActiveForm::end(); ?>
    
  <?php 
               if($model->hasAttachments()){
                        //var_dump($model->testTalleres);
                        echo Html::a('Descargar adjunto', $model->files[0]->getUrl(), ['data-pjax'=>'0']);      
                     
                    }
  ?>  
    
</div>
    </div>   
    <?php  if(!$model->isNewRecord){  ?>
      <?php  
      /**Si el evento trata de una evaluancion*/
      if($model->isTallerEvaluacion()){  
           echo $this->render('grilla_ev_inicial', ['dataProvider'=>$dataProvider,'validator'=>$validator,'model'=>$model,'searchModel' => $searchModel]); 
               }else{/* Si trata de un taller    */
           echo $this->render('grilla_taller', ['dataProvider'=>$dataProvider,'validator'=>$validator,'model'=>$model,'searchModel' => $searchModel]); 
              }
           ?>

    <?php  }  ?>
<?php
$string="$('#boton_agrega').on( 'click', function(){ 
       $.ajax({
              url: '".Url::to(['/sta/eventos/agrega-alumnos','id'=>$model->id])."', 
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
                       $.pjax.reload({container: '#grupo-pjax'});
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
  $this->registerJs($string, \yii\web\View::POS_END);
?>
    
<?php
$string2="$('#boton_mail').on( 'click', function(){ 
       $.ajax({
              url: '".Url::to(['/sta/eventos/notifica-por-correo','id'=>$model->id])."', 
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
                       $.pjax.reload({container: '#grupo-pjax'});
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
  $this->registerJs($string2, \yii\web\View::POS_END);
?>
   
<?php
$string3="$('#boton_close').on( 'click', function(){ 
       $.ajax({
              url: '".Url::to(['/sta/eventos/cierra-evento','id'=>$model->id])."', 
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
                       $.pjax.reload({container: '#grupo-pjax'});
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
  $this->registerJs($string3, \yii\web\View::POS_END);
?>
    
<?php
$string4="$('#boton_import').on( 'click', function(){ 
       $.ajax({
              url: '".Url::to(['/sta/eventos/load-alumnos','id'=>$model->id])."', 
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
                       $.noty.setType(n.options.timeout, 10000); 
                       $.pjax.reload({container: '#grupo-pjax',async:false});
                       $.pjax.reload({container: '#mi_maletin',async:false});
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
  $this->registerJs($string4, \yii\web\View::POS_END);
?>
    
  <?php
$string5="$('#boton_refreshindi').on( 'click', function(){ 
       $.ajax({
              url: '".Url::to(['/sta/eventos/refrescar-indicador','id'=>$model->id])."', 
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
                       $.noty.setType(n.options.timeout, 10000); 
                       $.pjax.reload({container: '#grupo-pjax',async:false});
                       $.pjax.reload({container: '#mi_maletin',async:false});
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
  $this->registerJs($string5, \yii\web\View::POS_END);
?>  
    
<?php
IF(!$model->isNewRecord && !$isClosed){
 $url= Url::to(['agrega-alumno-solo','id'=>$model->id,'gridName'=>'grupo-pjax','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar Alumno'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Alumno'),'id'=>'btn_contacts', 'class' => 'botonAbre btn btn-success']); 
} ?>