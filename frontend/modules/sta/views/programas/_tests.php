<?php

use yii\helpers\Html,yii\helpers\Url;
 //use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use kartik\editable\Editable;
//use kartik\grid\GridView ;
use frontend\modules\sta\helpers\comboHelper;

?>

<br>

<button id="boton-procesa-batch" type="button" class="btn btn-success">
    <span class="glyphicon glyphicon-refresh"></span><?=yii::t('sta.labels','  Procesar resultados de las pruebas')?>
</button>
  <?php    $this->registerJs("
         
$('#boton-procesa-batch').on( 'click', function(){    
  $.ajax({ 
  
   method:'get',    
      url: '".\yii\helpers\Url::toRoute('/sta/citas/procesa-batch')."',
   delay: 250,
 data: {id:".$model->id."},
             error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(json) {  
                        var n = Noty('id');
                       if ( !(typeof json['error']==='undefined') ) {
                                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error'); 
                              }
                         if ( !(typeof json['success']==='undefined') ) {
                                        $.noty.setText(n.options.id, json['success']);
                             $.noty.setType(n.options.id, 'success');
                              } 
                               if ( !(typeof json['warning']==='undefined') ) {
                                        $.noty.setText(n.options.id, json['warning']);
                             $.noty.setType(n.options.id, 'warning');
                              } 
                             // $.pjax.defaults.timeout = false;  
                       // $.pjax.reload({container: '#grilla-minus'});
                        },
   cache: true
  })
 }
 
);",\yii\web\View::POS_END);  
  ?>
<br>
<br>