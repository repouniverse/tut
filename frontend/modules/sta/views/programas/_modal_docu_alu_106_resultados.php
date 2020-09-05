<?php 
use yii\widgets\Pjax;
 use frontend\modules\sta\models\Citas;
 if($model->cita_id >0){
   Pjax::begin(['id'=>'plano_resultados']);
    //Pjax::widget();
    $cita=Citas::findOne($model->cita_id);
      $examenesId=$cita->examenesId();
     $resultados= \frontend\modules\sta\models\StaResultados::find()->
             join('INNER JOIN','{{%sta_testindicadores}} b','indicador_id=b.id')->orderBy('b.ordenabs ASC')
             ->andWhere(['examen_id'=>$examenesId])             
            ->orderBy('b.ordenabs ASC')->
             all();

     if(count($resultados)>0){
     ?>
<table>
 <?php

 
  foreach($resultados as $resultado) {  ?>
    <tr style="border-style:solid;border-color:#cccccc;border-width: 1px;">
        <td width='70%' style="color:blueviolet;padding:5px;"><?=$resultado->indicador->nombre?></td>
        <td>Nivel: </td>
        <td style="color:#7272ca; padding:5px;"><?=$resultado->categoria?></td>
    </tr>
    <tr>
        <td colspan="3"><?=$resultado->interpretacion?></td>
        
    </tr>
    <tr>
        <td width='70%'>.</td>
        <td>.</td>
        <td>.</td>
    </tr>
   <?php
   
   
  }?> 
</table>
   <?php }else{//Si no existe ningun resultado
       echo \yii\helpers\Html::button('<span class="fa fa-industry"></span>   '.Yii::t('sta.labels', 'Procesar'), ['id'=>'boton_procesa','class' => 'btn btn-success']);  
       
       }
   $string4="$('#boton_procesa').on( 'click', function(){ 
     
     
       $.ajax({
              url: '".\yii\helpers\Url::to(['/sta/citas/resultados','id'=>$cita->id])."', 
              type: 'get',
              data:{id:".$cita->id."},
              dataType: 'json', 
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

                             if ( !(typeof json['warning']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['warning']);
                              $.noty.setType(n.options.id, 'warning');  
                             } 
                          if ( !(typeof json['success']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['success']);
                              $.noty.setType(n.options.id, 'success');  
                              $.pjax.reload({container: '#plano-resultados'});
                              $
                             }      
                   
                        }
                        });


             })";
  $this->registerJs($string4, \yii\web\View::POS_END);
   Pjax::end();
   }else{ //Si no se asigno ninguna cita
    echo \yii::t('sta.labels','Este reporte requiere que asignes una cita con evaluaciones');   
 }
?>
<?php

?>
         
  
    
     
     
     

   

   

   

   
