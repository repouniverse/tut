<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiCuentasporSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-cuentaspor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'edificio_id') ?>

    <?= $form->field($model, 'codocu') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'fedoc') ?>

    <?php // echo $form->field($model, 'mes') ?>

    <?php // echo $form->field($model, 'anio') ?>

    <?php // echo $form->field($model, 'detalle') ?>

    <?php // echo $form->field($model, 'fevenc') ?>

    <?php // echo $form->field($model, 'monto') ?>

    <?php // echo $form->field($model, 'igv') ?>

    <?php // echo $form->field($model, 'codestado') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('sigi.labels', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('sigi.labels', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
