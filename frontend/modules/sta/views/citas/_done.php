<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="alert alert-success">
    <?=yii::t('sta.labels','! Bien...!  Ahora sólo te falta confirmar tus respuestas')?>
    
     <?=Html::a('<span class="fa fa-check" ></span>'.'  '.yii::t('sta.labels','Confirmar Respuestas'),Url::to(['/sta/citas/termina-examen','id'=>$id]),['disabled'=>'disabled','id'=>'btn-conf-examen','class'=>"btn btn-warning"])?>
        
</div>
