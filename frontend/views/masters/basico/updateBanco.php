<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sociedades */

$this->title = Yii::t('base.actions', 'Editar: {name}', [
    'name' => $model->nombre,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Bancos'), 'url' => ['bancos']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('base.actions', 'Editar');
?>
<div class="sociedades-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form_banco', [
        'model' => $model,
    ]) ?>

</div>
