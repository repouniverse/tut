<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\StaEventos */

$this->title = Yii::t('sta.labels', 'Crear evento');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Sta Eventos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sta-eventos-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>