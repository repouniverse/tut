<?php
use kartik\tabs\TabsX;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\helpers\h;
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
$this->title = Yii::t('sta.labels', 'Registrar Pc: {name}', [
    'name' => h::request()->getUserIP(),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Programas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('sta.labels', 'Crear');
?>
<div class="talleres-update">

    <h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
 <div class="talleres-form">
    <br>
    <?php $form = ActiveForm::begin( ['enableAjaxValidation'=>true]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton(Yii::t('sta.labels', 'Grabar'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
    
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
  </div>
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field( $modelTaller, 'descripcion')->textInput(['value' => $modelTaller->descripcion,'disabled'=>true]) ?>

 </div>
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'activo')->checkBox() ?>

    <?php ActiveForm::end(); ?>

</div>
    </div>
    

</div>
    </div>