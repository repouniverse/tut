<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\PlantillaCorreos */

$this->title = Yii::t('base.names', 'Create Plantilla Correos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Plantilla Correos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plantilla-correos-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>