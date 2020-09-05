<?php $this->registerJs("         
$('#boton-refrescar').on( 'click', function(){    
 $.pjax.reload({container: '#mi_maletin'});
 });
 ",\yii\web\View::POS_END);  
  ?>