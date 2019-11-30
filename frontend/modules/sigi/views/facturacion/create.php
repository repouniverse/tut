<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiFacturacion */

$this->title = Yii::t('sigi.labels', 'Crear Facturacion');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Registros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-facturacion-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>