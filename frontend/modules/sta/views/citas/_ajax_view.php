<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\sta\widgets\cbofacultades\cbofacultades;
use frontend\modules\sta\widgets\cboperiodos\cboperiodos;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;
 use kartik\date\DatePicker;
   use kartik\time\TimePicker;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="borereuccess">
   
    <?php 
 if($model->asistio) {  
    $tipo=h::user()->profile->tipo;
     //$canti=$model->countStudentsFree();
    $form = ActiveForm::begin(['id'=>'form-programa',
        'fieldClass'=>'\common\components\MyActiveField']); ?>
    
 
 
    
     <?php if($model->isVisibleField('detalles_secre', $tipo)){  ?>
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?php /*echo $form->field($model, 'detalles_secre')->textArea(['rows' => 4,'disabled'=>!$model->isEditableField( 'detalles_secre', $tipo)]);*/ ?>
      <?php echo $form->field($model, 'detalles_secre')->textArea(['rows' => 4,'disabled'=>true,'value'=>strip_tags(trim($model->detalles_secre))]); ?> 
  </div>
 <?php } ?>
     <?php if($model->isVisibleField('detalles', $tipo)){  ?>
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?php /*echo $form->field($model, 'detalles_secre')->textArea(['rows' => 4,'disabled'=>!$model->isEditableField( 'detalles_secre', $tipo)]);*/ ?>
      <?php echo $form->field($model, 'detalles')->textArea(['rows' => 4,'disabled'=>true]); ?> 
  </div>
 <?php } ?>
  <?php if($model->isVisibleField('detalles_tareas_pend', $tipo)){  ?>
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
     <?php /*echo $form->field($model, 'detalles_secre')->textArea(['rows' => 4,'disabled'=>!$model->isEditableField( 'detalles_secre', $tipo)]);*/ ?>
      <?php echo $form->field($model, 'detalles_tareas_pend')->textArea(['rows' => 4,'disabled'=>true]); ?> 
  </div>
 <?php } ?>  
    
    
    <?php ActiveForm::end(); ?>
   <?php  }   ?>
   
    <?php if($model->asistio) { ?>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php echo $this->render('_indicadores',['model'=>$model,'simple'=>true]);      ?>  
    </div>
    <?php } ?>
     <?php if($model->nReprogramaciones() > 0) { ?>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php echo $this->render('_reprogramaciones',['model'=>$model]);      ?>    
    </div>
     <?php } ?>
</div>
    </div>
