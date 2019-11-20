<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sociedades */

$this->title = Yii::t('base.actions', 'Crear colaborador');
$this->params['breadcrumbs'][] = ['label' => Yii::t('control.errors', 'Colaboradores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sociedades-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

