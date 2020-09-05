<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiKardexdepaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-kardexdepa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'facturacion_id') ?>

    <?= $form->field($model, 'operacion_id') ?>

    <?= $form->field($model, 'edificio_id') ?>

    <?= $form->field($model, 'unidad_id') ?>

    <?php // echo $form->field($model, 'mes') ?>

    <?php // echo $form->field($model, 'fecha') ?>

    <?php // echo $form->field($model, 'anio') ?>

    <?php // echo $form->field($model, 'codmon') ?>

    <?php // echo $form->field($model, 'numerorecibo') ?>

    <?php // echo $form->field($model, 'monto') ?>

    <?php // echo $form->field($model, 'igv') ?>

    <?php // echo $form->field($model, 'detalles') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
