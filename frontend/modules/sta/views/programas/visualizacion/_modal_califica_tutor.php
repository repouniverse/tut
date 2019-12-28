<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use kartik\widgets\TimePicker;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="borereuccess">
    
    <?php $form = ActiveForm::begin(['id'=>'form-rango',
        'fieldClass'=>'\common\components\MyActiveField']); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'form-rango',
                      'url'=> \yii\helpers\Url::to(['/sta/programas/califica-alumno','id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div>
    </div>
      <div class="box-body">
          <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
              <?=Html::img($model->alumno->urlImage,['width'=>100,'height'=>140])?>
          </div>   
          <div class="col-lg-8 col-md-9 col-sm-6 col-xs-12">
              <?=$form->field($model, 'nombres')->textInput(['disabled'=>true,'value'=>$model->alumno->fullName()])?>
          </div> 
    <div class="col-lg-8 col-md-9 col-sm-6 col-xs-12">
      <?PHP
     echo $form->field($model, 'rank_tutor')->dropDownList(
             [
             \frontend\modules\sta\helpers\comboHelper::geCboRankTutor(),
                 
                 ], 
             ['prompt'=>'--Seleccione un Valor--']);
      ?>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     echo $form->field($model, 'detalle_tutor')->textarea();
      ?>
  </div>
 
  
 </div>
    <?php ActiveForm::end(); ?>

</div>
    </div>
