<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AccesDocu */

$this->title = Yii::t('base.names', 'Create Acces Docu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Acces Docus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acces-docu-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>