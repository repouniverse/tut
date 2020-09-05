<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HelpAyuda */

$this->title = Yii::t('base.names', 'Create Help Ayuda');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Help Ayudas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="help-ayuda-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>