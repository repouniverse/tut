<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Citas */

$this->title = Yii::t('sta.labels', 'Create Citas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Citas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citas-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>