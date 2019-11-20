<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Edificios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="edificios-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Yii::t('sigi.labels', 'Editar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
      
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codtra',
            'nombre',
            'latitud',
            'meridiano',
            'proyectista',
            'tipo',
            'npisos',
            'detalles:ntext',
            'codcen',
            'direccion',
            'coddepa',
            'codprov',
        ],
    ]) ?>

</div>
