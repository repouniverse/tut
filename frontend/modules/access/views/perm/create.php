<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\access\models\AccessModelPermiso */

$this->title = Yii::t('sta.labels', 'Create Access Model Permiso');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Access Model Permisos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-model-permiso-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,'modelos'=>$modelos
    ]) ?>

</div>
</div>