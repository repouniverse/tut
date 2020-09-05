<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\selectwidget\selectWidget;
//use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
//use common\helpers\ComboHelper;
use common\helpers\h;
 //use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Alumnos */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('base.names', 'Editar Reincorporación');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Programas'), 'url' => ['programas/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Alumnos'), 'url' => ['alumnos/index']];
//$this->params['breadcrumbs'][] =['label' => Yii::t('base.names', 'Alumnos Incorporados'), 'url' => ['alumnos/incorporados']];
?>
<h4><?=yii::t('sta.labels','Reincorporar Alumno')?></h4>
<div class="alumnos-form">
   <div class="box box-body">
    <?PHP echo $this->render('_form_incorporado',['model'=>$model]);  ?>

</div>
    </div>
