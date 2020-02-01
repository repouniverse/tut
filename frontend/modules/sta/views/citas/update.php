<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Citas */

$this->title = Yii::t('sta.labels', 'Edita Cita: {name}', [
    'name' => $model->fechaprog,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Citas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>yii::t('sta.labels', 'Ir a programa').' '.$model->taller->numero, 'url' => ['/sta/programas/update', 'id' => $model->talleres_id]];
$this->params['breadcrumbs'][] = Yii::t('sta.labels', 'Editar');
?>

 <h4> <i class="fa fa-edit"></i><?= Html::encode($this->title) ?>-<?=$model->tallerdet->alumno->fullName().Html::a(Html::img($model->tallerdet->alumno->getUrlImage(),['width'=>60,'height'=>65, 'class'=>"img-thumbnail cuaizquierdo"])) ?></h4>

    <div class="box box-body">
     
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
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Examenes'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_examenes',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Calendario'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_calendario',[ 'model' => $model,'eventos'=>$eventos]),
            'active' => false,
             'options' => ['id' => 'myvyr76wnID4'],
        ],
       
    ],
]);  
?>
</div>