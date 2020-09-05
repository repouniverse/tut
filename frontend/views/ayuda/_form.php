<?php
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $model common\models\HelpAyuda */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="help-ayuda-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('base.names', 'Save'), ['class' => 'btn btn-success']) ?>
        <?php if(!$model->isNewRecord){
                  echo common\widgets\auditwidget\auditWidget::widget(['model'=>$model]); 
              }  
           ?>
            </div>
        </div>
    </div>
      <div class="box-body">
    
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'ticket')->textInput(['disabled'=>true]);?>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'tipo')->
            dropDownList($model::comboDataField('tipo'),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                    //'disabled'=>($model->isNewRecord)?'disabled':null,
                        ]
                    ) ?>
 </div>  
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'user_id')->textInput(['disabled'=>true,'value'=>($model->isNewRecord)?$model->usuario:h::getNameUserById($model->user_id)]) ?>

 </div>
  
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?php 
      
        echo $form->field($model, 'fecha_hora')->widget(
        DateTimePicker::classname(), [
         'name' => 'fecha_hora',
            'language' => h::app()->language,
            'options' => ['placeholder' =>yii::t('sta.labels', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDateTime(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
         ?>
  </div>
  <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
     <?= $form->field($model, 'problema')->textInput(['maxlength' => true]) ?>

 </div>
  
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea(['rows' => 6]) ?>

 </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'respuesta')->textarea(['rows' => 6, 'disabled'=>($model->isNewRecord)?true:false]) ?>

 </div>         

 
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'fecha_respuesta')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'satisfaccion')->
            dropDownList($model::comboDataField('satisfaccion'),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                    //'disabled'=>($model->isNewRecord)?'disabled':null,
                        ]
                    ) ?>
 </div>        
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
