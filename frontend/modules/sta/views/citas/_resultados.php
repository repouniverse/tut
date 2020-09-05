<div>
<?php 
 $idCitaEvalInicial=$model->idCitaFirstEvaluacion();
 if(is_null($idCitaEvalInicial)){
?>
    <div class="alert alert-info"><?=yii::t('sta.labels','Es posible que éste alumno no haya sido evaluado o aun falten procesar sus resultados')?></div>  
<?php 
 }else{
?>
<?php 
echo $this->context->renderPartial('_resultados_detalle',['tallerdet'=>$tallerdet,'model'=>$model,'nombre'=>$nombre,'vencida'=>$vencida,'idCitaEvalInicial'=>$idCitaEvalInicial]); 
 }
?>
    
    
</div>
