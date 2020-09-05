
<?php 
 if($this->context->module->id=='sta'){ ?>
<li   class="dropdown user-menu">
    <a href="#" class="dropdown-toggle label-warning" data-toggle="dropdown">
   
  <?php echo yii::t('sta.labels','Periodo Activo').' :  '. $this->context->module->getCurrentPeriod(); ?>
  
    </a>
</li>
 <?php } ?>
    

