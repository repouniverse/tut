<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\CitasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="citas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'talleresdet_id') ?>

    <?= $form->field($model, 'talleres_id') ?>

    <?= $form->field($model, 'fechaprog') ?>

    <?= $form->field($model, 'codtra') ?>

    <?php // echo $form->field($model, 'finicio') ?>

    <?php // echo $form->field($model, 'ftermino') ?>

    <?php // echo $form->field($model, 'fingreso') ?>

    <?php // echo $form->field($model, 'detalles') ?>

    <?php // echo $form->field($model, 'codaula') ?>

    <?php // echo $form->field($model, 'duracion') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('sta.labels', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('sta.labels', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
