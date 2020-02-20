<?php
use yii\helpers\Html;
?>
<div class='progress' >
  <div class='progress-bar progress-bar-danger'
       role='progressbar' aria-valuenow='<?=$porcentaje?>'
  aria-valuemin='0' aria-valuemax='100' style='width:<?=$porcentaje?>%'>
    <?=$porcentaje?>% <?=\yii::t('sta.labels','Completado')?>
  
   <?php if(count( $itemsFaltantes)>0){?>
    <?=\yii::t('sta.labels','Faltan responder : ')?>
    <?php foreach($itemsFaltantes as $itemFaltante){
         echo "Ítem ".$itemFaltante['item']." de prueba [".$itemFaltante['codtest']."]    ,  ";
           }?>
   <?php }?>

  </div>
    
    
</div>
<div id="examen_completado" style="back-color:red;"><?=$porcentaje?></div>
