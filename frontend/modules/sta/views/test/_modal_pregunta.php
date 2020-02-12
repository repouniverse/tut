<?php
 use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use kartik\widgets\TimePicker;
?>

 <div class="box-body">
    
    <?php $form = ActiveForm::begin(['id'=>'form-convojgjgcatoria',
        'fieldClass'=>'\common\components\MyActiveField']); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'form-convojgjgcatoria',
                      'url'=> \yii\helpers\Url::to([($model->isNewRecord)?'/sta/test/agrega-pregunta':'/sta/test/edita-pregunta','id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div>
    </div>
     
   
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-4">
      <?PHP
     echo $form->field($model, 'grupo')->textInput();
      ?>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?PHP
     echo $form->field($model, 'item')->textInput();
      ?>
  </div>
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     echo $form->field($model, 'pregunta')->textarea();
      ?>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     echo $form->field($model, 'inversa')->checkbox();
      ?>
  </div>
          
  <?php ActiveForm::end(); ?>
  
 </div>
   

   
