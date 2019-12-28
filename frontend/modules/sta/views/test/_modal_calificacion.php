<?php
 use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use kartik\widgets\TimePicker;
?>

 <div class="box-body">
    
    <?php $form = ActiveForm::begin(['id'=>'form-calif',
        'fieldClass'=>'\common\components\MyActiveField']); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'form-calif',
                      'url'=> \yii\helpers\Url::to(['/sta/test/agrega-calificacion','id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div>
    </div>
     
   
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <?PHP
     echo $form->field($model, 'valor')->textInput();
      ?>
  </div>
  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <?PHP
     echo $form->field($model, 'descripcion')->textInput();
      ?>
  </div>
     
  
          
  <?php ActiveForm::end(); ?>
  
 </div>
   

   
