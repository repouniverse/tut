<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Citas */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Citas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="citas-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Yii::t('sta.labels', 'Editar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'talleresdet_id',
            'talleres_id',
            'fechaprog',
            'codtra',
            'finicio',
            'ftermino',
            'fingreso',
            'detalles:ntext',
            'codaula',
            'duracion',
        ],
    ]) ?>

</div>
