<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="box-body">
 <?php $form = ActiveForm::begin(); ?>
      

   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">     
  <?PHP
     echo $form->field($modelTallerdet, 'rank_tutor')->dropDownList(             
             \frontend\modules\sta\helpers\comboHelper::geCboRankTutor(),
             ['disabled'=>'disabled']);
      ?>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($modelTallerdet, 'detalle_tutor')->textArea(['disabled' => 'disabled']) ?>

 </div>
  
    <?php ActiveForm::end(); ?>

</div>     