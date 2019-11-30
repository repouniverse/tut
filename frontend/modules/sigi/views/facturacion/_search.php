<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiFacturacionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-facturacion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'edificio_id') ?>

    <?= $form->field($model, 'mes') ?>

    <?= $form->field($model, 'ejercicio') ?>

    <?= $form->field($model, 'fecha') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'detalles') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('sigi.labels', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('sigi.labels', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
