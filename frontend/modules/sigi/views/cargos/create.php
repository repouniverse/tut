<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiCargos */

$this->title = Yii::t('sigi.labels', 'Create Sigi Cargos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Sigi Cargos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-cargos-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>