<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Alumnos */
/* @var $form yii\widgets\ActiveForm */
?>
<h4><span class="fa fa-search"></span><?='   '.yii::t('sta.labels','Datios adicionales').'   : '.$model->fullName()?></h4>
<div class="box box-success">
     <?php $form = ActiveForm::begin(); ?>
      
      <div class="box-body">
        <?php //print_r($model->attributes);var_dump($model->facultad); die(); ?>

  <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
     <?= Html::label(yii::t('base.names','Facultad'),'45545rret',['class' => 'control-label']) ?>
           <?php if( $model->hasProperty('facultad')){ ?>
            <?=  Html::input('text', 'namefacu', $model->facultad->desfac,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php } else { ?>
            <?=  Html::input('text', 'namefacu', $model->desfac,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php }  ?>
 </div>
  
   <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
     <?= Html::label(yii::t('base.names','Carrera'),'4u5545rret',['class' => 'control-label']) ?>
     <?php if( $model->hasProperty('carrera')){ ?>
            <?=  Html::input('text', 'namefacxu', $model->carrera->descar,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php } else { ?>
            <?=  Html::input('text', 'namefacxu', $model->descar,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php }  ?>
 </div>
   
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
       <?= $form->field($model, 'nombres')->textInput(['value' =>$model->fullName(),'disabled' => 'disabled']) ?>

   </div>
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                  <img src="<?=$model->getUrlImage()?>" width="120" height="120" class="img-thumbnail">
  </div>
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
 <?php  //h::settings()->invalidateCache();  ?>
 <?= $form->field($model, 'codalu')->textInput(['disabled' => 'disabled'])?>

 </div>
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'dni')->textInput(['disabled' => 'disabled']) ?>

 </div>
  <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
     <?= $form->field($model, 'domicilio')->textInput(['disabled' => 'disabled']) ?>

 </div>
   
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'celulares')->textInput(['disabled' => 'disabled']) ?>
 </div>        
          
     <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'fijos')->textInput(['disabled' => 'disabled']) ?>
 </div>        
              
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'correo')->textInput(['disabled' => 'disabled']) ?>
 </div>       
          
  
     
    <?php ActiveForm::end(); ?>

   <?php 
   if(count($dataProviders)>0){
       echo $this->render('_tabs',['model'=>$model,
                'dataProviders'=>$dataProviders,
                'codperiodo'=>$codperiodo]);
   }else{
       ?>
          <div class="alert alert-info"><?=yii::t('sta.labels','Este alumno no presenta riesgo academico')?></div>      
    <?php
   }
   
     ?>       
          
          
</div>
    </div>
