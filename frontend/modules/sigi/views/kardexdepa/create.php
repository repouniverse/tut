<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiKardexdepa */

$this->title = Yii::t('app', 'Create Sigi Kardexdepa');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sigi Kardexdepas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-kardexdepa-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>