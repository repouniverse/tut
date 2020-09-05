<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\avisos\models\AvisosTablon */

$this->title = Yii::t('base.names', 'Create Avisos Tablon');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Avisos Tablons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="avisos-tablon-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>