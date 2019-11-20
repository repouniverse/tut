<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Trabajadores */

$this->title = Yii::t('base.actions', 'Crear Banco');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Bancos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trabajadores-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form_banco', [
        'model' => $model,
    ]) ?>

</div>

