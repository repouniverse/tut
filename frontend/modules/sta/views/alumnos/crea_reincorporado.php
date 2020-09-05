<?php

use yii\helpers\Html;


 //use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Alumnos */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('base.names', 'Editar Reincorporación');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Programas'), 'url' => ['programas/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Alumnos'), 'url' => ['alumnos/index']];
$this->params['breadcrumbs'][] =['label' => Yii::t('base.names', 'Alumnos Incorporados'), 'url' => ['alumnos/alumnos-riesgo']];
?>
<h4><?=yii::t('sta.labels','Crear '.$verbo)?></h4>
<div class="alumnos-form">
   <div class="box box-body">
    <?PHP echo $this->render('_form_incorporado',['model'=>$model]);  ?>

</div>
    </div>
