<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Alumnos */
/* @var $form yii\widgets\ActiveForm */
?>
<h4><span class="fa fa-search"></span><?='   '.yii::t('sta.labels','Datos adicionales').'   : '.$model->fullName()?></h4>
<div class="box box-success">
    
      
      <div class="box-body">
  <?=$this->render('_form_view_alu_basico',['model'=>$model]);?>
          
          
          
   <?php 
   if(count($dataProviders)>0){
       echo $this->render('_tabs',['model'=>$model,
                'dataProviders'=>$dataProviders,
            'examenes'=>$examenes,
           'citasArray'=> $citasArray,
                'modelTallerdet'=>$modelTallerdet,
                'codperiodo'=>$codperiodo]);
   }else{
       ?>
          <div class="alert alert-info"><?=yii::t('sta.labels','Este alumno no presenta riesgo academico')?></div>      
    <?php
   }
   
     ?>       
          
          
</div>
    </div>
