<?php
use yii\widgets\ActiveForm;
use yii;
?>
<?php $form = ActiveForm::begin(); ?>
<?php if($model->hasErrors()) {?>
   <div class="table-responsive">
     <table class="table no-margin"> 
         <thead><tr><th>Carencias</th></tr></thead>
  <?php foreach($model->getErrors()['id'] as $key=>$error){ 
      echo "<tr><td><span class='label label-danger'>".$error."</span></td></tr>";
   }
   ?>
     </table>
   </div>     
<?php }else{
    
    
    ?>
<div class="alert alert-success">
    <span class="fa fa-check" style="font-size:20px;">
</span><?=yii::t('sigi.labels','El edificio, ya tiene los datos completos')?>
</div>
<?php } ?>
     
 