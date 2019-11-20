<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Sociedades */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sociedades-form">
<div class="box box-success">

    <?php $form = ActiveForm::begin([
    'id' => 'bancos-form',
    //'enableAjaxValidation' => true,
    'fieldClass' => 'common\components\MyActiveField',
    //'options'=>['enctype' => 'multipart/form-data'],'fieldClass' => '\common\components\MyActiveField'
    ]); ?>
    
    
    <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                <?= Html::submitButton(Yii::t('base.verbs', 'Grabar'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    
    
    
    <div class="box-body">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'codbanco')->textInput([]) ?>
  </div>
    <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
    
    <?= $form->field($model, 'nombre')->textInput() ?>
</div>
    

    
   
    <?php ActiveForm::end(); ?>
</div>

</div>
