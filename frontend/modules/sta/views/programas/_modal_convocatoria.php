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
                     // $url= Url::to(['convoca-alumno','id'=>$model->id,'gridName'=>'convocatorias_'.$model->id,'idModal'=>'buscarvalor']);
                      'url'=> \yii\helpers\Url::to(['convoca-alumno','id'=>$id,'gridName'=>'convocatorias_'.$model->id,'idModal'=>'buscarvalor']),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div>
    </div>
     
          <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
              <?=Html::img($modeldet->alumno->urlImage,['width'=>100,'height'=>140])?>
          </div>   
          <div class="col-lg-8 col-md-9 col-sm-6 col-xs-12">
              <?=$form->field($modeldet, 'nombres')->textInput(['disabled'=>true,'value'=>$modeldet->alumno->fullName()])?>
          </div> 
    <div class="col-lg-8 col-md-9 col-sm-6 col-xs-12">
      <?PHP
     echo $form->field($model, 'canal')->dropDownList($model->comboDataField('canal'),
             ['prompt'=>yii::t('sta.labels','--Seleccione un Valor--')]);
      ?>
  </div>
      <div class="col-lg-8 col-md-9 col-sm-6 col-xs-12">
              <?=$form->field($modeldet, 'correo')->textInput(['disabled'=>true,'value'=>$modeldet->alumno->correo])?>
          </div> 
     <div class="col-lg-8 col-md-9 col-sm-6 col-xs-12">
              <?=$form->field($modeldet, 'celulares')->textInput(['disabled'=>true,'value'=>$modeldet->alumno->celulares])?>
          </div> 
          
           <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
      <?= $form->field($model, 'fecha',[/*'enableAjaxValidation' => true*/])->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                       'format' => h::getFormatShowDate(),
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2010:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control']
                            ]) ?>

 </div> 
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?PHP
     echo $form->field($model, 'hora')->widget(TimePicker::classname(), [
         'pluginOptions'=>[
             'showSeconds'=>false,
             'showMeridian'=>false
             ]
     ]);
      ?>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?PHP
     echo $form->field($model, 'resultado')->checkbox();
      ?>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     echo $form->field($model, 'detalle')->textarea();
      ?>
  </div>
          
  <?php ActiveForm::end(); ?>
  
 </div>
   

   
