<?php
 use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use kartik\widgets\TimePicker;
?>

 <div class="box-body">
    
    <?php $form = ActiveForm::begin(['id'=>'form-inidncaodr',
        'fieldClass'=>'\common\components\MyActiveField']); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'form-inidncaodr',
                      'url'=> \yii\helpers\Url::to([($model->isNewRecord)?'/sta/test/agrega-indicador':'/sta/test/edita-indicador','id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div>
    </div>
     
   
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">   
   <?= $form->field($model, 'grupo')->
            dropDownList(\frontend\modules\sta\helpers\comboHelper::geCboGruposTest($id),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                     
                       ]
                    ) ?>
 </div>  
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?PHP
     echo $form->field($model, 'nemonico')->textInput();
      ?>
  </div>
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     echo $form->field($model, 'nombre')->textInput();
      ?>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     echo $form->field($model, 'texto_bajo')->textarea();
      ?>
  </div>
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     echo $form->field($model, 'texto_medio')->textarea();
      ?>
  </div>
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     echo $form->field($model, 'texto_alto')->textarea();
      ?>
  </div>
  <?php ActiveForm::end(); ?>
  
 </div>
   

   
