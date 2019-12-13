<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\sta\widgets\cbofacultades\cbofacultades;
use frontend\modules\sta\widgets\cboperiodos\cboperiodos;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;
 use kartik\date\DatePicker;
   use kartik\time\TimePicker;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="borereuccess">
   
    <?php 
     $canti=$model->countStudentsFree();
    $form = ActiveForm::begin(['id'=>'form-programa',
        'fieldClass'=>'\common\components\MyActiveField']); ?>
      <div class="box-header">
        
    </div>
      <div class="box-body">
        <?php 
      


        
        
            
           if($canti>0){ ?>
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="alert alert-warning"><?=yii::t('sta.messages','Quedan {cantidad} Alumnos sin tutor asignado',['cantidad'=>$canti])?>
                        </div>     
                    </div> 
            <?php } ?>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'numero')->textInput(['disabled' => 'disabled','maxlength' => true]) ?>

  </div>
 <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
      <?= $form->field($model, 'descripcion')->textInput(['disabled' => 'disabled','maxlength' => true]) ?>

  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= cbofacultades::widget(['model'=>$model,'attribute'=>'codfac', 'form'=>$form]) ?>
  </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?=cboperiodos::widget(['model'=>$model,'attribute'=>'codperiodo', 'form'=>$form]) ?>
  </div>     
          
          
          
         

  <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>2,
         'addCampos'=>[3,4,5],
        ]);  ?>

 </div> 
 <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra_psico',
         'ordenCampo'=>2,
         'addCampos'=>[3,4,5],
        ]);  ?>

 </div> 
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
     
      <?= $form->field($model, 'fopen')->textInput(['disabled' => 'disabled','maxlength' => true]) ?>

  

 </div>
          
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
     <?= $form->field($model, 'finicitas')->textInput(['disabled' => 'disabled','maxlength' => true]) ?>

  

 </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'fclose')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'tolerancia')->textInput(['disabled' => 'disabled','maxlength' => true]) ?>

 </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
           <?= $form->field($model, 'duracioncita')->textInput(['disabled' => 'disabled','maxlength' => true]) ?>

  </div>
  
  
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea(['disabled' => 'disabled',]) ?>

 </div>
    <?php ActiveForm::end(); ?>

</div>
    </div>
