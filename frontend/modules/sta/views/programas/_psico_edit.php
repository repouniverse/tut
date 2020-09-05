<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;
 use kartik\date\DatePicker;
 ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
?>

<div class="box box-success">
    <br>
    
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario'/*,'enableAjaxValidation'=>true*/
    ]); ?>
      <div class="box-header">
          <?= $form->errorSummary($model); ?>
        <div class="col-md-12">
            <div class="form-group no-margin">
          <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> \yii\helpers\Url::to(['/sta/programas/edita-taller-psico','id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
       

            </div>
        </div>
    </div>
      <div class="box-body">
  
 

  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
     <?php 
  //Deshabilitar cambio de psicologo cuando aun 
  //falta asinar alumnos, no puede haber cambios de pisologos 
   //cuando todavia no se han aisgnado todos slos alumnos 
   
      echo $form->field($model, 'codtra')->textInput(['disabled'=>true,'value'=>$model->trabajador->fullName()]);
  
    ?>

 </div> 
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
      <?= $form->field($model, 'programar_libre')->checkbox([]) ?>

  </div>

   
 

    <?php ActiveForm::end(); ?>

</div>
    </div>
<script>
    function psico_saves(){
        var $form=$('#myformulario');
       
        $.ajax({
            url:"/frontend/web/sta/programas/agrega-psico?id=35",
            type: 'post',
            data:$form.serialize(),
            success: function(data){
               if(data.success=='1') {
                   if(data.type==1) {
                       $('#buscarvalor').modal('hide');
                       $.pjax.reload('#grilla-staff');
                    }else{
                          $('#buscarvalor').modal('hide');
                      $.pjax.reload('#grilla-staff');
                     }
               }
               if(data.success=='2') {
                   var msg=data.msg;
                   if(msg){
                       $.each(msg,function(key,val){
                           var div=$('.field-'+key);
                           div.addClass(" has-error");
                           div.find('.help-block').html(val);
                       });
                   }
               }
            }
              });
    }
</script>