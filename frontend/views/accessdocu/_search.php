<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AccesDocuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acces-docu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'modelo') ?>

    <?= $form->field($model, 'codocu') ?>

    <?= $form->field($model, 'rol') ?>

    <?= $form->field($model, 'campo') ?>

    <?php // echo $form->field($model, 'campo_profile') ?>

    <?php // echo $form->field($model, 'upload') ?>

    <?php // echo $form->field($model, 'download') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('base.names', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('base.names', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
