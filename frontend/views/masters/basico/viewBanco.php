<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Sociedades */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Bancos'), 'url' => ['bancos']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sociedades-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('base.actions', 'Editar'), ['editar-banco', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codbanco',           
            'nombre',
        ],
    ]) ?>

</div>
