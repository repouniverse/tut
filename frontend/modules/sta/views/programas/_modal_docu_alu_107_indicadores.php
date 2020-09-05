<?php

use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use frontend\modules\sta\models\Citas;

?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     //echo $form->field($model, 'indi_encont')->textarea();
      ?>
</div>
 <?php
   if($model->cita_id >0){
       echo ".";
      echo $this->render('_modal_grafico',['model'=>$model]);
   }
   
 ?>

