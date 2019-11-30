<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiFacturacion */

$this->title = $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Registro'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sigi-facturacion-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Yii::t('sigi.labels', 'Editar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'edificio_id',
            'mes',
            'ejercicio',
            'fecha',
            'descripcion',
            'detalles:ntext',
        ],
    ]) ?>

</div>
