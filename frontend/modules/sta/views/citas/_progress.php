<?php
use yii\helpers\Html;
?>
<div class='progress' >
  <div class='progress-bar progress-bar-danger'
       role='progressbar' aria-valuenow='<?=$porcentaje?>'
  aria-valuemin='0' aria-valuemax='100' style='width:<?=$porcentaje?>%'>
    <?=$porcentaje?>% <?=\yii::t('sta.labels','Completado')?>
  </div>
    
    
</div>
<div id="examen_completado" style="back-color:red;"><?=$porcentaje?></div>