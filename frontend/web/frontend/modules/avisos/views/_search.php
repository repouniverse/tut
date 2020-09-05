<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\avisos\models\AvisosTablonSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="avisos-tablon-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'finicio') ?>

    <?= $form->field($model, 'ftermino') ?>

    <?= $form->field($model, 'texto') ?>

    <?php // echo $form->field($model, 'texto_interno') ?>

    <?php // echo $form->field($model, 'esevento') ?>

    <?php // echo $form->field($model, 'activo') ?>

    <?php // echo $form->field($model, 'periodo') ?>

    <?php // echo $form->field($model, 'user_admin') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('base.names', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('base.names', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
