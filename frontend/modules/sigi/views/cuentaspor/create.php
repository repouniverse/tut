<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiCuentaspor */

$this->title = Yii::t('sigi.labels', 'Create Sigi Cuentaspor');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Sigi Cuentaspors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-cuentaspor-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>