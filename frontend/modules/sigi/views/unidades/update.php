<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiUnidades */

$this->title = Yii::t('sigi.labels', 'Editar : {name}', [
    'name' => $model->nombre,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sigi.labels', 'Unidades'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('sigi.labels', 'Update');
?>
<div class="sigi-unidades-update">
    <h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>
   
<div class="box box-success">
    
    <?php echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
          'label'=>'<i class="fa fa-home"></i> '.yii::t('sta.labels','Principal'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_form',['model' => $model]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-cubes"></i> '.yii::t('sta.labels','Residentes'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_residentes',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'wnID4'],
        ],
       [
          'label'=>'<i class="fa fa-cubes"></i> '.yii::t('sta.labels','Puntos de medida'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_medidores',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myvw456'],
        ],
       [
          'label'=>'<i class="fa fa-cubes"></i> '.yii::t('sta.labels','Adjuntos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_hijos',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myrerw456'],
        ], 
       
    ],
]);  
?>
</div>
</div>