<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
?>
     <?php $form = ActiveForm::begin(); ?>
      

        <?php //print_r($model->attributes);var_dump($model->facultad); die(); ?>

  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= Html::label(yii::t('base.names','Facultad'),'45545rret',['class' => 'control-label']) ?>
           <?php if( $model->hasProperty('facultad')){ ?>
            <?=  Html::input('text', 'namefacu', $model->facultad->desfac,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php } else { ?>
            <?=  Html::input('text', 'namefacu', $model->desfac,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php }  ?>
 </div>
  
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= Html::label(yii::t('base.names','Carrera'),'4u5545rret',['class' => 'control-label']) ?>
     <?php if( $model->hasProperty('carrera')){ ?>
            <?=  Html::input('text', 'namefacxu', $model->carrera->descar,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php } else { ?>
            <?=  Html::input('text', 'namefacxu', $model->descar,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php }  ?>
 </div>
   
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <?php if( $model->hasProperty('fullName')){ ?>
       <?= $form->field($model, 'nombres')->textInput(['value' =>$model->fullName(),'disabled' => 'disabled']) ?>
         <?php }else{ ?>
         <?= $form->field($model, 'nombres')->textInput(['value' =>$model->ap.'-'.$model->am.'-'.$model->nombres,'disabled' => 'disabled']) ?>
           <?php }  ?>
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
   
 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">    
 <?= \yii\helpers\Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-pencil"></span>'.yii::t('sta.labels','Editar Datos'), \Yii\Helpers\Url::to(['/sta/alumnos/update','id'=>$model->id]),['target'=>'_blank']) ?>
 </div>  
 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'celulares')->textInput(['disabled' => 'disabled']) ?>
 </div>        
          
     <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'fijos')->textInput(['disabled' => 'disabled']) ?>
 </div>        
              
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'correo')->textInput(['disabled' => 'disabled']) ?>
 </div>       
               
          
  
     
    <?php ActiveForm::end(); ?>

     
          
          

