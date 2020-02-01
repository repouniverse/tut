<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title =yii::t('base.verbs','Request password reset');
$this->params['breadcrumbs'][] = $this->title;
?>
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
<div class="box box-success">
<div class="site-reset-password">
    <h3><?= Html::encode($this->title) ?></h3>

    <p><?=yii::t('base.verbs','Por favor escriba su nueva contrasena')?></p>

    <div class="row">
         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
    </div>
</div>