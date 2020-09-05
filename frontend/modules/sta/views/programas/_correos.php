<?php $form = \yii\widgets\ActiveForm::begin(); ?>
<?php
if($faltan){
    $listaCorreos=$model->correosProgramaFaltanList();
   
}else{
    
   $listaCorreos=$model->correosProgramaList(); 
}

echo $form->field($model, 'detalles')->textarea(['value'=>$listaCorreos,'rows'=>20]); ?> 
 <?php \yii\widgets\ActiveForm::end(); ?>
